<?php 
require_once('../connection.php');
session_start();      
$db = new DAO;
        $db -> connection();

$check= $db ->queryRequest('SELECT id_reservation FROM `reservation` JOIN person WHERE person.id_user= reservation.id_user AND person.id_user = "'.$_SESSION['id_user'].'" AND reservation.start_datetime = "'.$_POST['start_datetime'].'"');


if($check){
        $id = $check[0]['id_reservation'];
        if(isset($_POST['end_recurrency']) && $_POST['end_recurrency']!=null){
         $sql = 'UPDATE reservation SET title = "'.$_POST['title'].'",
                                        end_datetime = "'.$_POST['end_datetime'].'",   
                                        description = "'.$_POST['description'].'",
                                        type_reservation = "'.$_POST['end_recurrency'].'",
                                        start_datetime =  "'.$_POST['start_datetime'].'" 
                                    WHERE id_reservation = "'.$id.'" ';
        $_SESSION['message'] = 'Reservation succesfully updated';                                       
        }else {
        $sql = 'UPDATE reservation SET title = "'.$_POST['title'].'",
                end_datetime = "'.$_POST['end_datetime'].'",   
                description = "'.$_POST['description'].'",
                type_reservation = "'.$_POST['select'].'",
                start_datetime =  "'.$_POST['start_datetime'].'" 
            WHERE id_reservation = "'.$id.'" ';
        $_SESSION['message'] = 'Reservation succesfully updated';     
        }
}
else if(isset($_POST['end_recurrency'])&&$_POST['end_recurrency']!=null){  
        $sql = 'INSERT INTO `reservation` VALUES("","'.$_POST['title'].'","'.$_POST['end_datetime'].'","","'.$_POST['description'].'","'.$_SESSION['id_user'].'","'.$_POST['end_recurrency'].'","'.$_POST['start_datetime'].'")';
        $_SESSION['message'] = 'Reservation succesfully inserted into the database';
} else {
$sql = 'INSERT INTO `reservation` VALUES("","'.$_POST['title'].'","'.$_POST['end_datetime'].'","","'.$_POST['description'].'","'.$_SESSION['id_user'].'","'.$_POST['select'].'","'.$_POST['start_datetime'].'")';
$_SESSION['message'] = 'Reservation succesfully inserted into the database';      
}



header('location:calendar.php');
$db -> queryRequest($sql);

?>