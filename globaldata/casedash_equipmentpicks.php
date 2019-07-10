
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$currentdate = date('Y-m-d');
$startdate = date('Y-m-d', strtotime('-30 days'));

include '../sessioninclude.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}

$sql_equippicks = $conn1->prepare("SELECT 
                                                                    equippicks_date,
                                                                    equippicks_currop,
                                                                    equippicks_suggop,
                                                                    equippicks_currptb,
                                                                    equippicks_suggptb,
                                                                    equippicks_currpj,
                                                                    equippicks_suggpj,
                                                                    equippicks_hourred
                                                                FROM
                                                                    printvis.casedash_equippicks
                                                                WHERE
                                                                    equippicks_whse = 7
                                                                    and equippicks_date >= '$startdate' and equippicks_date < '$currentdate'");
$sql_equippicks->execute();
$array_equippicks = $sql_equippicks->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($array_equippicks as $key => $value) {

    $predicted_availdate = $array_equippicks[$key]['equippicks_date'];
    $CURR_OP = $array_equippicks[$key]['equippicks_currop'];
    $SUGG_OP = $array_equippicks[$key]['equippicks_suggop'];
    $CURR_PTB = $array_equippicks[$key]['equippicks_currptb'];
    $SUGG_PTB = $array_equippicks[$key]['equippicks_suggptb'];
    $CURR_PJ = $array_equippicks[$key]['equippicks_currpj'];
    $SUGG_PJ = $array_equippicks[$key]['equippicks_suggpj'];
    $timedif = $array_equippicks[$key]['equippicks_hourred'];
    $rowpush = array($predicted_availdate, $CURR_OP, $SUGG_OP, $CURR_PTB, $SUGG_PTB, $CURR_PJ, $SUGG_PJ, $timedif);
    $row[] = array_values($rowpush);
}


$output['aaData'] = $row;
echo json_encode($output);

