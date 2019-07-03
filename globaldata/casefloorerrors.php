
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

$locerror = $conn1->prepare("SELECT 
                                                ' ',    
                                                hist_loc
                                                FROM
                                                    printvis.hist_casevol
                                                        LEFT JOIN
                                                    slotting.case_floor_locs ON WHSE = hist_whse AND LOCATION = hist_loc
                                                WHERE
                                                    hist_whse = $var_whse
                                                        AND predicted_availdate >= '$startdate'
                                                        AND LOCATION IS NULL
                                                        AND hist_loc NOT LIKE 'B%'
                                                        AND hist_loc NOT LIKE 'I%'
                                                        AND hist_loc NOT LIKE 'Y%'
                                                GROUP BY hist_loc");
$locerror->execute();
$locerror_array = $locerror->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($locerror_array as $key => $value) {
    $row[] = array_values($locerror_array[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
