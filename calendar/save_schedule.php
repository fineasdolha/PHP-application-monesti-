<?php 
require_once('../connection.php');
session_start();      
$db = new DAO;
        $db -> connection();



        
$checkExistance= $db ->queryRequest('SELECT id_reservation, id_association FROM `reservation` JOIN person WHERE person.id_user= reservation.id_user AND person.id_user = "'.$_SESSION['id_user'].'" AND reservation.start_datetime = "'.$_POST['start_datetime'].'"');
if($checkExistance){ 
$id = $checkExistance[0]['id_reservation'];

}
// on vérifie que l’utilisateur veuille mettre à jour une réservation
if($_POST['send']=='update'){ 
        $checkAvailability = $db -> queryRequest('SELECT id_reservation, start_datetime, end_datetime, places.id_place FROM `reservation` JOIN places WHERE reservation.id_place = "'.$_POST['place'].'"');
        $takenSlot = false;
        // en itérant la requête faite on va vérifier que la mise à jour de la réservation ne tombera pas // sur un créneau déjà utilisé
// on vérifie que le id de la réservation que l’on veut changer est différent de l’id de la 
// réservation itérée
// en utilisant la variable takenslot on peut avoir un compteur de toutes les vérifications

        foreach($checkAvailability as $row){    
                $todayDate = new DateTime();
                $startDate = new DateTime($row['start_datetime']);
                $endDate = new DateTime($row['end_datetime']);
                $dateToCheckStart = new DateTime($_POST['start_datetime']);
                $dateToCheckEnd = new DateTime($_POST['end_datetime']);
                $todayDate= new DateTime();
                       if($row['id_reservation'] != $_POST['idr']){ 
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
                }
                // si la variable takenslot est vraie on cible la page calendar.php
// sinon on va mettre à jour d’abord la réservation et après ensuite les fichiers associés


                if($takenSlot){
                        header('location:calendar.php');
                        }
                else { 
                if (isset($_POST['end_recurrency']) && $_POST['end_recurrency']!=null){
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
                WHERE id_reservation = "'.$_POST['idr'].'" ';
                $db -> queryRequest($sql);
                $_SESSION['message-succes'] = 'Reservation succesfully modified';     
                }
                if(isset($_FILES['file-reservation'])){         
                        $ext = pathinfo($_FILES['file-reservation']['name'], PATHINFO_EXTENSION);
                        $aMimeTypes = array("jpg","jpeg","png");
                        //si les fichiers saisis sont dans un format accepté (jpg, jpeg, png) on va mettre à jour le 
// fichier dans la base de données dans le dossier media1 
// en utilisant la fonction move_uploaded_file()

                        if (in_array($ext, $aMimeTypes))
                                {
                                $uploadsDirectory = 'media1';
                                $dataDirectory = 'media1/';
                                $files=scandir($uploadsDirectory);
                                if(is_array($files)){
                                        foreach($files as $file){
                                                if(strstr($file, $_POST['idr'])){
                                                        unlink($dataDirectory.$file);
                                                }
                                }                                    

                                $filename = $_POST['idr'].'.'.$ext; 
                                $dataDirectory = 'media1/';
                                $nameToInsert= $dataDirectory.$filename;
                                move_uploaded_file($_FILES["file-reservation"]["tmp_name"], "$uploadsDirectory/$filename");
                                $sql = 'UPDATE `docs` SET `file`="'.$nameToInsert.'" WHERE id_reservation="'.$_POST['idr'].'" ';
                                
                                $db -> queryRequest($sql);
                                $_SESSION['message-succes']= 'Reservation and file details updated';
                                            
                        }else {
                                $_SESSION['message-fail'] = 'The file you uploaded is not in a supported format. Accepted formats are PDF and JPEG.';
                        }
                }else {
                        $_SESSION['message-success'] = 'Reservation succesfully inserted into the database but no file was uploaded';
                }     
                }
        }
}
else if ($_POST['send']=='delete'){
        // si le formulaire envoyé cible la suppression d’une réservation
// on va d’abord supprimer la réservation et ensuite le fichier associé

        $sql = 'DELETE FROM reservation WHERE id_reservation = "'.$_POST['idr'].'"';
        $_SESSION['message-success'] = 'Reservation succesfully deleted from the database';
        $db -> queryRequest($sql);
        $sql = 'DELETE FROM docs WHERE id_reservation = "'.$_POST['idr'].'"';
        $db -> queryRequest($sql);
        $_SESSION['message-success'] = 'Reservation and file succesfully deleted from the database';
        $uploadsDirectory = 'media1';
        $dataDirectory = 'media1/';
        $files=scandir($uploadsDirectory);
        if(is_array($files)){
                foreach($files as $file){
                        if(strstr($file, $_POST['idr'])){
                                unlink($dataDirectory.$file);
                        }
                } 
        }

}else if($_POST['send']=='save'){ 
// en itérant la requête faite on va vérifier que l’insertion de la réservation ne tombera pas 
// sur un créneau déjà utilisé
// en utilisant la variable takenslot on peut avoir un compteur de toutes les vérifications faites

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
        // si les fichiers saisis sont dans un format accepté (jpg, jpeg, png) on va insérer le 
// fichier dans la base de données et dans le dossier media1 
// en utilisant la fonction move_uploaded_file()

                                if(isset($_POST['file-reservation']) && !empty($_POST['file-reservation'])){         
                                        $ext = pathinfo($_FILES['file-reservation']['name'], PATHINFO_EXTENSION);
                                        $aMimeTypes = array("jpg","jpeg","png");
                                        //var_dump($_POST['file-reservation']);
                                        if (in_array($ext, $aMimeTypes))
                                                {
                                                $insertedRequest = $db -> queryRequest('SELECT id_reservation , id_association FROM `reservation` 
                                                        JOIN person 
                                                        WHERE person.id_user = reservation.id_user 
                                                        AND person.id_user = "'.$_SESSION['id_user'].'" 
                                                        AND reservation.start_datetime =  "'.$_POST['start_datetime'].'"
                                                        AND reservation.id_place =  "'.$_POST['place'].'"');
                                                $idReservation = $insertedRequest[0]['id_reservation'];
                                                $idAssociation = $insertedRequest[0]['id_association'];
                                                $filename = $idReservation.'.'.$ext;                
                                                $uploadsDirectory = 'media1';
                                                $dataDirectory = 'media1/';
                                                $nameToInsert= $dataDirectory.$filename;
                                                move_uploaded_file($_FILES["file-reservation"]["tmp_name"], "$uploadsDirectory/$filename");
                                                $sql = 'INSERT INTO `docs`( `id_association`, `file`, `id_reservation`) VALUES ("'.$idAssociation.'","'.$nameToInsert.'","'.$idReservation.'")';
                                                $db -> queryRequest($sql);
                                                            
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