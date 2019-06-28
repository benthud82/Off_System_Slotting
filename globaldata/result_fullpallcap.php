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





$sql_pallcount = $conn1->prepare("SELECT count(*) as PALLCOUNT FROM slotting.mysql_npflsm WHERE LMTIER = 'C03' and LMWHSE = $var_whse");
$sql_pallcount->execute();
$array_pallcount = $sql_pallcount->fetchAll(pdo::FETCH_ASSOC);
$pallcount_actual = $array_pallcount[0]['PALLCOUNT'];

$sql_suggcount = $conn1->prepare("SELECT count(*) as SUGGCOUNT  FROM slotting.my_npfmvc_cse where SUGGESTED_TIER = 'C03' and WAREHOUSE = $var_whse");
$sql_suggcount->execute();
$array_suggcount = $sql_suggcount->fetchAll(pdo::FETCH_ASSOC);

$pallcount_sugg = $array_suggcount[0]['SUGGCOUNT'];

$pallcap = $pallcount_actual - $pallcount_sugg;

if ($pallcap >= 0) {
    echo intval($pallcap) . ' excess C03 locations!';
} else {
    echo'Add ' . intval(abs($pallcap)) . ' C03 locations!';
}






