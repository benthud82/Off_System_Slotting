<?php

include_once '../sessioninclude.php';
include_once '../connection/connection_details.php';
include_once '../../globalfunctions/custdbfunctions.php';

ini_set('max_execution_time', 99999);
$var_userid = strtoupper($_SESSION['MYUSER']);
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE UPPER(idslottingDB_users_ID) = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
$table = $var_whse . 'shortsdetail';

$startdate = date('Y-m-d', strtotime($_GET['startdate']));
$enddate = date('Y-m-d', strtotime($_GET['enddate']));

$shortdata = $conn1->prepare("SELECT * FROM {$table} WHERE ShortDate between '$startdate' and '$enddate' ");
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
