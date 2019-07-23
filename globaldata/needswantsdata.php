
<?php

if (!function_exists('array_column')) {

    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if (!isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

}
ini_set('max_execution_time', 99999);

include_once '../connection/connection_details.php';

$userid = strtoupper($_GET['userid']);
$baynum = intval($_GET['baynum']);
$tiersel = ($_GET['tiersel']);

$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE UPPER(idslottingDB_users_ID) = '$userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


//pull in distict grids either used or suggested
$distinctgridsql = $conn1->prepare("SELECT DISTINCT
                                                                    GRID5_DEP
                                                                FROM
                                                                    (SELECT 
                                                                        CONCAT(SUGGESTED_GRID5, '-', SUGGESTED_DEPTH) AS GRID5_DEP, SUGGESTED_NEWLOCVOL as LMVOL9
                                                                    FROM
                                                                        slotting.my_npfmvc M
                                                                    JOIN slotting.optimalbay ON OPT_WHSE = WAREHOUSE
                                                                        AND OPT_ITEM = ITEM_NUMBER
                                                                        AND OPT_PKGU = PACKAGE_UNIT
                                                                    WHERE
                                                                        WAREHOUSE = $var_whse AND SUGGESTED_TIER = '$tiersel'
                                                                            AND OPT_OPTBAY = $baynum UNION SELECT 
                                                                        CONCAT(LMGRD5, '-', LMDEEP) AS GRID5_DEP, LMVOL9
                                                                    FROM
                                                                        slotting.mysql_npflsm L
                                                                    WHERE
                                                                        LMWHSE = $var_whse AND LMGRD5 <> ''
                                                                            AND CAST(SUBSTRING(LMLOC, 4, 2) AS UNSIGNED) = $baynum
                                                                            AND LMTIER = '$tiersel') T ORDER BY LMVOL9");
$distinctgridsql->execute();
$distinctgridarray = $distinctgridsql->fetchAll(pdo::FETCH_ASSOC);

//pull in suggested count by grid5_dep
$suggestedgridsql = $conn1->prepare("SELECT 
                                                                            CONCAT(SUGGESTED_GRID5,'-', SUGGESTED_DEPTH) AS SUG_GRID5_DEP,
                                                                            COUNT(*) as SUG_COUNT
                                                                        FROM
                                                                            slotting.my_npfmvc
                                                                                JOIN
                                                                            slotting.optimalbay ON OPT_WHSE = WAREHOUSE
                                                                                AND OPT_ITEM = ITEM_NUMBER
                                                                                AND OPT_PKGU = PACKAGE_UNIT
                                                                        WHERE
                                                                            WAREHOUSE = $var_whse AND SUGGESTED_TIER = '$tiersel'
                                                                                AND OPT_OPTBAY = $baynum
                                                                        GROUP BY CONCAT(SUGGESTED_GRID5, SUGGESTED_DEPTH)
                                                                        ORDER BY SUGGESTED_NEWLOCVOL ASC");
$suggestedgridsql->execute();
$suggestedgridarray = $suggestedgridsql->fetchAll(pdo::FETCH_ASSOC);

//pull in current count by grid5_dep
$currentgridsql = $conn1->prepare("SELECT 
                                                                        CONCAT(LMGRD5, '-', LMDEEP) as CUR_GRID5_DEP, COUNT(*) as CUR_COUNT
                                                                    FROM
                                                                        slotting.mysql_npflsm
                                                                    WHERE
                                                                        LMWHSE = $var_whse AND LMGRD5 <> ''
                                                                            AND CAST(SUBSTRING(LMLOC, 4, 2) AS UNSIGNED) = $baynum
                                                                            AND LMTIER = '$tiersel'
                                                                    GROUP BY CONCAT(LMGRD5, '-', LMDEEP)
                                                                    ORDER BY LMVOL9;");
$currentgridsql->execute();
$currentgridarray = $currentgridsql->fetchAll(pdo::FETCH_ASSOC);

$output = array(
    "aaData" => array()
);
$row = array();


//join all three arrays for complete needs wants table
foreach ($distinctgridarray as $key => $value) {
    $grid5_dep = $distinctgridarray[$key]['GRID5_DEP'];
    //find if grid5 is in suggtested array
    $suggestedkey = array_search($grid5_dep, array_column($suggestedgridarray, 'SUG_GRID5_DEP'));
    if ($suggestedkey !== FALSE) {
        $distinctgridarray[$key]['SUG_COUNT'] = intval($suggestedgridarray[$suggestedkey]['SUG_COUNT']);
    } else {
        $distinctgridarray[$key]['SUG_COUNT'] = 0;
    }


    //find if grid5 is in current array
    $currentkey = array_search($grid5_dep, array_column($currentgridarray, 'CUR_GRID5_DEP'));
    if ($currentkey !== FALSE) {
        $distinctgridarray[$key]['CUR_COUNT'] = intval($currentgridarray[$currentkey]['CUR_COUNT']);
    } else {
        $distinctgridarray[$key]['CUR_COUNT'] = 0;
    }

    //push count +/-
    $distinctgridarray[$key]['PLUS_MINUS_COUNT'] = intval($distinctgridarray[$key]['CUR_COUNT']) - intval($distinctgridarray[$key]['SUG_COUNT']);

    //push volume +/-
    $distinctgridarray[$key]['PLUS_MINUS_VOL'] = (intval(substr($distinctgridarray[$key]['GRID5_DEP'], 0, 2)) * intval(substr($distinctgridarray[$key]['GRID5_DEP'], 3, 2)) * intval(substr($distinctgridarray[$key]['GRID5_DEP'], 6)) ) * (intval($distinctgridarray[$key]['CUR_COUNT']) - intval($distinctgridarray[$key]['SUG_COUNT']));

    $row[] = array_values($distinctgridarray[$key]);
}

$output['aaData'] = $row;
echo json_encode($output);
