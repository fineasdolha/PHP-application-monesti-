<?php
//pour appeler les variables sessions sur cette page et donc ici le nom et prenom du salarié
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
//je recupere info depuis la class dao l'userid du personnel de menage apres sa connection
$infoCleaner = $db->getCleaningStaff($_SESSION['user_email']);

// je recupere info string du tableau pour pouvoir faire INSERT
$iduser = $infoCleaner[0][0];
//categorie de la personne admin,cleaning assoc.
$usertype = $infoCleaner[0][3];
//id comment .
$idcomment = $infoCleaner[0][7];
//j'appelle la date du jour
date_default_timezone_set("Europe/Paris");
$date = new DateTime('now');
//cette date est mise au format pour entrer dans base de donnée
$curentdate = $date->format('Y/m/d h:s');
// je change le format pour l'afficher sur html
$dateMessage = $date->format('m/d/Y');
//pour changer de formulaire d'envoi en fonction reponse ou nouveau message variable pour condition
$_SESSION['disapear'] = 0;
// en cliquant sur bouton logout je detruit les variables sessions et je reviens a la page de demarrage
if (isset($_POST['logout'])) {
  session_destroy();
  header('location:index.php');
}
// je clique sur le bouton workdone cela insert dans BDD l'id de la personne qui l'utilise et la date/heure du jour
if (isset($_POST['workdone'])) {
  $sql = "INSERT INTO `interventions`(`id_user`, `time_stamp`) 
  VALUES ('$iduser','$curentdate')";
  $db->prepExec($sql);
}

//pour annuler workdone
// print ($hide);
if (isset($_POST['cancelWork']) && isset($_POST['workdone'])) {
  print('bobo');
  $sql = "DELETE FROM `interventions` WHERE id_user IN ($iduser) ORDER BY id_intervention DESC limit 1;";
  $db->prepExec($sql);
  $_SESSION['message1'] = null;
  $_POST['workdone'] = null;
  $_POST['timePeriod'] = '';
  header('location:cleaning_homepage.php');
}


// sur le select je choisi un temps de travail que je viens update a mon workdone
//puis je creer un message qui indiqueque le travail est réalisé
//enfin je reinitialise la page pour eviter les renvoi de formulaire afin d'eviter les ajouts supplementaires dans la BDD
if (isset($_POST['timePeriod']) && isset($_SESSION['message1']) == '') {
  $timeSpend = $_POST['timePeriod'];
  $sql = "UPDATE `interventions` SET `time_spend`='$timeSpend' ORDER BY id_intervention DESC LIMIT 1";
  $db->prepExec($sql);
  $_SESSION['message1'] = "CONGRATULATION ! You've juste register your work";

  header('location:cleaning_homepage.php');
}

// en cliquant sur bouton logout je detruit les variables sessions et je reviens a la page de demarrage
if (isset($_POST['logout'])) {
  session_destroy();
  header('location:index.php');
}

//si la personne fait partie de l'equipe cleaning alors elle peux voir les commentaires selectionnés.
if ($usertype == 'cleaning') {
  $arrayComment = $db->getCommentsCleaning($usertype);
  $elementComment = $db->queryRequest($arrayComment);
  //recupere sql pour les réponses car order different
  $arrayResponse = $db->getCommentsResponse($usertype);
  $elementResponse = $db->queryRequest($arrayResponse);
  //je met la date au format americain
  $dateComment = explode('-', $elementComment[0]['time_stamp']);
  $day = explode(' ', $dateComment[2]);
  $_SESSION['time_stamp'] = $day[0] . "/" . $dateComment[1] . "/" . $dateComment[0];
}

if (isset($_POST['reply'])) {
  $_SESSION['disapear'] = 1;
  $_SESSION['id'] = $_POST['parent_id'];
  $_SESSION['destinat'] = $_POST['parentDestinat'];
}



