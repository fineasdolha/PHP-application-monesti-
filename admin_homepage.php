<?php 
session_start();
require_once 'connection.php';
$db = new DAO();
$db -> connection();

//je recupere info depuis la class dao l'userid du personnel de menage apres sa connection
$infoAdmin = $db->getAdminInfo($_SESSION['user_email']);

// je recupere info string du tableau pour pouvoir faire INSERT
$iduser = $infoAdmin[0][0];
//categorie de la personne admin,cleaning assoc.
$usertype = $infoAdmin[0][3];
//categorie de destination comment admin,cleaning assoc.
$commenttype = $infoAdmin[0][12];
var_dump($iduser);

//j'appelle la date du jour
date_default_timezone_set("Europe/Paris");
$date = new DateTime('now');
//cette date est mise au format pour entrer dans base de donnée
$curentdate = $date->format('Y/m/d h:s');
// je change le format pour l'afficher sur html
$dateMessage = $date->format('m/d/Y');
//pour changer de formulaire d'envoi en fonction reponse ou nouveau message variable pour condition
$disapear=false;


// en cliquant sur bouton logout je detruit les variables sessions et je reviens a la page de demarrage
if (isset($_POST['logout'])) {
  session_destroy();
  header('location:index.php');
}

//si la personne fait partie de l'equipe cleaning alors elle peux voir les commentaires selectionnés.
if ($usertype == 'admin') {
  $arrayComment = $db->getCommentsAdmin($usertype);
  $elementComment = $db->queryRequest($arrayComment);
  $dateComment = explode('-', $elementComment[0]['time_stamp']);
  $day = explode(' ', $dateComment[2]);
  $_SESSION['time_stamp'] = $day[0] . "/" . $dateComment[1] . "/" . $dateComment[0];
}

if (isset($_POST['msg'])) {
  if($disapear==false){
    $description = $_POST['msg'];
    $destination = $_POST['optradio'];
    $sql = "INSERT INTO `comments`( `description`, `id_user`, `destination`, `time_stamp`) 
    VALUES ('$description','$iduser','$destination','$curentdate')";
    $db->prepExec($sql);
    $disapear=false;
    header('location:admin_homepage.php');
  }else{
  $description = $_POST['msg'];
  $destination = $_POST['optradio'];
  $incrementCommentId=1+$commentid;
  $sql = "INSERT INTO `comments`(`id_comment`, `comment_id`, `description`, `id_user`, `time_stamp`)
   VALUES ('6','1','$description','$iduser','$curentdate')";
  $db->prepExec($sql);
  var_dump( $incrementCommentId);
  $disapear=false;
  header('location:admin_homepage.php');
}}

if(isset($_POST['reply'])){
  $disapear=true;
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">    
    <title>Administration Monestié</title>
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
          <a class="nav-link" href="logout.php" style="background:#ecb21f; font-size:1em"><button name='logout' class='btn' type='submit'>Log out</button></a>
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

<section class="container">
              <h1>Calendar</h1>
              <a href="calendar/calendar.php"><button class="btn" style="background:#ecb21f; font-size:1em;margin-bottom:10px">View reservations calendar</button></a>
</section>  


    <hr>
    <section>

      <div class="container">
        <div class="row">
          <div class="col-sm-5 col-md-6 col-12 pb-4">
            <h1>Conversations</h1>
            <?php foreach ($elementComment as $row) { ?>
              <div class="darker mt-4 text-justify">
                <!-- //si on veut ajouter un avatar aux utilisateurs -->
                <img src="https://i.imgur.com/yTFUilP.jpg" alt="avatar" class="rounded-circle" width="40" height="40">
                <h4><?php print $row['first_name']; ?></h4>
                <p><?php print $row['description']; ?></p><br>
                <form method="post">
                  <button type="submit" style="background:#ecb21f; font-size:0.7em;margin-bottom:10px" name='reply' id='reply' class="btn" onchange="this.form.submit()">
                    <span style="color:black">REPLY</span>
                  </button>
                </form>
                <span>sent : <?php print $_SESSION['time_stamp']; ?></span><br>
              </div>
              

            <?php } ?>
          </div>

          <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
            <form id="algin-form" method="post" 
            <?php if($disapear==false){ ?>hidden <?php } ?>
            >
              <div class="darker mt-4 text-justify">
                <div class="form-group">
                  <h4>Leave a message</h4>
                  <textarea name="msg" maxlength="60" cols="30" rows="5" class="form-control text-light" style="background-color: black;"></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" onchange="this.form.submit()" id="post" class="btn">Post Reply</button>
                </div>
              </div>
            </form> 

            <form id="algin-form" method="post" <?php if($disapear==true){ ?>hidden <?php } ?>>
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
                  <button type="submit" onchange="this.form.submit()" id="postinfo" name="postinfo" class="btn">Post Message</button>
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