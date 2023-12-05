<?php 
      session_start();
      require_once("connection.php");
              
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
<?php if(isset($_SESSION['message-error'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            <?php echo $_SESSION['message-error']; 
                
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>  
    <?php } else print('noono'); ?>
    <figure class="text-center">
    <h1>Log <small class="text-body-secondary">into your account</small></h1>
    </figure>
<form action="login_check.php" method="POST" class="container" style="max-width: 500px;">
  <div class="mb-3">
    <label for="inputEmail" class="form-label">Email address</label>
    <input name="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label  for="inputPassword1" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="inputPassword1">
  </div>
  <button name="login" type="submit" class="btn" style="background:#ecb21f; font-size:1em">Login</button>
</form>
<section class="d-flex justify-content-center align-items-end" style="min-height: 10em;">  
    <a href="index.php"><button type="button" style="width: 200px; height:80px;background:#ecb21f; font-size:1em" class="btn m-5">Return to homepage</button></a>
    <a href="register.php"><button type="button" style="width: 200px; height:80px;background:#ecb21f; font-size:1em" class="btn m-5">Not yet signed up? Register!</button></a>
</section>
<?php if(isset($_SESSION['message-error'])){$_SESSION['message-error']=null;} ?>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    
</body>
</html>