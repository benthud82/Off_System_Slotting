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





$sql_deckcount = $conn1->prepare("SELECT count(*) as DECKCOUNT FROM slotting.mysql_npflsm WHERE LMTIER = 'C06' and LMWHSE = $var_whse");
$sql_deckcount->execute();
$array_deckcount = $sql_deckcount->fetchAll(pdo::FETCH_ASSOC);
$deckcount_actual = $array_deckcount[0]['DECKCOUNT'];

$sql_suggcount = $conn1->prepare("SELECT count(*) as SUGGCOUNT  FROM slotting.my_npfmvc_cse where SUGGESTED_TIER = 'C06' and WAREHOUSE = $var_whse");
$sql_suggcount->execute();
$array_suggcount = $sql_suggcount->fetchAll(pdo::FETCH_ASSOC);

$deckcount_sugg = $array_suggcount[0]['SUGGCOUNT'];

$deckcap = $deckcount_actual - $deckcount_sugg;

if ($deckcap >= 0) {
    echo intval($deckcap) . ' excess C06 locations!';
} else {
    echo'Add ' . intval(abs($deckcap)) . ' C06 locations!';
}






