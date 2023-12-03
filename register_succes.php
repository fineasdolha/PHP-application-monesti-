<?php 
session_start();
require_once 'connection.php';
$db = new DAO();
$db -> connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Success</title>
</head>
<body>
    <section class="container my-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Well done!</h4>
        <p>Aww yeah, you successfully registered! To enter your account, <strong><a href="login.php">login now</a></strong> using the email and the password you provided before!</p>
        <hr>
        <p class="mb-0">Thank you for your confidence in us.</p>
    </div>
    </section>
<section class="d-flex justify-content-center align-items-end" style="min-height: 10em;">  
    <a href="login.php"><button type="button" style="width: 200px; height:110px; background:#ecb21f; font-size:2em;" class="btn m-5">Login</button></a>
    <a href="index.php"><button type="button" style="width: 200px; height:110px; background:#ecb21f; font-size:2em;" class="btn m-5">Return to homepage</button></a>
</section> 


</body>
</html>   