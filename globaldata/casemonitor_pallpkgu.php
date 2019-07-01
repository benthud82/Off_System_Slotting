
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

$sql_pallpkgu = $conn1->prepare("SELECT 
                                                                ITEM_NUMBER,
                                                                PACKAGE_UNIT,
                                                                CUR_LOCATION,
                                                                DAYS_FRM_SLE,
                                                                AVGD_BTW_SLE,
                                                                AVG_INV_OH,
                                                                AVG_DAILY_PICK,
                                                                AVG_DAILY_UNIT
                                                            FROM
                                                                slotting.my_npfmvc_cse
                                                                    JOIN
                                                                slotting.npfcpcsettings ON CPCWHSE = WAREHOUSE
                                                                    AND CPCITEM = ITEM_NUMBER
                                                            WHERE
                                                                WAREHOUSE = $var_whse AND SUGGESTED_TIER = 'PFR'
                                                                    AND AVG_DAILY_PICK >= 1
                                                                    AND CPCPPKU = 0");
$sql_pallpkgu->execute();
$array_pallpkgu = $sql_pallpkgu->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($array_pallpkgu as $key => $value) {
    $row[] = array_values($array_pallpkgu[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);

