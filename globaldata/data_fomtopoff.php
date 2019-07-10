<?php

ini_set('max_execution_time', 99999);
ini_set('memory_limit', '-1');
include_once '../../connections/conn_slotting.php';
include "../../globalincludes/newcanada_asys.php";
include "../../globalincludes/usa_asys.php";
$tier = $_GET['tier'];
$mc = $_GET['mc'];
$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];

ini_set('max_execution_time', 99999);
include_once("../../globalfunctions/slottingfunctions.php");

//Pull in z-table
$zscoretable = $conn1->prepare("SELECT * FROM slotting.zscores");
$zscoretable->execute();
$zscoretablearray = $zscoretable->fetchAll(pdo::FETCH_NUM);

switch (substr($tier, 0, 1)) {
    case 'C':
        $sql_csls = " and FOMAVGCSLS = 'CSE'";
        break;
    case 'L':
        $sql_csls = " and FOMAVGCSLS = 'LSE'";
        break;

    default:
        break;
}


//pull in FOM demand
$fomresult = $conn1->prepare("SELECT FOMAVGITEM, FOMAVGPKGU, FOMAVGAVG, FOMAVGSTD , FOMAVGCOUNT, concat(FOMAVGWHSE, FOMAVGITEM, FOMAVGCSLS, FOMAVGPKGU) as KEYValue FROM slotting.fomaverage WHERE FOMAVGWHSE = $var_whse $sql_csls");
$fomresult->execute();
$fomresultarray = $fomresult->fetchAll(pdo::FETCH_ASSOC);

$unique = array();
//Rolled up opportunity by item
foreach ($fomresultarray as $current) {
    // create the array key if it doesn't exist already
    if (!array_key_exists($current['FOMAVGITEM'], $unique)) {
        $unique[$current['FOMAVGITEM']] = 0;
    }
}


$USAarray = array(1, 2, 3, 6, 7, 9, 10);  //array of US DCs
$CANarray = array(11, 12, 16);  //array of Canada DCs

if (in_array($var_whse, $USAarray)) {

    #Query the Database into a result set - 
    $result = $aseriesconn->prepare("SELECT LOWHSE as WHSE, LOITEM as ITEM, LOLOC# as LOCATION, LOPKGU as PKGU, LOONHD - LOPRTA + LOPMTQ as ONHAND, LOMINC as LOCMIN, LOMAXC as LOCMAX, VCFTIR as TIER, VCGRD5 as GRID5, WRSROH - LOPMTQ as RESOH, VCCLAS as ITEMMC, LOWHSE||LOITEM||CASE WHEN VCFTIR like 'C%' then 'CSE' else 'LSE' end || LOPKGU as KEYValue FROM A.HSIPCORDTA.NPFLOC, A.HSIPCORDTA.NPFMVC,  A.HSIPCORDTA.NPFWRS WHERE LOLOC# = VCLOC# and LOWHSE = VCWHSE and LOWHSE = WRSWHS and WRSITM = VCITEM and WRSITM = LOITEM and LOITEM not in (select LTITEM from A.HSIPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.HSIPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $var_whse) and VCWHSE = $var_whse and WRSROH - LOPMTQ > 0 and VCCLAS = '" . $mc . "' and VCFTIR = '" . $tier . "'");
    $result->execute();
    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

    //determine whether B or W location.  Take min of location with distinct item so only one reserve is returned
    $result2 = $aseriesconn->prepare("SELECT DISTINCT LOITEM as KEYValue, min(LOLOC#) as LOC FROM A.HSIPCORDTA.NPFLOC WHERE LOSCDE = 'R'  and LOMAXC = 0 and LOONHD - LOPMTQ > 0 and LOWHSE = $var_whse and LOITEM not in (select LTITEM from A.HSIPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.HSIPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $var_whse) GROUP BY LOITEM");
    $result2->execute();
    $reserveresultsetarray = $result2->fetchAll(PDO::FETCH_ASSOC);
} else {


    #Query the Database into a result set - 
    $result = $aseriesconn_can->prepare("SELECT LOWHSE as WHSE, LOITEM as ITEM, LOLOC# as LOCATION, LOPKGU as PKGU, LOONHD - LOPRTA + LOPMTQ as ONHAND, LOMINC as LOCMIN, LOMAXC as LOCMAX, VCFTIR as TIER, VCGRD5 as GRID5, WRSROH - LOPMTQ as RESOH, VCCLAS as ITEMMC, LOWHSE||LOITEM||CASE WHEN VCFTIR like 'C%' then 'CSE' else 'LSE' end || LOPKGU as KEYValue FROM A.HSIPCORDTA.NPFLOC, A.HSIPCORDTA.NPFMVC,  A.HSIPCORDTA.NPFWRS WHERE LOLOC# = VCLOC# and LOWHSE = VCWHSE and LOWHSE = WRSWHS and WRSITM = VCITEM and WRSITM = LOITEM and LOITEM not in (select LTITEM from A.HSIPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.HSIPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $var_whse) and VCWHSE = $var_whse and WRSROH - LOPMTQ > 0 and VCCLAS = '" . $mc . "' and VCFTIR = '" . $tier . "'");
    $result->execute();
    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

    //determine whether B or W location.  Take min of location with distinct item so only one reserve is returned
    $result2 = $aseriesconn_can->prepare("SELECT DISTINCT LOITEM as KEYValue, min(LOLOC#) as LOC FROM A.HSIPCORDTA.NPFLOC WHERE LOSCDE = 'R'  and LOMAXC = 0 and LOONHD - LOPMTQ > 0 and LOWHSE = $var_whse and LOITEM not in (select LTITEM from A.HSIPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.HSIPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $var_whse) GROUP BY LOITEM");
    $result2->execute();
    $reserveresultsetarray = $result2->fetchAll(PDO::FETCH_ASSOC);
}




