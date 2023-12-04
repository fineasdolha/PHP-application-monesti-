<?php 
session_start();
require_once('connection.php');
$db = new DAO();
$db->connection();

if(ISSET($_POST['login'])){
    if($_POST['email'] != "" || $_POST['password'] != ""){
        $useremail = $_POST['email'];
        $password = $_POST['password'];
        
    }
        $fetchuser = $db -> getUserInfo($useremail);
        if($fetchuser){   
            if(password_verify($password, $fetchuser[0]['user_password']) && $fetchuser[0]['user_email']===$useremail){
                $fetchuser = $db -> getUserInfo($useremail);
                $_SESSION['id_user'] = $fetchuser[0]['id_user'];
                $_SESSION['last_name'] = $fetchuser[0]['last_name'];
                $_SESSION['first_name'] = $fetchuser[0]['first_name'];
                $_SESSION['user_type'] = $fetchuser[0]['user_type'];
                $_SESSION['id_association'] = $fetchuser[0]['id_association'];
                $_SESSION['user_email'] = $_POST['email'];
                if ($_SESSION['user_type'] == 'cleaning'){
                    header('location:cleaning_homepage.php');
                }else if ($_SESSION['user_type'] == 'admin'){
                    header('location:admin_homepage.php');
                }else if ($_SESSION['user_type'] == 'association'){
                    header('location:association_homepage.php');
                }
            } 
        } 
}else print 'account not existing';

?>