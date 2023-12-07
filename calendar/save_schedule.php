<?php 
require_once('../connection.php');
session_start();      
$db = new DAO;
        $db -> connection();




$checkExistance= $db ->queryRequest('SELECT id_reservation, id_association FROM `reservation` JOIN person WHERE person.id_user= reservation.id_user AND person.id_user = "'.$_SESSION['id_user'].'" AND reservation.start_datetime = "'.$_POST['start_datetime'].'"');
if($checkExistance){ 
$id = $checkExistance[0]['id_reservation'];
}

if($_POST['send']=='update'){ 
        $checkAvailability = $db -> queryRequest('SELECT start_datetime, end_datetime, places.id_place FROM `reservation` JOIN places WHERE reservation.id_place = "'.$_POST['place'].'"');
        $takenSlot = false;
        foreach($checkAvailability as $row){    
                $todayDate = new DateTime();
                $startDate = new DateTime($row['start_datetime']);
                $endDate = new DateTime($row['end_datetime']);
                $dateToCheckStart = new DateTime($_POST['start_datetime']);
                $dateToCheckEnd = new DateTime($_POST['end_datetime']);
                $todayDate= new DateTime();
                        if($todayDate >= $dateToCheckStart){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'You are not allowed to make a reservation for a date that has already passed.';
                        }
                        if($dateToCheckStart >=  $dateToCheckEnd){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'Invalid input for the modified date. The reservation has failed to update';
                        }
                        if ($dateToCheckStart >= $startDate && $dateToCheckStart <= $endDate) {
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'The timeslot for this place  is already taken, so choose another timeslot or another place to change this reservation';
                                } 
                        elseif($dateToCheckEnd  >= $startDate && $dateToCheckEnd  <= $endDate){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'The timeslot for this place  is already taken, so choose another timeslot or another place to change this reservation';
                                }
                        elseif($startDate >= $dateToCheckStart && $endDate <= $dateToCheckEnd){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'The timeslot for this place  is already taken, so choose another timeslot or another place to change this reservation';
                        }             
                }
                
                if($takenSlot){
                        header('location:calendar.php');
                        }
                elseif (isset($_POST['end_recurrency']) && $_POST['end_recurrency']!=null){
                $sql = 'UPDATE reservation SET title = "'.$_POST['title'].'",
                                                end_datetime = "'.$_POST['end_datetime'].'",   
                                                description = "'.$_POST['description'].'",
                                                type_reservation = "'.$_POST['end_recurrency'].'",
                                                start_datetime =  "'.$_POST['start_datetime'].'",
                                                id_place = "'.$_POST['place'].'" 
                                        WHERE id_reservation = "'.$id.'" ';
                $db -> queryRequest($sql);                        
                $_SESSION['message-success'] = 'Reservation succesfully modified';                                       
                }else {
                $sql = 'UPDATE reservation SET title = "'.$_POST['title'].'",
                        end_datetime = "'.$_POST['end_datetime'].'",   
                        description = "'.$_POST['description'].'",
                        type_reservation = "'.$_POST['select'].'",
                        start_datetime =  "'.$_POST['start_datetime'].'",
                        id_place = "'.$_POST['place'].'" 
                WHERE id_reservation = "'.$id.'" ';
                $db -> queryRequest($sql);
                $_SESSION['message-succes'] = 'Reservation succesfully modified';     
        }
        if(isset($_POST['file-reservation']) && $_POST['file-reservation'] != null){         
                $aMimeTypes = array("application/pdf", "image/jpeg","image/png");
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimetype = finfo_file($finfo, $_FILES["file-reservation"]["tmp_name"]);
                finfo_close($finfo);
                if (in_array($mimetype, $aMimeTypes))
                        {
                        $insertedRequest = $db -> queryRequest('SELECT id_reservation , id_association FROM `reservation` 
                                JOIN person 
                                WHERE person.id_user = reservation.id_user 
                                AND person.id_user = "'.$_SESSION['id_user'].'" 
                                AND reservation.start_datetime =  "'.$_POST['start_datetime'].'"
                                AND reservation.id_place =  "'.$_POST['place'].'"');
                        $idReservation = $insertedRequest[0]['id_reservation'];
                        $idAssociation = $insertedRequest[0]['id_association'];
                        $filename = $_FILES["file-reservation"]["name"];                
                        $uploadsDirectory = '../media';
                        $sql = 'INSERT INTO `docs`( `id_association`, `file`, `id_reservation`) VALUES ("'.$idAssociation.'", "'.$_FILES["file-reservation"]["name"].'","'.$idReservation.'")';
                        $db -> queryRequest($sql);
                        move_uploaded_file($_FILES["file-reservation"]["tmp_name"], "$uploadsDirectory/$filename");             
                }else {
                        $_SESSION['message-fail'] = 'The file you uploaded is not in a supported format. Accepted formats are PDF and JPEG.';
                }
        }else {
                $_SESSION['message-success'] = 'Reservation succesfully inserted into the database but no file was uploaded';
        }

}
else if($_POST['send']=='delete'){
        $sql = 'DELETE FROM reservation WHERE id_reservation = "'.$id.'"';
        $_SESSION['message-succes'] = 'Reservation succesfully deleted from the database';
        $db -> queryRequest($sql);

}else if($_POST['send']=='save'){ 

        $checkAvailability = $db -> queryRequest('SELECT start_datetime, end_datetime, places.id_place FROM `reservation` JOIN places WHERE reservation.id_place = "'.$_POST['place'].'"');
        $takenSlot = false;
        foreach($checkAvailability as $row){    
                $startDate = new DateTime($row['start_datetime']);
                $endDate = new DateTime($row['end_datetime']);
                $dateToCheckStart = new DateTime($_POST['start_datetime']);
                $dateToCheckEnd = new DateTime($_POST['end_datetime']);
                $todayDate= new DateTime();
                        if($todayDate >= $dateToCheckStart){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'You are not allowed to make a reservation for a date that has already passed.';
                        }
                        if($dateToCheckStart >=  $dateToCheckEnd){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'Invalid input for the date.';
                                }
                        if ($dateToCheckStart >= $startDate && $dateToCheckStart <= $endDate) {
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'The timeslot for this place  is already taken, so choose another timeslot or another place to make a reservation';
                                } 
                        elseif($dateToCheckEnd  >= $startDate && $dateToCheckEnd  <= $endDate){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'The timeslot for this place  is already taken, so choose another timeslot or another place to make a reservation';
                                }
                        elseif($startDate >= $dateToCheckStart && $endDate <= $dateToCheckEnd){
                                $takenSlot = true;
                                $_SESSION['message-fail'] = 'The timeslot for this place  is already taken, so choose another timeslot or another place to make a reservation';
                        }                
                }
                
                if($takenSlot){
                        header('location:calendar.php');
                }else  
                        { 
                                if(isset($_POST['end_recurrency'])&&$_POST['end_recurrency']!=null){  
                                        $sql = 'INSERT INTO `reservation` VALUES("","'.$_POST['title'].'","'.$_POST['end_datetime'].'","","'.$_POST['description'].'","'.$_SESSION['id_user'].'","'.$_POST['end_recurrency'].'","'.$_POST['start_datetime'].'","'.$_POST['place'].'")';
                                        $_SESSION['message-success'] = 'Reservation succesfully inserted into the database';
                                        $db -> queryRequest($sql);
                                        } 
                                else {
                                        $sql = 'INSERT INTO `reservation` VALUES("","'.$_POST['title'].'","'.$_POST['end_datetime'].'","","'.$_POST['description'].'","'.$_SESSION['id_user'].'","'.$_POST['select'].'","'.$_POST['start_datetime'].'","'.$_POST['place'].'")';
                                        $_SESSION['message-success'] = 'Reservation succesfully inserted into the database';
                                        $db -> queryRequest($sql);      
                                }
                                if(isset($_POST['file-reservation']) && $_POST['file-reservation'] != null){         
                                        $aMimeTypes = array("application/pdf", "image/jpeg","image/png");
                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                $mimetype = finfo_file($finfo, $_FILES["file-reservation"]["tmp_name"]);
                                        finfo_close($finfo);
                                        if (in_array($mimetype, $aMimeTypes))
                                                {
                                                $insertedRequest = $db -> queryRequest('SELECT id_reservation , id_association FROM `reservation` 
                                                        JOIN person 
                                                        WHERE person.id_user = reservation.id_user 
                                                        AND person.id_user = "'.$_SESSION['id_user'].'" 
                                                        AND reservation.start_datetime =  "'.$_POST['start_datetime'].'"
                                                        AND reservation.id_place =  "'.$_POST['place'].'"');
                                                $idReservation = $insertedRequest[0]['id_reservation'];
                                                $idAssociation = $insertedRequest[0]['id_association'];
                                                $filename = $_FILES["file-reservation"]["name"];                
                                                $uploadsDirectory = '../media';
                                                $sql = 'INSERT INTO `docs`( `id_association`, `file`, `id_reservation`) VALUES ("'.$idAssociation.'", "'.$_FILES["file-reservation"]["name"].'","'.$idReservation.'")';
                                                $db -> queryRequest($sql);
                                                move_uploaded_file($_FILES["file-reservation"]["tmp_name"], "$uploadsDirectory/$filename");             
                                        }else {
                                                $_SESSION['message-fail'] = 'The file you uploaded is not in a supported format. Accepted formats are PDF and JPEG.';
                                        }
                                }else {
                                        $_SESSION['message-success'] = 'Reservation succesfully inserted into the database but no file was uploaded';
                                }        
                               
                        }        
                
                }


header('location:calendar.php');

?>