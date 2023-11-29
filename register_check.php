<?php 
session_start();
require_once 'connection.php';
$db = new DAO();
$db -> connection();
$checkAllFields = false;
$checkEmailUsage=false;
if (isset($_POST['firstname'])&& $_POST['firstname'] !=''){
    $firstname = $_POST['firstname'];
    if (isset($_POST['lastname'])&& $_POST['lastname'] !=''){
        $lastname = $_POST['lastname'];
        $testMail = $db -> getUserInfo($_POST['email']);
        if ($testMail){
            $_SESSION['message'] = 'The email you entred is already used!';
            $checkEmailUsage=true;
            $checkAllFields=true;
            header('location:register.php');
        }    
        if(isset($_POST['password']) && $_POST['password'] !='' && $checkEmailUsage==false){
                $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);
            if(isset($_POST['entity']) && $_POST['entity'] != ''){
                $entity = $_POST['entity'];
                $useremail= $_POST['email'];
                $association = $_POST['association-choice'];
                $checkAllFields = true;
                $sql = 'INSERT INTO `person` (`last_name`, `first_name`, `user_type`, `user_email`, `user_password`, `id_association`) 
                VALUES ("'.$lastname.'", "'.$firstname.'","'.$entity.'","'.$useremail.'","'.$password.'","'.$association.'")';
                $test = $db -> prepExec($sql);
            } 
        }
    }
}

if($checkAllFields==true && $checkEmailUsage==false){
    header('location:register_succes.php');
}
elseif($checkAllFields==false) {
    $_SESSION['message'] = 'Complete all required information!';
    header('location:register.php');
} 
// else {$_SESSION['message']= $db ->errorInfo();} ??
?>

