<?php
session_start();
require_once("connection.php");
$db = new DAO;
$db -> connection();
$db -> disconnection();
session_destroy();
header('location:index.php');
?>
