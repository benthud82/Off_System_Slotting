<?php

include_once '../connection/connection_details.php';
$var_userid = $_POST['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
$startdate = date("Y-m-d", strtotime('-30 days'));



$sql_floorerr = $conn1->prepare("SELECT 
                                                                        COUNT(DISTINCT hist_loc) as LOCCOUNT
                                                                    FROM
                                                                        printvis.hist_casevol
                                                                            LEFT JOIN
                                                                        slotting.case_floor_locs ON WHSE = hist_whse AND LOCATION = hist_loc
                                                                    WHERE
                                                                        hist_whse = $var_whse
                                                                            AND predicted_availdate >= '$startdate'
                                                                            AND LOCATION IS NULL
                                                                            AND hist_loc NOT LIKE 'B%'
                                                                            AND hist_loc NOT LIKE 'I%'
                                                                            AND hist_loc NOT LIKE 'Y%'
");
$sql_floorerr->execute();
$array_floorerr = $sql_floorerr->fetchAll(pdo::FETCH_ASSOC);
$floorerr = $array_floorerr[0]['LOCCOUNT'];


echo intval(abs($floorerr)) . ' Opportunities!';







