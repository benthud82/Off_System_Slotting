
<?php

include_once '../connection/connection_details.php';
//date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d');
$autoid = 0;

$itemnum = intval($_POST['itemnum']);
$userid = ($_POST['userid']);

$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
$whsenum = intval($whssqlarray[0]['slottingDB_users_PRIMDC']);



$columns = 'frompfr_id, frompfr_whse, frompfr_item, frompfr_tsmid, frompfr_reviewdate';
$values = "0, $whsenum, '$itemnum',  '$userid' , '$datetime'";


$sql = "INSERT INTO slotting.frompfrreview ($columns) VALUES ($values)";
$query = $conn1->prepare($sql);
$query->execute();

