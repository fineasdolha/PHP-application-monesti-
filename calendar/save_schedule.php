<?php 
require_once('../connection.php');
session_start();      
$db = new DAO;
        $db -> connection();


$checkTime = $db -> queryRequest('SELECT start_datetime, end_datetime FROM `reservation`');
$takenSlot = false;

foreach($checkTime as $row){
        
        $startDate = new DateTime($row['start_datetime']);
        $endDate = new DateTime($row['end_datetime']);
        $dateToCheckStart = new DateTime($_POST['start_datetime']);
        $dateToCheckEnd = new DateTime($_POST['end_datetime']);
        if ($dateToCheckStart >= $startDate && $dateToCheckStart <= $endDate) {
                $takenSlot = true;
            } elseif($dateToCheckEnd  >= $startDate && $dateToCheckEnd  <= $endDate){
                $takenSlot = true;
            } 
       
}


if($takenSlot){
        $_SESSION['message'] = 'This timeslot is already taken, choose another one';
        header('location:calendar.php');
   }  else {   
        
        $checkExistance= $db ->queryRequest('SELECT id_reservation FROM `reservation` JOIN person WHERE person.id_user= reservation.id_user AND person.id_user = "'.$_SESSION['id_user'].'" AND reservation.start_datetime = "'.$_POST['start_datetime'].'"');
        $id = $checkExistance[0]['id_reservation'];
        if($_POST['send']=='update'){ 

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
        else if($_POST['send']=='delete'){
                $sql = 'DELETE FROM reservation WHERE id_reservation = "'.$id.'"';
                $_SESSION['message'] = 'Reservation succesfully deleted from the database';
        }
        else if($_POST['send']=='save') { 
                if(isset($_POST['end_recurrency'])&&$_POST['end_recurrency']!=null){  
                        $sql = 'INSERT INTO `reservation` VALUES("","'.$_POST['title'].'","'.$_POST['end_datetime'].'","","'.$_POST['description'].'","'.$_SESSION['id_user'].'","'.$_POST['end_recurrency'].'","'.$_POST['start_datetime'].'")';
                        $_SESSION['message'] = 'Reservation succesfully inserted into the database';
                } else {
                $sql = 'INSERT INTO `reservation` VALUES("","'.$_POST['title'].'","'.$_POST['end_datetime'].'","","'.$_POST['description'].'","'.$_SESSION['id_user'].'","'.$_POST['select'].'","'.$_POST['start_datetime'].'")';
                $_SESSION['message'] = 'Reservation succesfully inserted into the database';      
                }
        }        

   }

$db -> queryRequest($sql);
header('location:calendar.php');
//header('location:calendar.php');
?>