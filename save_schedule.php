<?php 
require_once('../connection.php');
session_start();      
$db = new DAO;
        $db -> connection();
var_dump($_POST);
var_dump($_SESSION);
?>