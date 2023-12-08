<?php 
// pour chaque nouvelle page que les données de l’utilisateur va consulter, on s’assure d’abord //que la fonction session_start() est appelée et ensuite on fait la connexion en requérant la //page connexion.php
session_start();
require_once('connection.php');
$db = new DAO();
$db->connection();

// on vérifie d’abord si le formulaire login a été envoyé
if(ISSET($_POST['login'])){
    if($_POST['email'] != "" || $_POST['password'] != ""){
        $useremail = $_POST['email'];
        $password = $_POST['password'];
        
    }
// on récupère les détails de l’utilisateur dans la variable $fetchuser 


        $fetchuser = $db -> getUserInfo($useremail);
        if($fetchuser){   
    // si on a une adresse email associée à l’utilisateur 
// on vérifie avec la fonction password_verify() si le mot de passe saisi et le mot de passe //crypté dans la base de données correspondent

            if(password_verify($password, $fetchuser[0]['user_password']) && $fetchuser[0]['user_email']===$useremail){
                            // on enregistre dans la variable SESSION toutes les données de l’utilisateur en omettant le //mot de passe

// entre ligne 30 et 31
// si l’adresse email n’existe pas, on enregistre le message d’erreur

                $fetchuser = $db -> getUserInfo($useremail);
                $_SESSION['id_user'] = $fetchuser[0]['id_user'];
                $_SESSION['last_name'] = $fetchuser[0]['last_name'];
                $_SESSION['first_name'] = $fetchuser[0]['first_name'];
                $_SESSION['user_type'] = $fetchuser[0]['user_type'];
                $_SESSION['id_association'] = $fetchuser[0]['id_association'];
                $_SESSION['user_email'] = $_POST['email'];
                if ($_SESSION['user_type'] == 'cleaning'){
                    header('location:cleaning_homepage.php');
                }else if($_SESSION['user_type'] == 'admin'){
                    header('location:admin_homepage.php');
                } else if($_SESSION['user_type'] == 'association'){
                    header('location:association_homepage.php');
                }
            } 
        }else {
            $_SESSION['message-error'] = 'User not yet registered';
            header('location:login.php');
        }; 
}

?>