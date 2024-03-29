<?php

// Check if username and password are correct
$sessionuser = $_POST["username"];
$sessionpw = $_POST["password"];
require_once 'connection/connection_details.php';
require_once '../globalincludes/usa_asys_session.php';  //does a-system PW work?
require_once 'globaldata/inusertable.php';  //has the user registered?

if (count($usersetarray) == 0) {  //the user is not logged in redirect to registration page
    header('Location: registration.php');
} elseif (isset($aseriesconn)) {

    // If correct, we set the session to YES
    session_start();
    $_SESSION["Login"] = "YES";
    $_SESSION['LAST_ACTIVITY'] = time();
    $_SESSION['MYUSER'] = $_POST["username"];
    $_SESSION['MYPASS'] = $_POST["password"];

    //write to MySQL Database that user logged in:
    require_once 'connection/connection_details.php';
    date_default_timezone_set('America/New_York');
    $datetime = date('Y-m-d H:i:s');
    $usertsm = $_SESSION['MYUSER'];
    $result1 = $conn1->prepare("INSERT INTO slotting.slottingDBlogin (idcustomerauditlogin, customeraudit_TSM, customeraudit_datetime) values (0,'$usertsm','$datetime')");
    $result1->execute();

    header('Location: dashboard.php');
} else {

    // If not correct, we set the session to NO
    session_start();
    $_SESSION["Login"] = "NO";
    echo "<h1>You are NOT logged correctly in </h1>";
}


