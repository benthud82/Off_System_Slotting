<?php
include '../sessioninclude.php';
include '../../connections/conn_printvis.php';
include '../../globalfunctions/custdbfunctions.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
    $whsesel = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}
$build = intval($_POST['building']);
//average pick reduction opportunity
$sql_hourred = $conn1->prepare("SELECT 
                                                                AVG(equippicks_hourred) as HOUR_RED
                                                            FROM
                                                                printvis.casedash_equippicks
                                                            WHERE
                                                                equippicks_whse = $var_whse and equippicks_build = $build
                                                                    AND equippicks_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();");
$sql_hourred->execute();
$array_hourred = $sql_hourred->fetchAll(pdo::FETCH_ASSOC);
$hourred = number_format($array_hourred[0]['HOUR_RED'], 2);

//daily replen reduction opportunity
$sql_replenred = $conn1->prepare("SELECT 
                                                            SUM(CURRENT_IMPMOVES) - SUM(SUGGESTED_IMPMOVES) AS REPLEN_RED
                                                        FROM
                                                            slotting.my_npfmvc_cse
                                                        WHERE
                                                            WAREHOUSE = $var_whse and BUILDING = $build");
$sql_replenred->execute();
$array_replenred = $sql_replenred->fetchAll(pdo::FETCH_ASSOC);
$replenred = intval($array_replenred[0]['REPLEN_RED']);

echo 'Avg open put TEST';
echo '<br>';
echo $replenred;
?>

