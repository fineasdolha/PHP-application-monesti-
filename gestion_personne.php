<?php
session_start();
require_once 'connection.php';
$db = new DAO();
$db->connection();
$sqlassoc = $db -> getAssociations();
$associationList = $db -> queryRequest($sqlassoc);

 $infoPerson = $db->getAllPerson();



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"/>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <link href="style.css" rel="stylesheet">
  <title>registration user</title>
</head>

<body>
<section>
<nav class="navbar navbar-expand-lg navbar-dark px-5" style="border:1px solid white">
    <a class="navbar-brand" href="#">Monestié</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="admin_homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="calendar/calendar.php">Calendar</a>
        </li>
      </ul>
      <span class="navbar-text">
        <form method="post">
          <a class="btn" href="logout.php" style="background:#ecb21f; font-size:1em">Log out</a>
        </form>
      </span>
    </div>
  </nav>
</section>
    <section>
    <?php if(isset($_SESSION['message-error'])){ ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message-error']; 
                
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>  
    <?php } ?>
        <section>
<table id="user" class="display text-light" style="width:100%">
       
</table>
        
        </section>
        <section>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create new user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    
      <form action="register_admin.php" method="POST" class="container" style="max-width: 500px;">
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
  </div>
  <div class="mb-3">
    <label  for="inputPassword1" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="inputPassword1" required>
  </div>
  <label for="radio-container" class="form-label my-2">You are registering as :</label>
  <div id="radio-container" class="d-flex justify-content-start p" >
  <div class="form-check mr-2 my-2">
  <input class="form-check-input" type="radio" name="entity" id="admin" value="admin" required>
  <label class="form-check-label" for="admin">
    Admin
  </label>
</div>
<div class="form-check m-2 my-2 ">
  <input class="form-check-input" type="radio" name="entity" id="association" value="association" required>
  <label class="form-check-label" for="association">
    Association
  </label>
</div>
<div class="form-check m-2 my-2">
  <input class="form-check-input" type="radio" name="entity" id="cleaning" value="cleaning" required>
  <label class="form-check-label" for="cleaning">
  Cleaning
  </label>
</div>
</div>
<div class="mb-3">
         <label for="association-choice">What is the name of your association?</label>
         <select id="association-choice" class="form-control " name="association-choice" required>
         <option value="">Choose an option</option>
         <option value="0">None</option>
         <?php foreach($associationList as $row){?>
              
             <option value="<?php print $row['id_association'];?>"><?php print $row['name_association'];?></option>
             <?php } ?>
        </select>
    </div>

  <button name="login" type="submit" class="btn btn-primary mt-2">Register</button>
</form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
        </section>
        <section>
    
<button type="button" class="btn btn-primary float-end mt-3 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  register new user
</button>
        </section>
        <hr>
        <section>

        </section>
    </section>



    <?php if(isset($_SESSION['message-error'])){$_SESSION['message-error']=null;} ?> 
    <script type="text/javascript">
let information = <?php echo json_encode($infoPerson) ?>;
// alert(information.toString());
    $(document).ready(function () {
        let user=$('#user').dataTable({
            data: information,
            responsive:true,

            columns: [
                { title: 'id_user' },
                { title: 'last_name' },
                { title: 'first_name' },
                { title: 'user_type' },
                { title: 'user_email' },
                { title: 'user_password',visible:false },
                { title: 'id_association',visible:false }
            ],
            columnDefs: [
        {
            targets: [1,2,3,4,5,6],
            className: 'dt-body-center',
            className:'compact',
        }],
       
        });
        
    });
    
</script>
    <script type="text/javascript" src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    

</body>
</html>