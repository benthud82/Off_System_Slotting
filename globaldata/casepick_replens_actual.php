<?php

include_once '../connection/connection_details.php';

include '../sessioninclude.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}
$table = 'slotting.' . ($var_whse) . 'moves';

$time = strtotime("-1 year", time());
$date = date("Y-m-d", $time);

$result1 = $conn1->prepare("SELECT MVDATE, COUNT(1) as TOTCOUNT FROM {$table} LEFT JOIN slotting.excl_replenphistorical on  MVDATE = replenexcl_date and replenexcl_whse = $var_whse  WHERE MVDATE >= '$date' and  replenexcl_date is null  GROUP BY MVDATE ");
$result1->execute();

$result2 = $conn1->prepare("SELECT 
                                                        SUM(CURRENT_IMPMOVES) AS CURRMOVES
                                                    FROM
                                                        slotting.my_npfmvc_cse
                                                    WHERE
                                                        WAREHOUSE = $var_whse");
$result2->execute();
foreach ($result2 as $row) {
    $predictedmoves = intval($row['CURRMOVES']);
}
$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Actual Replens';
$rows2 = array();
$rows2['name'] = 'Predicted Replens';


foreach ($result1 as $row) {
    $rows['data'][] = $row['MVDATE'];
    $rows1['data'][] = intval($row['TOTCOUNT']);
    $rows2['data'][] = $predictedmoves;
}


$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);

print json_encode($result);

