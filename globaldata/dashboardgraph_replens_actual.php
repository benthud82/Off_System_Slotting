<?php

include_once '../connection/connection_details.php';
$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
$table = ($var_whse) . 'dailymovecount';

$time = strtotime("-1 year", time());
$date = date("Y-m-d", $time);

$result1 = $conn1->prepare("SELECT * FROM slotting.$table  WHERE MoveDate >= '$date';");
$result1->execute();
$result1array = $result1->fetchAll(pdo::FETCH_ASSOC);




$rows = array();
$rows['name'] = 'Date';
$rows1 = array();   
$rows1['name'] = 'ASOs';
$rows2 = array();
$rows2['name'] = 'AUTOs';
$rows3 = array();
$rows3['name'] = 'CONSOLs';
$rows4 = array();
$rows4['name'] = 'Total';


foreach ($result1array as $key => $value) {
    $rows['data'][] = $result1array[$key]['MoveDate'];
    $rows1['data'][] = intval($result1array[$key]['ASOCount']);
    $rows2['data'][] = intval($result1array[$key]['AUTOCount']);
    $rows3['data'][] = intval($result1array[$key]['CONSOLCount']);
    $rows4['data'][] = intval($result1array[$key]['AUTOCount']) + intval($result1array[$key]['ASOCount']);

}




$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);
array_push($result, $rows3);
array_push($result, $rows4);


print json_encode($result);

