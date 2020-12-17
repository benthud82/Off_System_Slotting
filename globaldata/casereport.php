
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$var_userid = strtoupper($_GET['userid']);
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE UPPER(idslottingDB_users_ID) = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
$var_report = ($_GET['reportsel']);
$var_tier = ($_GET['tiersel']);


switch ($var_report) {  //build sql statement for report
    case 'MOVEIN':
        if ($var_tier == 'DECK') {
            $reportsql = "and LMTIER <> 'C06' and SUGGESTED_TIER = 'C06'";
            $orderby = ' AVG_DAILY_PICK asc';
        } else if ($var_tier == 'PFR') {
            $reportsql = " ";
        } else if ($var_tier == 'PALLET') {
            $reportsql = " ";
        } else if ($var_tier == 'ALL') {
            $reportsql = " ";
            $orderby = ' AVG_DAILY_PICK asc';
        }

        break;

    case 'MOVEOUT':
        if ($var_tier == 'DECK') {
            $reportsql = "and LMTIER = 'C06' and SUGGESTED_TIER = 'PFR'";
            $orderby = ' CURRENT_IMPMOVES desc';
        } else if ($var_tier == 'PFR') {
            $reportsql = " ";
        } else if ($var_tier == 'PALLET') {
            $reportsql = " CURRENT_IMPMOVES desc";
        } else if ($var_tier == 'ALL') {
            $reportsql = " ";
            $orderby = ' AVG_DAILY_PICK asc';
        }

        break;
}


$bayreport = $conn1->prepare("SELECT 
                                    A.WAREHOUSE,
                                    A.ITEM_NUMBER,
                                    A.CUR_LOCATION,
                                    A.DAYS_FRM_SLE,
                                    A.AVGD_BTW_SLE,
                                    A.LMGRD5,
                                    A.LMDEEP,
                                    A.SUGGESTED_GRID5,
                                    A.SUGGESTED_DEPTH,
                                    A.LMTIER,
                                    A.SUGGESTED_TIER,
                                    A.SUGG_LEVEL,
                                    A.SUGGESTED_MAX,
                                    A.SUGGESTED_MIN,
                                    cast(A.SUGGESTED_IMPMOVES * 253 as UNSIGNED),
                                    cast(A.CURRENT_IMPMOVES * 253 as UNSIGNED),
                                    cast(A.AVG_DAILY_PICK as DECIMAL(4,2)),
                                    cast(A.AVG_DAILY_UNIT as DECIMAL(4,2)),
                                    DLY_CUBE_VEL,
                                    CASE
                                    WHEN
                                        CUR_LOCATION = 'PFR'
                                    THEN
                                        (SELECT 
                                                SUM(locoh_onhand)
                                            FROM
                                                nahsi.loc_oh
                                            WHERE
                                                locoh_whse = WAREHOUSE
                                                    AND locoh_item = ITEM_NUMBER
                                                    AND (locoh_loc like 'W%' or locoh_loc like 'R%'))
                                    ELSE (SELECT 
                                            SUM(locoh_onhand)
                                        FROM
                                            nahsi.loc_oh
                                        WHERE
                                            locoh_whse = WAREHOUSE
                                                AND locoh_item = ITEM_NUMBER
                                                AND locoh_loc = CUR_LOCATION)
                                END AS locoh_onhand
                                FROM
                                    slotting.my_npfmvc_cse A
                                    LEFT JOIN slotting.loc_oh on locoh_whse = WAREHOUSE and locoh_item = ITEM_NUMBER and locoh_loc = CUR_LOCATION
                                WHERE
                                    A.WAREHOUSE = $var_whse
                                         $reportsql
                                ORDER BY $orderby");
$bayreport->execute();
$bayreportarray = $bayreport->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($bayreportarray as $key => $value) {
    $row[] = array_values($bayreportarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
