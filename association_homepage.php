<?php
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
//je recupere info depuis la class dao l'userid du personnel de menage apres sa connection
$infoPerson = $db->getAssocInfo($_SESSION['user_email']);

// je recupere info string du tableau pour pouvoir faire INSERT
$iduser = $infoPerson[0][0];
//categorie de la personne admin,cleaning assoc.
$usertype = $infoPerson[0][3];
//categorie de destination comment admin,cleaning assoc.
$userassociation = $infoPerson[0][6];
//id comment .
$idcomment= $infoPerson[0][7];
//j'appelle la date du jour
date_default_timezone_set("Europe/Paris");
$date = new DateTime('now');
//cette date est mise au format pour entrer dans base de donnée
$curentdate = $date->format('Y/m/d h:s');
// je change le format pour l'afficher sur html
$dateMessage = $date->format('m/d/Y');
//pour changer de formulaire d'envoi en fonction reponse ou nouveau message variable pour condition (pou activer ou non les hidden en html)

$_SESSION['disapear'] = 0;
// en cliquant sur bouton logout je detruit les variables sessions et je reviens a la page de demarrage
if (isset($_POST['logout'])) {
  session_destroy();
  header('location:index.php');
}

//si la personne fait partie de l'equipe cleaning alors elle peux voir les commentaires selectionnés.
if ($usertype == 'association') {
  $arrayComment = $db->getCommentsAsso($usertype);
  $elementComment = $db->queryRequest($arrayComment);
  //recupere sql pour les réponses car order different
  $arrayResponse = $db->getCommentsResponse($usertype);
  $elementResponse = $db->queryRequest($arrayResponse);
  //je met la date au format americain
  $dateComment = explode('-', $elementComment[0]['time_stamp']);
  $day = explode(' ', $dateComment[2]);
  $_SESSION['time_stamp'] = $day[0] . "/" . $dateComment[1] . "/" . $dateComment[0];
}

//si on clique sur bouton reply et on recupère les valeurs des input du commentaire choisi
if (isset($_POST['reply'])) {
  $_SESSION['disapear'] = 1;
  $_SESSION['id'] = $_POST['parent_id'];
  $_SESSION['destinat'] = $_POST['parentDestinat'];
}


// ecrire un nouveau commentaire avec recuperation valeur et donne valeur pour disapear faire apparaitre soit l'un
//soit l'autre des formuaires
if (isset($_POST['postinfo'])) {
  if ($_SESSION['disapear'] == 0) {
    $description =str_replace("'","\'",$_POST['msg']);
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
  $description = str_replace("'","\'",$_POST['msgreply']);
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
  <title>Home</title>
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


  <section class="jumbotron jumbotron-fluid">
    <section class="row ">
      <article class=" col-sm-12 col-md-12 col-12 ">
        <h1 class=" pl-2 " id="bienvenu">Hello ! <?php print($_SESSION['first_name']); ?> <?php print($_SESSION['last_name']); ?></h1>
      </article>

    </section>
    <hr>
    <section>

      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-8 col-12 pb-4 pr-2 d-flex">
            <h1>Conversations</h1>
            <div class=" pb-4 pr-2 d-inline-flex">
              <?php
              foreach ($elementComment as $row) {
                $idComent = $row['id_comment']; 
                if ($row['id_comment'] != null && $row['comment_id'] == 0 && $userassociation == $row['id_association'] ) { ?>
                  <form method="post">
                    <div class="darker mt-4 text-justify ">
                      <!-- //si on veut ajouter un avatar aux utilisateurs -->
                      <img src="https://i.imgur.com/yTFUilP.jpg" alt="avatar" class="rounded-circle" width="40" height="40">
                      <h4><?php print $row['first_name']; ?></h4>
                      <p><?php print $row['description']; ?></p><br>
                      <input type="hidden" name="parentDestinat" value="<?php print $row['destination']; ?>">
                      <input type="hidden" name="parent_id" value="<?php print $row['id_comment']; ?>">
                      <span>sent : <?php print $_SESSION['time_stamp']; ?></span><br>
                      <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px" name='reply' id='<?php print $row['id_comment']; ?>' class="btn" onchange="this.form.submit()">
                        <span style="color:black">REPLY</span>

                      </button>
                    </div>
                  </form>
            </div>
            <div>
              <?php
                  foreach ($elementResponse as $row) {
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
        </div>
      </div>

        <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
          <form id="algin-form" method="post" <?php if ($_SESSION['disapear'] == 0) { ?>hidden <?php } ?>>
            <div class="darker mt-4 text-justify">
              <div class="form-group">
                <h4>Leave a message</h4>
                <textarea name="msgreply" maxlength="60" cols="30" rows="5" class="form-control text-light" style="background-color: black;"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" name="replybutton" onchange="this.form.submit()" class="btn" style="background:#ecb21f;padding-top:5px;padding-bottom:5px; font-size:0.7em;margin-bottom:10px; margin-top:10px">POST REPLY</button>
                <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px; margin-top:10px" name='cancelReply' class="btn" onchange="this.form.submit()">CANCEL REPLY</button>
                        
              </div>
            </div>
          </form>

          <form id="algin-form" method="post" <?php if ($_SESSION['disapear'] == 1) { ?>hidden<?php } ?>>
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
                <button type="submit" onchange="this.form.submit()" id="postinfo" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px" name="postinfo" class="btn">Post Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>

</body>

</html>