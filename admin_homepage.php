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
    <title>Administration Monestié</title>
</head>
<body>
<!--les autres sections -->


<!--après-->

<section class="container">
              <h1>Calendar</h1>
              <a href="calendar/calendar.php"><button class="btn" style="background:#ecb21f; font-size:1em;margin-bottom:10px">View reservations calendar</button></a>
</section>

</body>
</html>