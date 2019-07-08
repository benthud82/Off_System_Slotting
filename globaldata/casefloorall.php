
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$startdate = date("Y-m-d", strtotime('-30 days'));

include '../sessioninclude.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}

$locall = $conn1->prepare("SELECT 
                                                            ' ',  
                                                          LOCATION,
                                                            CASE
                                                                WHEN PRIM_RES = 'P' THEN 'Y'
                                                                ELSE 'N'
                                                            END,
                                                            FLOOR
                                                        FROM
                                                            slotting.case_floor_locs
                                                        WHERE
                                                            WHSE = $var_whse");
$locall->execute();
$locall_array = $locall->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($locall_array as $key => $value) {
    $row[] = array_values($locall_array[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
