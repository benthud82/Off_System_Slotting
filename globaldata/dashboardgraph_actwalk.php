<?php
ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';
$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


$time = strtotime("-1 year", time());
$date = date("Y-m-d", $time);

$result1 = $conn1->prepare("SELECT DATE, CART, AISLE, TOTAL,  VOICE_LINES FROM printvis.pm_traveldata  WHERE
                                WHSE = $var_whse and DATE >= '$date'");
$result1->execute();



$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Cart FPP';
$rows2 = array();
$rows2['name'] = 'Aisle FPP';
$rows3 = array();
$rows3['name'] = 'Total FPP';


foreach ($result1 as $row) {
    $rows['data'][] = $row['DATE'];
    $rows1['data'][] =( $row['CART'] /$row['VOICE_LINES'])  * 1;
    $rows2['data'][] = ( $row['AISLE'] /$row['VOICE_LINES'])  * 1;
    $rows3['data'][] = ( $row['TOTAL'] /$row['VOICE_LINES'])  * 1;
}


$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);
array_push($result, $rows3);



print json_encode($result);

