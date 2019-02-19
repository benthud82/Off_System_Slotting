<?php

ini_set('max_execution_time', 99999);
ini_set('memory_limit', '-1');
$whse = $_GET['whse'];
$tier = $_GET['tier'];
$mc = $_GET['mc'];

//$whse = 7;
//$tier = 'L02';
//$mc = 'A';

switch ($whse) {
    case "Dallas":
        $whsenum = 7;
        break;
    case "Denver":
        $whsenum = 6;
        break;
    case "Sparks":
        $whsenum = 3;
        break;
    case "Indy":
        $whsenum = 2;
        break;
    case "Jax":
        $whsenum = 9;
        break;
    case "Calgary":
        $whsenum = 16;
        break;
    case "Vanc":
        $whsenum = 12;
        break;
    case "NOTL":
        $whsenum = 11;
        break;
    default :
        $whsenum = $whse;
        break;
}



ini_set('max_execution_time', 99999);
include_once("../globalfunctions/slottingfunctions.php");


$dbtype = "mysql";
$dbhost = "nahsifljaws01"; // Host name 
$dbuser = "slotadmin"; // Mysql username 
$dbpass = "slotadmin"; // Mysql password 
$dbname = "slotting"; // Database name 

$conn1 = new PDO("{$dbtype}:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));

//Pull in z-table
$zscoretable = $conn1->prepare("SELECT * FROM slotting.zscores");
$zscoretable->execute();
$zscoretablearray = $zscoretable->fetchAll(pdo::FETCH_NUM);



//pull in Non-FOM demand
$fomresult = $conn1->prepare("SELECT FOMAVGITEM, FOMAVGPKGU, FOMAVGAVG, FOMAVGSTD , FOMAVGCOUNT, concat(FOMAVGWHSE, FOMAVGITEM, FOMAVGPKGU) as KEYValue FROM slotting.fomaverage WHERE FOMAVGWHSE = $whsenum");
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

if (in_array($whsenum, $USAarray)) {

    $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
    $pdo_username = "BHUD01";
    $pdo_password = "tucker1234";
    $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

    #Query the Database into a result set - 
    $result = $aseriesconn->prepare("SELECT LOWHSE as WHSE, LOITEM as ITEM, LOLOC# as LOCATION, LOPKGU as PKGU, LOONHD - LOPRTA + LOPMTQ as ONHAND, LOMINC as LOCMIN, LOMAXC as LOCMAX, VCFTIR as TIER, VCGRD5 as GRID5, WRSROH - LOPMTQ as RESOH, VCCLAS as ITEMMC, LOWHSE||LOITEM||LOPKGU as KEYValue FROM A.HSIPCORDTA.NPFLOC, A.HSIPCORDTA.NPFMVC,  A.HSIPCORDTA.NPFWRS WHERE LOLOC# = VCLOC# and LOWHSE = VCWHSE and LOWHSE = WRSWHS and WRSITM = VCITEM and WRSITM = LOITEM and LOITEM not in (select LTITEM from A.HSIPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.HSIPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $whsenum) and VCWHSE = $whsenum and WRSROH - LOPMTQ > 0 and VCCLAS = '" . $mc . "' and VCFTIR = '" . $tier . "'");
    $result->execute();
    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

    //determine whether B or W location.  Take min of location with distinct item so only one reserve is returned
    $result2 = $aseriesconn->prepare("SELECT DISTINCT LOITEM as KEYValue, min(LOLOC#) as LOC FROM A.HSIPCORDTA.NPFLOC WHERE LOSCDE = 'R'  and LOMAXC = 0 and LOONHD - LOPMTQ > 0 and LOWHSE = $whsenum and LOITEM not in (select LTITEM from A.HSIPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.HSIPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $whsenum) GROUP BY LOITEM");
    $result2->execute();
    $reserveresultsetarray = $result2->fetchAll(PDO::FETCH_ASSOC);
} else {
    $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
    $pdo_username = "BHUDS1";
    $pdo_password = "tucker1234";
    $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

#Query the Database into a result set - 
    $result = $aseriesconn->prepare("SELECT LOWHSE as WHSE, LOITEM as ITEM, LOLOC# as LOCATION, LOPKGU as PKGU, LOONHD - LOPRTA + LOPMTQ as ONHAND, LOMINC as LOCMIN, LOMAXC as LOCMAX, VCFTIR as TIER, VCGRD5 as GRID5, WRSROH - LOPMTQ as RESOH, VCCLAS as ITEMMC, LOWHSE||LOITEM||LOPKGU as KEYValue FROM A.ARCPCORDTA.NPFLOC, A.ARCPCORDTA.NPFMVC,  A.ARCPCORDTA.NPFWRS WHERE LOLOC# = VCLOC# and LOWHSE = VCWHSE and LOWHSE = WRSWHS and WRSITM = VCITEM and WRSITM = LOITEM and LOITEM not in (select LTITEM from A.ARCPCORDTA.NPFLOT where LTFLAG <> '') and LOITEM not in (select LMITEM from A.ARCPCORDTA.NPFLSM where LMSLR# = '2' and LMWHSE = $whsenum) and VCWHSE = $whsenum and WRSROH - LOPMTQ > 0 and VCCLAS = '" . $mc . "' and VCFTIR = '" . $tier . "'");
    $result->execute();
    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);
}




foreach ($resultsetarray as $key => $value) {

    $keyvalindex = searchForMoves($resultsetarray[$key][11], $fomresultarray);  //using the search for moves function to find fom demand info from fomresultarray
    if (!isset($keyvalindex)) { //if there is no fom demand, unset and continue
        unset($resultsetarray[$key]);
        continue;
    }

    $resultsetarray[$key][12] = $fomresultarray[$keyvalindex]['FOMAVGAVG'];  //Add mean demand to end of result array
    $resultsetarray[$key][13] = $fomresultarray[$keyvalindex]['FOMAVGSTD'];  //Add std to end of result array
    $resultsetarray[$key][14] = $fomresultarray[$keyvalindex]['FOMAVGCOUNT'];  //Add day count to end of result array

    $stderr = number_format(_standarderror($fomresultarray[$keyvalindex]['FOMAVGSTD'], $fomresultarray[$keyvalindex]['FOMAVGCOUNT']), 2);  //call standard error function
    if ($stderr == 0.00) {
        $stderr = floatval(.01);
    }

    $tscore = number_format(_tscore($fomresultarray[$keyvalindex]['FOMAVGAVG'], $stderr, intval($resultsetarray[$key][4])), 2);  //calculates t score for given data.  If t-score is greater than 1.65, then 95% confident we will not sell more than what is on hand
    $highdemand = intval($resultsetarray[$key][12] + (1.65 * $stderr));

    if ($highdemand == 0) { //if onhand is greater than demand, then continue
        unset($resultsetarray[$key]);
        continue;
    }


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
    //calculate percent change of stockout based on t-score
    if ($tscore < -3.49) {
        $resultsetarray[$key][13] = '99.99%';
    } else {
        $searchkey = _searchForKey($tscore, $zscoretablearray, 0);
        $resultsetarray[$key][13] = (number_format((1 - $zscoretablearray[$searchkey][1]), 4) * 100) . "%"; //push tscore to end of result array
    }
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

