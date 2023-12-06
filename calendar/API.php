<?php
header('content-type:application/json');
require_once('../connection.php');
$db = new DAO;
$db->connection();
$sql = 'SELECT * FROM `reservation`';
$reservations = $db->queryRequest($sql);
$sched_res = [];

foreach ($reservations as $row) {
    if($row["type_reservation"]=='onetime'){
        $event=array();
        $event["groupId"]=$row['id_user'];
        $event["start"]=$row['start_datetime'];
        $event["end"]=$row['end_datetime'];
        $event["title"]=$row['title'];
        $event['reservation_number']=$row['id_reservation'];
        $event['description']= $row['description'];
        $event['overlap'] = false;
    } else {
        $timestampstart = strtotime($row['start_datetime']);
        $timestampend = strtotime($row['end_datetime']);
        $day = array();
        $day = date("w", $timestampstart);
        $start = date("H:i:s", $timestampstart);
        $end = date("H:i:s", $timestampend);
        $event=array();
        $event["groupId"]=$row['id_user'];
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
        $event['overlap'] = false;
    }

   $sched_res[] = $event;

}

$return = $sched_res;
echo json_encode($return);


