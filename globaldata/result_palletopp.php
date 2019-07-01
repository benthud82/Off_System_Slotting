<?php

include_once '../connection/connection_details.php';
$var_userid = $_POST['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];

//determine if Sparks building one or two
if ($var_whse == 32) {
    $sparksbuild2filter = " >= 'W300000'";
    $var_whse = 3;
} elseif ($var_whse == 3) {
    $sparksbuild2filter = " <= 'W299999'";
} else {
    $sparksbuild2filter = " >= ' '";
}





$sql_palletopp = $conn1->prepare("SELECT 
                                                                    COUNT(*) AS PALLETOPP
                                                                FROM
                                                                    slotting.my_npfmvc_cse
                                                                        JOIN
                                                                    slotting.npfcpcsettings ON CPCWHSE = WAREHOUSE
                                                                        AND CPCITEM = ITEM_NUMBER
                                                                WHERE
                                                                    WAREHOUSE = $var_whse AND SUGGESTED_TIER = 'PFR'
                                                                        AND AVG_DAILY_PICK >= 1
                                                                        AND CPCPPKU = 0");
$sql_palletopp->execute();
$array_palletopp = $sql_palletopp->fetchAll(pdo::FETCH_ASSOC);
$palletopp = $array_palletopp[0]['PALLETOPP'];


echo intval(abs($palletopp)) . ' Opportunities!';