if (isset($_POST['postinfo'])) {
  if ($_SESSION['disapear'] == 0) {
    $description = str_replace("'", "\'", $_POST['msg']);
    $destination = $_POST['optradio'];
    $sql = "INSERT INTO `comments`( `description`, `id_user`, `destination`, `time_stamp`) 
      VALUES ('$description','$iduser','$destination','$curentdate')";
    $db->prepExec($sql);
    $_SESSION['disapear'] = 0;
    header('location:association_homepage.php');
  }
}
if (isset($_POST['msgreply'])) {
  $destinat = $_SESSION['destinat'];
  $description = str_replace("'", "\'", $_POST['msgreply']);
  $id = $_SESSION['id'];
  //je récupère id_comment pour mettre dans la clefs secondaire. si je répond au comment1 alors les reponses auront comment_id 1
  $sql = "INSERT INTO `comments`( `comment_id`, `description`, `id_user`, `destination`, `time_stamp`)
     VALUES ('$id','$description','$iduser','$destinat','$curentdate')";
  $db->prepExec($sql);
}
//pour ne pas recharger la page une fois la réponse envoyée
if (isset($_POST['replybutton'])) {
  header('location:association_homepage.php');
}

//pour retourner au formulaire new comment si on ne veux plus répondre à un message en particulier
if (isset($_POST['cancelReply'])) {
  $_SESSION['disapear'] = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="style.css" rel="stylesheet">
  <title>Homepage_cleaning</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark px-5" style="border:1px solid white">
    <a class="navbar-brand" href="#">Monestié</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Work</a>
        </li>
      </ul>
      <span class="navbar-text">
        <form method="post">
          <a class="nav-link" href="#" style="background:#ecb21f; font-size:1em"><button name='logout' class='btn' type='submit' onchange='this.form.submit()'>Log out</button></a>
        </form>
      </span>
    </div>
  </nav>


  <section>
    <section class="row ">
      <article class=" col-sm-12 col-md-12 col-12 ">
        <h1 class=" pl-2 " id="bienvenu">Hello ! <?php print($_SESSION['first_name']); ?> <?php print($_SESSION['last_name']); ?></h1>
      </article>
      <article class="col-sm-12 col-md-12 col-12">
        <form id="formClean" method="post">
          <div class="darker mt-4 text-justify">
            <div class="lead row ">
              <h3 class="display-8 text-light">Did you work today ?</h3>
              <div>
                <button class="btn" style="background:#ecb21f; font-size:1em;margin-bottom:10px" type="submit" <?php if (isset($_POST['workdone']) && isset($_POST['timePeriod']) == null || isset($_POST['cancelWork']) == '') {
                                                                                                                ?> disabled <?php }
                                                                                                                            ?> onchange="this.form.submit()" name="workdone" id='workdone'>WORK DONE</button>
              </div>
              <div>
                <?php if (isset($_POST['workdone']) && isset($_POST['timePeriod']) == null) { ?>
                  <select name="timePeriod" onchange="this.form.submit()" required>
                    <option value=''>how many hours ?</option>
                    <option value='30 min'>30 min</option>
                    <option value='1h30'>1h30</option>
                    <option value='2h'>2</option>
                    <option value='2h30'>2h30</option>
                    <option value='3h'>3h</option>
                    <option value='3h30'>3h30</option>
                    <option value='4h'>4h</option>
                  </select>
                <?php } ?>
              </div>
              <?php if (isset($_POST['cancelWork']) == '' && isset($_POST['timePeriod'])) { ?>
                <div class="alert alert-warning alert-dismissible fade show darker" role="alert">
                  <p class="lead"> <?php print("CONGRATULATION !") ?><br> <?php print("You've been working the " . $dateMessage); ?> </p>
                  <form method="post">
                    <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px" name='cancelWork' id='cancel' class="btn" onchange="this.form.submit()">
                      <span style="color:black">CANCEL RECORD</span>
                    </button>
                  </form>
                </div>
              <?php } ?>

            </div>
          </div>
        </form>

      </article>
    </section>
    <hr>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-5 col-lg-5">
            <h1>Conversations</h1>
            <?php
            foreach ($elementComment as $row) {
              $idComent = $row['id_comment'];
              if ($row['id_comment'] != null && $row['comment_id'] == 0) { ?>
                <form method="post">
                  <div class="darker mt-4 text-justify">
                    <!-- //si on veut ajouter un avatar aux utilisateurs -->
                    <img src="https://i.imgur.com/yTFUilP.jpg" alt="avatar" class="rounded-circle" width="40" height="40">
                    <h4><?php print $row['first_name']; ?></h4>
                    <p><?php print $row['description']; ?></p><br>
                    <input type="hidden" name="parentDestinat" value="<?php print $row['destination']; ?>">
                    <input type="hidden" name="parent_id" value="<?php print $row['id_comment']; ?>">
                    <span>sent : <?php print $_SESSION['time_stamp']; ?></span><br>
                    <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px" name='reply' id='reply' class="btn" onchange="this.form.submit()">
                      <span style="color:black">REPLY</span>
                    </button>
                  </div>
                </form>
                <div>
                  <?php foreach ($elementResponse as $row) {
                    if ($idComent == $row['comment_id']) { ?>
                      <div class="darker mt-4 text-end response">
                        <!-- //si on veut ajouter un avatar aux utilisateurs -->
                        <img src="https://i.imgur.com/yTFUilP.jpg" alt="avatar" class="rounded-circle" width="40" height="40">
                        <h4><?php print $row['first_name']; ?></h4>
                        <p><?php print $row['description']; ?></p><br>
                        <span>sent : <?php print $_SESSION['time_stamp']; ?></span><br>
                      </div>
                  <?php }
                  } ?>
                <?php } ?>
              <?php } ?>
                </div>
          </div>
          <div class="col-12 col-sm-12 col-md-7 col-lg-7">
            <form id="algin-form" method="post" <?php if ($_SESSION['disapear'] == 0) { ?>hidden <?php } ?>>
              <div class="darker mt-4 text-justify">
                <div class="form-group">
                  <h4>Leave a message</h4>
                  <textarea name="msgreply" maxlength="60" cols="30" rows="5" class="form-control text-light" style="background-color: black;"></textarea>
                </div>
                <div class="form-group">
                  <button name="replybutton" type="submit" onchange="this.form.submit()" id="post" class="btn">Post Reply</button>
                  <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px; margin-top:10px" name='cancelReply' class="btn" onchange="this.form.submit()">CANCEL REPLY</button>

                </div>
              </div>

            </form>
            <form id="algin-form" method="post" <?php if ($_SESSION['disapear'] == 1) { ?>hidden <?php } ?>>
              <div class="darker mt-4 text-justify">
                <div class="form-group">
                  <h4>Leave a message</h4>
                  <textarea name="msg" maxlength="60" cols="30" rows="5" class="form-control text-light" style="background-color: black;"></textarea>
                </div>
                <label>Choose your recipient</label>
                <div class="form-check text-light ">
                  <input type="radio" class="  form-check-input" id="radio1" name="optradio" value="admin">Administrator
                  <label class=" form-check-label" for="radio1"></label>
                </div>
                <div class="form-check text-light">
                  <input type="radio" class="form-check-input" id="radio2" name="optradio" value="association">My association
                  <label class="form-check-label" for="radio2"></label>
                </div>
                <div class="form-check text-light">
                  <input type="radio" class="form-check-input" id="radio3" name="optradio" value="cleaning">Cleaning staff
                  <label class="form-check-label" for="radio3"></label>
                </div>

                <div class="form-group">
                  <button type="submit" onchange="this.form.submit()" id="post" name="postinfo" class="btn">Post Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script type="text/javascript" src="script.js"></script>
</body>