foreach ($resultsetarray as $key => $value) {
    $keyvalindex = searchForMoves($resultsetarray[$key][11], $fomresultarray);  //using the search for moves function to find fom demand info from fomresultarray
    if (!isset($keyvalindex)) { //if there is no fom demand, unset and continue
        unset($resultsetarray[$key]);
        continue;
    }
        $stderr = number_format(_standarderror($fomresultarray[$keyvalindex]['FOMAVGSTD'], $fomresultarray[$keyvalindex]['FOMAVGCOUNT']), 2);  //call standard error function
    if ($stderr == 0.00) {
        $stderr = floatval(.01);
    }

    $resultsetarray[$key][12] = $fomresultarray[$keyvalindex]['FOMAVGAVG'];  //Add mean demand to end of result array
    $tscore = number_format(_tscore($fomresultarray[$keyvalindex]['FOMAVGAVG'], $stderr, intval($resultsetarray[$key][4])), 2);  //calculates t score for given data.  If t-score is greater than 1.65, then 95% confident we will not sell more than what is on hand
    $highdemand = intval($resultsetarray[$key][12] + (1.65 * $stderr));


    //calculate percent change of stockout based on t-score
    if ($tscore < -3.49) {
        $probstockout = '99.99%';
    } else {
        $searchkey = _searchForKey($tscore, $zscoretablearray, 0);
        if (!$searchkey) {
            $probstockout = 0;
        } else {
           $probstockout = (number_format((1 - $zscoretablearray[$searchkey][1]), 4) * 100) . "%"; //push tscore to end of result array
        }
    }

    if ($highdemand == 0 || $probstockout <= 0) { //if onhand is greater than demand, then continue
        unset($resultsetarray[$key]);
        continue;
    }




    $resultsetarray[$key][13] = $fomresultarray[$keyvalindex]['FOMAVGSTD'];  //Add std to end of result array
    $resultsetarray[$key][14] = $fomresultarray[$keyvalindex]['FOMAVGCOUNT'];  //Add day count to end of result array








    if ($tscore >= 1.65) { //if onhand is greater than demand, then continue
        unset($resultsetarray[$key]);
        continue;
    }

    unset($resultsetarray[$key][11]);  //Remove the keyvalue from the result array
    unset($resultsetarray[$key][12]);  //Remove the FOMAVGAVG from the result array
    unset($resultsetarray[$key][13]);  //Remove the FOMAVGSTD from the result array
    unset($resultsetarray[$key][14]);  //Remove the FOMAVGCOUNT from the result array

    $resultsetarray[$key] = array_values($resultsetarray[$key]);  //Reset array keys
    $resultsetarray[$key][11] = $highdemand;

    $lockeyindex = _searchForLoc($resultsetarray[$key][1], $reserveresultsetarray); //using the search for moves function to find location to determine if bin or case move
    if (isset($lockeyindex)) {
        $movelocation = $reserveresultsetarray[$lockeyindex]['LOC']; //assign move location based on found key
        if (substr($movelocation, 0, 1) !== 'W') { //determine if bin or case move
            $movetype = 'Bin';
        } else {
            $movetype = 'Case';
        }
    } else {
        $movetype = 'Case';
    }

    $resultsetarray[$key][12] = $movetype; //push move type to end of result array
    $resultsetarray[$key][13]  = $probstockout;
}





$output = array(
    "aaData" => array()
);
$row = array();

foreach ($resultsetarray as $key => $value) {

    $row[] = $resultsetarray[$key];
}
$output['aaData'] = $row;
echo json_encode($output);

