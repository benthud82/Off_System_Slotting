
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = intval($whssqlarray[0]['slottingDB_users_PRIMDC']);

$reslotsql = $conn1->prepare("SELECT 
                                                            reslotprog_item,
                                                            reslotprog_date,
                                                            reslotprog_movered,
                                                            reslotprog_walkred,
                                                            reslotprog_relslottype
                                                        FROM
                                                            slotting.reslot_tracking_progress
                                                        WHERE
                                                            reslotprog_whse = $var_whse");
$reslotsql->execute();
$reslotarray = $reslotsql->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($reslotarray as $key => $value) {
    $row[] = array_values($reslotarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
