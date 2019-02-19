<?php
//add the user to the slottingdb_users table
include_once '../connection/connection_details.php';

$userid = $_POST["username"];
$userfirst = $_POST["firstname"];
$userlast = $_POST["lastname"];
$userDC = intval($_POST["whsesel"]);

$result1 = $conn1->prepare("INSERT INTO slotting.slottingdb_users (idslottingDB_users_ID, slottingDB_users_FIRSTNAME, slottingDB_users_LASTNAME, slottingDB_users_PRIMDC) values ('$userid','$userfirst','$userlast', $userDC)");
$result1->execute();

header('Location: ../signin.php');