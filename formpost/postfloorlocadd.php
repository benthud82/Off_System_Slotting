
<?php

include_once '../connection/connection_details.php';
include '../sessioninclude.php';
$var_userid = $_SESSION['MYUSER'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


$location = ($_POST['location']);
$prim = ($_POST['prim']);
$floor = ($_POST['floor']);




//update completed item task table and mark status as 'COMPLETE'


$sql = "INSERT INTO slotting.case_floor_locs (WHSE, LOCATION, PRIM_RES, FLOOR) VALUES ($var_whse, '$location', '$prim', '$floor');";
$query = $conn1->prepare($sql);
$query->execute();


