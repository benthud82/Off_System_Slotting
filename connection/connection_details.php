<?php

////Connect to MySQL
//$dbtype = "mysql";
//$dbhost = "localhost"; // Host name 
//$dbuser = "root"; // Mysql username 
//$dbpass = ""; // Mysql password 
//$dbname = "slotting"; // Database name 
//$conn1 = new PDO("{$dbtype}:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array());
//$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



//Connect to MySQL
$dbtype = "mysql";
$dbhost = "localhost"; // Host name 
$dbuser = "root"; // Mysql username 
$dbpass = "dave41"; // Mysql password 
$dbname = "slotting"; // Database name 
$conn1 = new PDO("{$dbtype}:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array());
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);