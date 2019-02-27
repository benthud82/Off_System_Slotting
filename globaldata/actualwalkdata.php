<?php

include_once '../sessioninclude.php';
include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

$var_userid = strtoupper($_SESSION['MYUSER']);
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE UPPER(idslottingDB_users_ID) = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


$startdate = date('Y-m-d', strtotime($_GET['startdate']));
$enddate = date('Y-m-d', strtotime($_GET['enddate']));

$shortdata = $conn1->prepare("SELECT DATE, cast((CART / VOICE_LINES) as DECIMAL(12,1)), cast((AISLE / VOICE_LINES) as DECIMAL(12,1)), cast((TOTAL / VOICE_LINES) as DECIMAL(12,1))FROM printvis.pm_traveldata WHERE DATE between '$startdate' and '$enddate' and WHSE = $var_whse");
$shortdata->execute();
$shortdata_array = $shortdata->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($shortdata_array as $key => $value) {
    $row[] = array_values($shortdata_array[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
