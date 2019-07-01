
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

include '../sessioninclude.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}

$sql_fromnoncon = $conn1->prepare("SELECT 
                                                                        LMITEM,
                                                                        LMLOC,
                                                                        LMTIER,
                                                                        CPCCPKU,
                                                                        CPCCLEN,
                                                                        CPCCHEI,
                                                                        CPCCWID,
                                                                        CPCCWEI,
                                                                        CPCCONV
                                                                    FROM
                                                                        slotting.npfcpcsettings
                                                                            JOIN
                                                                        slotting.mysql_npflsm ON LMWHSE = CPCWHSE AND LMITEM = CPCITEM
                                                                    WHERE
                                                                        CPCWHSE = $var_whse AND CPCCONV <> 'N'
                                                                            AND LMTIER LIKE 'C%'
                                                                            AND LMSTGT = ('NC')
                                                                    ORDER BY (CPCCLEN * CPCCHEI * CPCCWID) ASC");
$sql_fromnoncon->execute();
$array_fromnoncon = $sql_fromnoncon->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($array_fromnoncon as $key => $value) {
    $row[] = array_values($array_fromnoncon[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);

