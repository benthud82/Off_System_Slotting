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





$sql_fromnoncon = $conn1->prepare("SELECT 
                                                                        count(*) as FROMNONCON
                                                                    FROM
                                                                        slotting.npfcpcsettings
                                                                            JOIN
                                                                        slotting.mysql_npflsm ON LMWHSE = CPCWHSE AND LMITEM = CPCITEM
                                                                    WHERE
                                                                        CPCWHSE = $var_whse AND CPCCONV <> 'N'
                                                                            AND LMTIER LIKE 'C%'
                                                                            AND LMSTGT = ('NC')");
$sql_fromnoncon->execute();
$array_fromnoncon = $sql_fromnoncon->fetchAll(pdo::FETCH_ASSOC);
$fromnonconopp = $array_fromnoncon[0]['FROMNONCON'];

echo intval(abs($fromnonconopp)) . ' Opportunities!';







