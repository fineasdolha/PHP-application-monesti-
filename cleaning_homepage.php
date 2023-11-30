<?php 
session_start();
require_once 'connection.php';
$db = new DAO();
$db -> connection();
$infoCleaner = $db -> getCleaningStaff($_SESSION['user_email']);

// Then call the date functions
date_default_timezone_set("Europe/Paris");
$date = new DateTime('now');

// echo $date->format('Y-m-d');


$iduser=$infoCleaner[0][0];


$curentdate= $date->format('Y/m/d h:s');
$dateMessage= $date->format('m/d/Y');
// echo $date->timezone_type . PHP_EOL;

if(isset($_POST['workdone'])){
  $sql="INSERT INTO `interventions`(`id_intervention`, `id_user`, `time_stamp`) 
  VALUES ('[value-1]','$iduser','$curentdate')";
  $db -> prepExec($sql);
  // header('location:cleaning_homepage.php');

} 


if(isset($_POST['timePeriod'])){
  $timeSpend=$_POST['timePeriod'];
  $sql="UPDATE `interventions` SET `time_spend`='$timeSpend' ORDER BY id_intervention DESC LIMIT 1";
  $db -> prepExec($sql);
  print($timeSpend);
  $_SESSION['message']= "CONGRATULATION ! You've juste register your work";
 
 header('location:cleaning_homepage.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Homepage_cleaning</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
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
    <a class="nav-link" href="#">Log out</a>
    </span>
  </div>
</nav>  
<section class="jumbotron jumbotron-fluid">
  <article class="container my-5">
    <h1 class="display-4">Hello,  <?php print ($_SESSION['first_name']); ?> <?php print ($_SESSION['last_name']); ?> !</h1>
</article>
<article class="container my-5">
    <h6 class="display-6">Did you work today ?</h6>
    <form id='formClean' class="lead" method="post" action=''>
    <button class="btn btn-primary" type="submit"
     <?php if($_SESSION['message']){ ?>
disabled 
     <?php } ?>
    
     
     onchange="this.form.submit()"  name="workdone" id='workdone'>WORK DONE</button>
    
    <?php if(isset($_POST['workdone']) && isset($_POST['timePeriod'])==null){ ?> 
      <select  name="timePeriod" onchange="this.form.submit()">
      <option value='30 min'>30 min</option>
      <option value='1h30'>1h30</option>
      <option value='2h'>2</option>
      <option value='2h30'>2h30</option>
      <option value='3h'>3h</option>
      <option value='3h30'>3h30</option>
      <option value='4h'>4h</option>
    </select>
    <?php } ?>
    </form class="lead">
     
    <p class="lead"> <?php print ($_SESSION['message']."' for the '".$dateMessage); ?>  </p>
    
</article>
<article class="container my-5">
    <p class="lead"> I am a member of the <?php print($infoAssociation['name_association']);?> association</p>
    <p class="lead"> based in <?php print($infoAssociation['city_association']);?> at the address <?php print ($infoAssociation['address_association']);?></p>
    <p class="lead"> in the <?php print ($_SESSION['user_type']);?> departement</p>
</article>
</section>
<section>

</section id="reservationsArea">
<table id="reservationTable"></table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script type="text/javascript" src="script.js"></script>
</body>
</html>

