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

$build = intval($_GET['building']);
$result1 = $conn1->prepare("SELECT 
                                                        MVDATE,
                                                        slottingscore_hist_CURRCSEMOVES,
                                                        COUNT(1) AS TOTCOUNT
                                                    FROM
                                                        $table
                                                            JOIN
                                                        slotting.slottingscore_hist ON slottingscore_hist_DATE = MVDATE and slottingscore_hist_BUILD = MVBUILD
                                                            LEFT JOIN
                                                        slotting.excl_replenphistorical ON MVDATE = replenexcl_date
                                                            AND replenexcl_whse = $var_whse
                                                    WHERE
                                                        MVDATE >= '$date'
                                                            AND replenexcl_date IS NULL
                                                            AND MVTZNE BETWEEN 7 AND 8
                                                            AND slottingscore_hist_WHSE = $var_whse
                                                                and MVBUILD = $build
                                                    GROUP BY MVDATE , slottingscore_hist_CURRCSEMOVES");
$result1->execute();


$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Actual Replens';
$rows2 = array();
$rows2['name'] = 'Predicted Replens';


foreach ($result1 as $row) {
    $rows['data'][] = $row['MVDATE'];
    $rows1['data'][] = intval($row['TOTCOUNT']);
    $rows2['data'][] = intval($row['slottingscore_hist_CURRCSEMOVES']);
}


$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);

print json_encode($result);

