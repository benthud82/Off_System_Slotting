
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$currentdate = date('Y-m-d');
$startdate = date('Y-m-d', strtotime('-30 days'));

include '../sessioninclude.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}

$sql_equippicks = $conn1->prepare("SELECT 
    predicted_availdate,
    SUM(CASE
        WHEN hist_equip = 'ORDERPICKER' THEN 1
        ELSE 0
    END) AS CURR_OP,
    SUM(CASE
        WHEN SUGG_EQUIP = 'ORDERPICKER' THEN 1
        ELSE 0
    END) AS SUGG_OP,
    SUM(CASE
        WHEN hist_equip = 'BELTLINE' THEN 1
        ELSE 0
    END) AS CURR_PTB,
    SUM(CASE
        WHEN SUGG_EQUIP = 'BELTLINE' THEN 1
        ELSE 0
    END) AS SUGG_PTB,
    SUM(CASE
        WHEN hist_equip = 'PALLETJACK' THEN 1
        ELSE 0
    END) AS CURR_PJ,
    SUM(CASE
        WHEN SUGG_EQUIP = 'PALLETJACK' THEN 1
        ELSE 0
    END) AS SUGG_PJ
FROM
    printvis.hist_casevol
         JOIN
    slotting.my_npfmvc_cse ON hist_whse = WAREHOUSE
        AND hist_item = ITEM_NUMBER
WHERE
    hist_whse = 7
    and predicted_availdate >= '$startdate' and predicted_availdate < '$currentdate'
GROUP BY predicted_availdate");
$sql_equippicks->execute();
$array_equippicks = $sql_equippicks->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($array_equippicks as $key => $value) {

    $predicted_availdate = $array_equippicks[$key]['predicted_availdate'];
    $CURR_OP = $array_equippicks[$key]['CURR_OP'];
    $SUGG_OP = $array_equippicks[$key]['SUGG_OP'];
    $CURR_PTB = $array_equippicks[$key]['CURR_PTB'];
    $SUGG_PTB = $array_equippicks[$key]['SUGG_PTB'];
    $CURR_PJ = $array_equippicks[$key]['CURR_PJ'];
    $SUGG_PJ = $array_equippicks[$key]['SUGG_PJ'];

    $timedif = number_format((($CURR_OP / 80) + ($CURR_PTB / 200) + ($CURR_PJ / 110)) - (($SUGG_OP / 80) + ($SUGG_PTB / 200) + ($SUGG_PJ / 110)), 2);



    $rowpush = array($predicted_availdate, $CURR_OP, $SUGG_OP, $CURR_PTB, $SUGG_PTB, $CURR_PJ, $SUGG_PJ, $timedif);
    $row[] = array_values($rowpush);
}


$output['aaData'] = $row;
echo json_encode($output);

