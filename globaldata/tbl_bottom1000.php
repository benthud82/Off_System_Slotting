
<?php

include_once '../sessioninclude.php';
include_once '../connection/connection_details.php';

ini_set('max_execution_time', 99999);
$var_userid = strtoupper($_SESSION['MYUSER']);
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE UPPER(idslottingDB_users_ID) = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];

include_once '../connection/connection_details.php';

$vectormapdata = $conn1->prepare("SELECT 
    NULL,
    ' ',
    ITEM_NUMBER,
    PACKAGE_UNIT,
    CUR_LOCATION,
    A.LMTIER,
    SUGGESTED_TIER,
    A.LMGRD5,
    SUGGESTED_GRID5,
    SUGGESTED_DEPTH,
    SUGGESTED_SLOTQTY,
    SUGGESTED_MAX,
    CURMAX,
    OPT_OPTBAY,
    OPT_CURRBAY,
    CAST(CURRENT_IMPMOVES * 253 AS UNSIGNED) AS CURRENT_IMPMOVES,
    CAST(SUGGESTED_IMPMOVES * 253 AS UNSIGNED) AS SUGGESTED_IMPMOVES,
    TRUNCATE(AVG_DAILY_PICK, 1),
    TRUNCATE(AVG_DAILY_UNIT, 1),
    CONCAT(TRUNCATE(SCORE_TOTALSCORE * 100, 2), '%'),
    CONCAT(TRUNCATE(SCORE_TOTALSCORE_OPT * 100, 2),
            '%'),
    CONCAT(TRUNCATE(SCORE_REPLENSCORE * 100, 2),
            '%'),
    CONCAT(TRUNCATE(SCORE_REPLENSCORE_OPT * 100, 2),
            '%'),
    CONCAT(TRUNCATE(SCORE_WALKSCORE * 100, 2), '%'),
    CONCAT(TRUNCATE(SCORE_WALKSCORE_OPT * 100, 2),
            '%'),
            case when openactions_assignedto IS NULL then '-' else openactions_assignedto end as ASSNTSM,
            case when openactions_comment IS NULL then '-' else openactions_comment end as ASSNCMT
FROM
    slotting.slottingscore
        JOIN
    slotting.my_npfmvc A ON SCORE_WHSE = WAREHOUSE
        AND SCORE_ITEM = ITEM_NUMBER
        AND SCORE_PKGU = PACKAGE_UNIT
        AND SCORE_ZONE = PACKAGE_TYPE
        LEFT JOIN
    slotting.itemsmoved_2018goal ON goal_whse = SCORE_WHSE
        AND goal_item = ITEM_NUMBER
        AND goal_pkgu = PACKAGE_UNIT
        LEFT JOIN
    slotting.item_settings ON WHSE = WAREHOUSE AND ITEM = ITEM_NUMBER
        AND PKGU = PACKAGE_UNIT
        JOIN
    slotting.mysql_npflsm D ON D.LMWHSE = WAREHOUSE
        AND D.LMITEM = ITEM_NUMBER
        AND D.LMPKGU = PACKAGE_UNIT
        JOIN
    slotting.optimalbay ON OPT_WHSE = SCORE_WHSE
        AND OPT_ITEM = SCORE_ITEM
        AND OPT_PKGU = SCORE_PKGU
        AND OPT_CSLS = SCORE_ZONE
        left join slotting.dsl2locs on dsl2whs = A.WAREHOUSE
 and dsl2item = A.ITEM_NUMBER and dsl2pkgu = A.PACKAGE_UNIT
 LEFT JOIN slotting.slottingdb_itemactions on openactions_whse = SCORE_WHSE and openactions_item = SCORE_ITEM
WHERE
    SCORE_WHSE = $var_whse AND SCORE_BOTTOM1000 = 1
        AND A.LMTIER <> 'L01'
        AND SUGGESTED_TIER <> 'L01'
        and  LMSLR not in (2,4)
        AND PACKAGE_UNIT = 1
        AND goal_item IS NULL
        AND (HOLDLOCATION IS NULL
        and dsl2csls is null 
        OR HOLDLOCATION = ' ')
ORDER BY SCORE_TOTALSCORE_OPT - SCORE_TOTALSCORE DESC , SCORE_TOTALSCORE ASC , SCORE_REPLENSCORE ASC , SCORE_WALKSCORE ASC
LIMIT 150");
$vectormapdata->execute();
$vectormapdataarray = $vectormapdata->fetchAll(pdo::FETCH_ASSOC);



$output = array(
    "aaData" => array()
);
$row = array();

foreach ($vectormapdataarray as $key => $value) {
    $row[] = array_values($vectormapdataarray[$key]);
}


$output['aaData'] = $row;
echo json_encode($output);
