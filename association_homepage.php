<?php
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
//je recupere info depuis la class dao l'userid du personnel de menage apres sa connection
$infoPerson = $db->getAssocInfo($_SESSION['user_email']);
$_SESSION['homepage']='association_homepage.php';
// je recupere info string du tableau pour pouvoir faire INSERT
$iduser = $infoPerson[0][0];
//categorie de la personne admin,cleaning assoc.
$usertype = $infoPerson[0][3];
//categorie de destination comment admin,cleaning assoc.
$userassociation = $infoPerson[0][6];
//nom assoc user
$userAssocid=$infoPerson[0]['id_association'];

//id comment .
$idcomment = $infoPerson[0][7];
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

//requete pour recup info doc pour gestion carousel
$arrayDocsAssoc = $db->getDocAssoc($userAssocid);
$elementDocAssoc = $db->queryRequest($arrayDocsAssoc);

//si on clique sur bouton reply et on recupère les valeurs des input du commentaire choisi
if (isset($_POST['reply'])) {
  $_SESSION['disapear'] = 1;
  $_SESSION['id'] = $_POST['parent_id'];
  $_SESSION['destinat'] = $_POST['parentDestinat'];
  $_SESSION['idAssoc']=$_POST['parentassociation'];
}


// ecrire un nouveau commentaire avec recuperation valeur et donne valeur pour disapear faire apparaitre soit l'un
//soit l'autre des formuaires
if (isset($_POST['postinfo'])) {
  if ($_SESSION['disapear'] == 0) {
    $description = str_replace("'", "\'", $_POST['msg']);
    $destination = $_POST['optradio'];
    $sql = "INSERT INTO `comments`( `description`, `id_user`, `destination`, `time_stamp`,`association_id`) 
      VALUES ('$description','$iduser','$destination','$curentdate','$userassociation')";
    $db->prepExec($sql);
    $_SESSION['disapear'] = 0;
    header('location:association_homepage.php');
  }


}
if (isset($_POST['msgreply'])) {
  $destinat = $_SESSION['destinat'];
  $description = str_replace("'", "\'", $_POST['msgreply']);
  $id = $_SESSION['id'];
  $idAssoc=$_SESSION['idAssoc'];
  var_dump($_SESSION['idAssoc']);
  //je récupère id_comment pour mettre dans la clefs secondaire. si je répond au comment1 alors les reponses auront comment_id 1
  $sql = "INSERT INTO `comments`( `comment_id`, `description`, `id_user`, `destination`, `time_stamp`,`association_id`)
     VALUES ('$id','$description','$iduser','$destinat','$curentdate','$idAssoc')";
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
$_SESSION['homepage']='association_homepage.php';

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
          <a class="nav-link active ">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calendar/calendar.php">Calendar</a>
        </li>
      </ul>
      <span class="navbar-text">
        <form method="post">
          <a class="nav-link" href="logout.php" style="background:#ecb21f; font-size:1em">Log out</a>
        </form>
      </span>
    </div>
  </nav>

  <section>
    <section class="row ">
      <article class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 mt-4 ">
        <h1 class=" pl-2 text-light " id="bienvenu"><span>Hello !<?php print($_SESSION['first_name']); ?> <?php print($_SESSION['last_name']); ?></span></h1>
      </article>
      <article>
      <div class="bd-example">
  <div id="carouselExampleCaptions" class="carousel slide multi-item-carousel" data-ride="carousel">

    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
    <!--pour que la caroussel fonctionne il faut mettre active sur la première affiche donc ele ne sera activé que sur la première-->
    <?php $iteration=0;
    foreach($elementDocAssoc as $row){?>
      <div class="carousel-item 
      <?php if($iteration==0){ ?>
      active
      <?php }?>
      ">
        <div class="item__third">
          <img src="calendar/<?php print $row['file']; ?>" class="d-block mx-auto" style="width:300px;margin-bottom:160px" alt="">
          
          <div class="carousel-caption d-none d-md-block">
            <h5><?php print $row['title']; ?></h5>
            <p><?php print $row['description']; ?></p>
          </div>
        </div>
      </div>
      <?php $iteration++ ?>
      <?php } ?>
   
    </div>

    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

  </div>
</div>
      </article>
    </section>
    <hr>
    
    <section>
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-5 col-lg-5 text-light">
          <h1>Conversations</h1>

<?php foreach ($elementComment as $row) {
  $idComent = $row['id_comment'];
  
  if ($row['id_comment'] != null  && $userassociation == $row['association_id']) {?>
    <form method="post">
      <div class="darker mt-4 text-justify ">
        <!-- //si on veut ajouter un avatar aux utilisateurs -->
        <img src="https://i.imgur.com/yTFUilP.jpg" alt="avatar" class="rounded-circle" width="40" height="40">
        <h4 class="text-light"><?php print $row['first_name']; ?> <?php print $row['last_name']; ?></h4>
        <p><?php print $row['description']; ?></p><br>
        <input type="hidden" name="parentassociation" value="<?php print $row['association_id']; ?>">
        <input type="hidden" name="parentDestinat" value="<?php print $row['user_type']; ?>">
        <input type="hidden" name="parent_id" value="<?php print $row['id_comment']; ?>">
        <span>sent : <?php print $_SESSION['time_stamp']; ?></span><br>
        <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px" name='reply' id='<?php print $row['id_comment']; ?>' class="btn" onchange="this.form.submit()">
          REPLY
        </button>
      </div>
    </form>
    <div>
      <?php foreach ($elementResponse as $row) {
        if ($idComent == $row['comment_id']) { ?>
          <div class="darker mt-4 text-end response">
            <!-- //si on veut ajouter un avatar aux utilisateurs -->
            <img src="https://i.imgur.com/yTFUilP.jpg" alt="avatar" class="rounded-circle" width="40" height="40">
            <h4><?php print $row['first_name']; ?> <?php print $row['last_name']; ?></h4>
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
          <div class="col-12 col-sm-12 col-md-7 col-lg-7">
            <form id="algin-form" method="post" <?php if ($_SESSION['disapear'] == 0) { ?>hidden <?php } ?>>
              <div class="darker mt-4 text-justify">
                <div class="form-group">
                  <h4 class="text-light ">Leave a message</h4>
                  <textarea required name="msgreply" maxlength="60" cols="30" rows="5" class="form-control text-light" style="background-color: black;"></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" name="replybutton" onchange="this.form.submit()" class="btn" style="background:#ecb21f ;padding-top:5px;padding-bottom:5px; font-size:0.7em;margin-bottom:10px; margin-top:10px">POST REPLY</button>
                  <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px; margin-top:10px" name='cancelReply' class="btn" onchange="this.form.submit()">CANCEL REPLY</button>
                </div>
              </div>
            </form>
            <form id="algin-form" method="post" <?php if ($_SESSION['disapear'] == 1) { ?>hidden<?php } ?>>
              <div class="darker mt-4 text-justify">
                <div class="form-group">
                  <h4 class="text-light ">Leave a message</h4>
                  <textarea required name="msg" maxlength="60" cols="30" rows="5" class="form-control text-light" style="background-color: black;"></textarea>
                </div>
                <label>Choose your recipient</label>
                <div class="form-check text-light ">
                  <input required type="radio" class="  form-check-input" id="radio1" name="optradio" value="admin">Administrator
                  <label class=" form-check-label" for="radio1"></label>
                </div>
                <div class="form-check text-light">
                  <input required type="radio" class="form-check-input" id="radio2" name="optradio" value="association">My association
                  <label class="form-check-label" for="radio2"></label>
                </div>
                <div class="form-check text-light">
                  <input required type="radio" class="form-check-input" id="radio3" name="optradio" value="cleaning">Cleaning staff
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
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</body>

</html>