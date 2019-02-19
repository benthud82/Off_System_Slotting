
<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';

$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = intval($whssqlarray[0]['slottingDB_users_PRIMDC']);

$var_report = ($_GET['reportsel']);



switch ($var_report) {  //build sql statement for report
    case 'highwalk':

        $whercaluse = ' B.OPT_ADDTLFTPERDAY > 0 ';
        $orderby = ' B.OPT_ADDTLFTPERDAY DESC';
        break;

    case 'negativewalk':

        $whercaluse = ' B.OPT_ADDTLFTPERDAY < 0' ;
        $orderby = ' B.OPT_ADDTLFTPERDAY ASC';
        break;
}


$dopoundsql = $conn1->prepare("SELECT DISTINCT
                                                                A.WAREHOUSE,
                                                                A.ITEM_NUMBER,
                                                                A.CUR_LOCATION,
                                                                lot_lot as LOT,
                                                                B.OPT_ADDTLFTPERDAY,
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
                                                                CAST(A.SUGGESTED_IMPMOVES * 253 AS UNSIGNED),
                                                                CAST(A.CURRENT_IMPMOVES * 253 AS UNSIGNED),
                                                                CAST(A.AVG_DAILY_PICK AS DECIMAL (4 , 2 )),
                                                                CAST(A.AVG_DAILY_UNIT AS DECIMAL (4 , 2 )),
                                                                CONCAT(CAST(E.SCORE_REPLENSCORE * 100 AS DECIMAL (5 , 2 )),
                                                                        '%'),
                                                                CONCAT(CAST(E.SCORE_WALKSCORE * 100 AS DECIMAL (5 , 2 )),
                                                                        '%'),
                                                                CONCAT(CAST(E.SCORE_TOTALSCORE * 100 AS DECIMAL (5 , 2 )),
                                                                        '%')
                                                            FROM
                                                                slotting.my_npfmvc A
                                                                    JOIN
                                                                slotting.optimalbay B ON A.WAREHOUSE = B.OPT_WHSE
                                                                    AND A.ITEM_NUMBER = B.OPT_ITEM
                                                                    AND A.PACKAGE_UNIT = B.OPT_PKGU
                                                                    AND A.PACKAGE_TYPE = B.OPT_CSLS
                                                                    LEFT JOIN
                                                                slotting.mysql_npflsm C ON C.LMWHSE = A.WAREHOUSE
                                                                    AND C.LMITEM = A.ITEM_NUMBER
                                                                    AND C.LMTIER = A.LMTIER
                                                                    JOIN
                                                                slotting.slottingscore E ON E.SCORE_WHSE = A.WAREHOUSE
                                                                    AND E.SCORE_ITEM = A.ITEM_NUMBER
                                                                    AND E.SCORE_PKGU = A.PACKAGE_UNIT
                                                                    AND E.SCORE_ZONE = A.PACKAGE_TYPE
                                                                    LEFT JOIN
                                                                slotting.dsl2locs ON dsl2whs = A.WAREHOUSE
                                                                    AND dsl2item = A.ITEM_NUMBER
                                                                    AND dsl2pkgu = A.PACKAGE_UNIT
                                                                    LEFT JOIN slotting.npflot on lot_item = A.ITEM_NUMBER
                                                            WHERE
                                                                A.WAREHOUSE = $var_whse AND dsl2csls IS NULL
                                                                    AND LMSLR NOT IN (2 , 4)
                                                                    and A.SUGGESTED_TIER = 'L04'
                                                                    and PACKAGE_TYPE =  'LSE'
                                                                    AND $whercaluse
                                                                    ORDER BY $orderby");
$dopoundsql->execute();
$dopoundsqlarray = $dopoundsql->fetchAll(pdo::FETCH_ASSOC);


$output = array(
    "aaData" => array()
);
$row = array();

foreach ($dopoundsqlarray as $key => $value) {
    $row[] = array_values($dopoundsqlarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
