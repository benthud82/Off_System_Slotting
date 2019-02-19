<?php

//get whse for user
$var_userid = $_SESSION['MYUSER'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


$lo4sql = $conn1->prepare("SELECT LMTIER, sum(LMVOL9) as L04VOL FROM slotting.mysql_npflsm WHERE LMWHSE = $var_whse and LMTIER = 'L04' GROUP BY LMTIER;");
$lo4sql->execute();
$lo4sqlarray = $lo4sql->fetchAll(pdo::FETCH_ASSOC);

$availl04vol = ($lo4sqlarray[0]['L04VOL']);

$lo4sql2 = $conn1->prepare("SELECT SUGGESTED_TIER, SUM(SUGGESTED_NEWLOCVOL) as USEDL04VOL, COUNT(*) FROM slotting.my_npfmvc WHERE WAREHOUSE = $var_whse and SUGGESTED_TIER = 'L04' group by SUGGESTED_TIER;");
$lo4sql2->execute();
$lo4sql2array = $lo4sql2->fetchAll(pdo::FETCH_ASSOC);

$usedl04vol = ($lo4sql2array[0]['USEDL04VOL']);

$l04capacity = number_format($usedl04vol / $availl04vol,4);
