
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
$var_bay = intval($_GET['baynum']);
$var_report = ($_GET['reportsel']);
$var_tier = ($_GET['tiersel']);
$var_grid5sel = substr($_GET['grid5sel'], 0, 5);
if ($var_grid5sel == '%') {
    $var_grid5dep = '%';
} else {
    $var_grid5dep = intval(substr($_GET['grid5sel'], 7));
}
$var_returncount = ($_GET['returncount']);

switch ($var_report) {  //build sql statement for report
    case 'MOVEIN':
        if ($var_tier == 'L01') {
            $reportsql = " A.SUGGESTED_TIER = 'L01' and A.LMTIER <> 'L01' ";
        } else if ($var_tier == 'L02') {
            $reportsql = " A.SUGGESTED_TIER = 'L02' and A.LMTIER <> 'L02' ";
        } else {
            $reportsql = " B.OPT_OPTBAY = $var_bay and B.OPT_CURRBAY <> $var_bay  and A.SUGGESTED_GRID5 like '$var_grid5sel' and A.SUGGESTED_DEPTH like '$var_grid5dep' and A.SUGGESTED_TIER in ('$var_tier')   ";
        }
        break;

    case 'MOVEOUT':
        if ($var_tier == 'L01') {
            $reportsql = " A.SUGGESTED_TIER <> 'L01' and A.LMTIER = 'L01' ";
        } else if ($var_tier == 'L02') {
            $reportsql = " A.SUGGESTED_TIER <> 'L02' and A.LMTIER = 'L02' ";
        } else {
            $reportsql = " B.OPT_OPTBAY <> $var_bay and B.OPT_CURRBAY = $var_bay  and A.LMGRD5  like '$var_grid5sel' and A.LMDEEP   like '$var_grid5dep' and A.SUGGESTED_TIER  in ('$var_tier') and A.LMTIER <> 'L06' ";
        }
        break;

    case 'CURRENT':
        $reportsql = " B.OPT_CURRBAY = $var_bay";
        break;

    case 'SHOULD':
        $reportsql = " B.OPT_OPTBAY = $var_bay";
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
                                    B.OPT_CURRBAY,
                                    A.SUGGESTED_GRID5,
                                    A.SUGGESTED_DEPTH,
                                    B.OPT_OPTBAY,
                                    A.SUGGESTED_MAX,
                                    A.SUGGESTED_MIN,
                                    cast(A.SUGGESTED_IMPMOVES * 253 as UNSIGNED),
                                    cast(A.CURRENT_IMPMOVES * 253 as UNSIGNED),
                                    cast(A.AVG_DAILY_PICK as DECIMAL(4,2)),
                                    cast(A.AVG_DAILY_UNIT as DECIMAL(4,2)),
                                    CONCAT(cast(E.SCORE_REPLENSCORE * 100 as DECIMAL(5,2)) , '%'),
                                    CONCAT(cast(E.SCORE_WALKSCORE * 100 as DECIMAL(5,2)) , '%'),
                                    CONCAT(cast(E.SCORE_TOTALSCORE * 100 as DECIMAL(5,2)) , '%')
                                FROM
                                    slotting.my_npfmvc A
                                        join
                                    slotting.optimalbay B ON A.WAREHOUSE = B.OPT_WHSE
                                        and A.ITEM_NUMBER = B.OPT_ITEM
                                        and A.PACKAGE_UNIT = B.OPT_PKGU
                                        and A.PACKAGE_TYPE = B.OPT_CSLS
                                        join
                                    slotting.mysql_npflsm C ON C.LMWHSE = A.WAREHOUSE
                                        and C.LMITEM = A.ITEM_NUMBER
                                        and C.LMTIER = A.LMTIER
                                        join
                                    slotting.system_npfmvc D ON D.VCWHSE = A.WAREHOUSE
                                        and D.VCITEM = A.ITEM_NUMBER
                                        and D.VCPKGU = A.PACKAGE_UNIT
                                        and D.VCFTIR = A.LMTIER
                                        join
                                    slotting.slottingscore E ON E.SCORE_WHSE = A.WAREHOUSE
                                        AND E.SCORE_ITEM = A.ITEM_NUMBER
                                        AND E.SCORE_PKGU = A.PACKAGE_UNIT
                                        AND E.SCORE_ZONE = A.PACKAGE_TYPE
                                     left join slotting.dsl2locs on dsl2whs = A.WAREHOUSE
                                        and dsl2item = A.ITEM_NUMBER and dsl2pkgu = A.PACKAGE_UNIT
                                WHERE
                                    A.WAREHOUSE = $var_whse
                                        and dsl2csls is null
                                        and $reportsql
                                        and LMSLR not in (2,4)
                                ORDER BY E.SCORE_REPLENSCORE ASC LIMIT $var_returncount");
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
