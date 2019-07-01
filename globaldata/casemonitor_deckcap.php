
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

include '../sessioninclude.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];

}

$sql_pallcap = $conn1->prepare("SELECT 
                                                                LMLOC, case when LMITEM = 0 then '-' else LMITEM end as LMITEM, LMGRD5, LMHIGH, LMDEEP, LMWIDE, LMVOL9
                                                            FROM
                                                                slotting.mysql_npflsm
                                                            WHERE
                                                                LMTIER = 'C06' AND LMLOC not like 'Q%' AND LMWHSE = $var_whse");
$sql_pallcap->execute();
$array_pallcap = $sql_pallcap->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($array_pallcap as $key => $value) {
    $row[] = array_values($array_pallcap[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);

