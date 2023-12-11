<?php
header('content-type:application/json');
require_once('../connection.php');
$db = new DAO;
$db->connection();
$sql = 'SELECT id_reservation,title,end_datetime,last_update,description, reservation.id_user,type_reservation,start_datetime,id_place, person.id_association FROM `reservation` JOIN person ON reservation.id_user = person.id_user;';
$reservations = $db->queryRequest($sql);
$sched_res = [];

// sur cette page on va créer le api que l’on va utiliser pour la création du calendrier
//en itérant la requête sql on va ajouter dans un array dans un tableau $event tous les détails //concernant la réservation 
// en finissant d’ajouter les détails on va insérer la variable $event dans le tableau //$sched_res[]

foreach ($reservations as $row) {
    if($row["type_reservation"]=='onetime'){
        $event=array();
        $event["association"]=$row['id_association'];
        $event["start"]=$row['start_datetime'];
        $event["end"]=$row['end_datetime'];
        $event["title"]=$row['title'];
        $event['reservation_number']=$row['id_reservation'];
        $event['description']= $row['description'];
        $tempPlace = $db -> queryRequest('SELECT `name`,`id_place` FROM `places` WHERE id_place = "'.$row['id_place'].'" ');
       
       $event['reservation_place']= $tempPlace[0]['name'];
        $event['place_id']=$tempPlace[0]['id_place'];
        $event['overlap'] = false;
    } else {
        $timestampstart = strtotime($row['start_datetime']);
        $timestampend = strtotime($row['end_datetime']);
        $day = array();
        $day = date("w", $timestampstart);
        $start = date("H:i:s", $timestampstart);
        $end = date("H:i:s", $timestampend);
        $event=array();
        $event["association"]=$row['id_association'];
        $event["description"]=$row['description']; 
        $event["startTime"]=$start;
        $event["endTime"]=$end;
        $event["title"]=$row['title'];
        $event["startRecur"]=$row['start_datetime'];
        $event["endRecur"]=$row['type_reservation'];
        $event["daysOfWeek"]=$day;
        $event["color"]='red';
        $event["eventTextColor"]= 'red';
        $event['reservation_number']=$row['id_reservation'];
        $tempPlace = $db -> queryRequest('SELECT `name`,`id_place` FROM `places` WHERE id_place = "'.$row['id_place'].'" ');
        $event['reservation_place']= $tempPlace[0]['name'];
        $event['place_id']=$tempPlace[0]['id_place']; 
        $event['overlap'] = false;
    }
    
   $sched_res[] = $event;

}
// on fait le retour des réservations en utilisant la fonction json_encode()
$return = $sched_res;
echo json_encode($return);


