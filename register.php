<?php 
      session_start();
      require_once("connection.php");
      $db = new DAO();
      $db -> connection();
      $sqlassoc = $db -> getAssociations();
      $associationList = $db -> queryRequest($sqlassoc);
              
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Register</title>
</head>
<body>
<!-- // s’il existe, on affiche le message d’erreur -->
    <?php if(isset($_SESSION['message-error'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message-error']; 
                
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>  
    <?php } ?>
    <figure class="text-center">
    <h1>Register <sub>below</sub></h1>
    </figure>
    <!-- // formulaire en méthode post qui cible la page register_check.php
// pour récupérer les données des nouveaux utilisateurs et pour ensuite pouvoir les tester
// on établit d’abord que ce formulaire est réservé aux nouveaux utilisateurs des associations 
// assurer que la mairie gère l’accès aux utilisateurs de l’administration
// pour ajouter un autre type d’utilisateur (admin,cleaning) il faut se connecter avec un //compte d’administrateur -->

<form action="register_check.php" method="POST" class="container" style="max-width: 500px;">
  <div class="mb-3">
    <label for="firstName" class="form-label">First name</label>
    <input name="firstname" type="text" class="form-control" id="firstName" required> 
  </div>
  <div class="mb-3">
    <label for="lastName" class="form-label">Last name</label>
    <input name="lastname" type="text" class="form-control" id="lastName" required> 
  </div>
  <div class="mb-3">
    <label for="inputEmail" class="form-label">Email address</label>
    <input name="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" required>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label  for="inputPassword1" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="inputPassword1" required>
  </div>
  <label for="radio-container" class="form-label my-2">You are registering as :</label>
  <div id="radio-container" class="d-flex justify-content-start p" >
  <!-- <div class="form-check mr-2 my-2">
  <input onchange="disableSelect()" class="form-check-input" type="radio" name="entity" id="admin" value="admin" required>
  <label class="form-check-label" for="admin">
    Admin
  </label>
</div> -->
<div class="form-check m-2 my-2 ">
  <input  class="form-check-input" type="radio" name="entity" checked id="association" value="association" required>
  <label class="form-check-label" for="association">
    Association
  </label>
</div>
<!-- <div class="form-check m-2 my-2">
  <input onchange="disableSelect()" class="form-check-input" type="radio" name="entity" id="cleaning" value="cleaning" required>
  <label class="form-check-label" for="cleaning">
  Cleaning
  </label>
</div> -->
</div>
<div class="mb-3">
         <label for="association-choice">What is the name of your association?</label>
         <select id="association-choice" class="form-control " name="association-choice" required>
         <option value="">Choose an option</option>
         <!-- <option id='choice-none' value="0">None</option> -->
         <?php foreach($associationList as $row){?>
              
             <option value="<?php print $row['id_association'];?>"><?php print $row['name_association'];?></option>
             <?php } ?>
        </select>
    </div>


  <button style="background:#ecb21f; font-size:1em" name="login" type="submit" class="btn">Register</button>
</form>
<section class="d-flex justify-content-center align-items-end" style="min-width: 50em;">  
    <a href="index.php"><button type="button" style="background:#ecb21f; font-size:1em; width: 200px; height:80px;" class="btn m-5">Return to homepage</button></a>
    <a href="login.php"><button type="button" style="background:#ecb21f; font-size:1em; width: 200px; height:80px;" class="btn m-5">Already signed up? Log in!</button></a>
</section>  
 <?php if(isset($_SESSION['message-error'])){$_SESSION['message-error']=null;} ?> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    
<script src='script.js'></script>
</body>
</html>