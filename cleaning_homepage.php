<?php 
session_start();
require_once 'connection.php';
$db = new DAO();
$db -> connection();
$infoAssociation = $db -> getUserAsociation($_SESSION['id_association'], $_SESSION['id_user']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Home</title>
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
    <h1 class="display-4">Hello, <?php print ($_SESSION['first_name']); ?> !</h1>
    <p class="lead">It is surely nice to have you back.</p>
</article>
<article class="container my-5">
    <h6 class="display-6">About me</h6>
    <p class="lead"> My name is <?php print ($_SESSION['first_name']); print(' '); print($_SESSION['last_name']);?> </p>
    <p class="lead"> Registered e-mail: <?php print ($_SESSION['user_email']);?> </p>
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

</body>
</html>

