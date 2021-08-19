<?php

ini_set('max_execution_time', 99999);
include_once '../connection/connection_details.php';
include_once '../../globalfunctions/slottingfunctions.php';

$var_userid = $_GET['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);
$whsenum = $whssqlarray[0]['slottingDB_users_PRIMDC'];

$result1 = $conn1->prepare("SELECT CONCAT(frompfr_whse, frompfr_item) as ExclKey FROM slotting.frompfrreview WHERE frompfr_whse = $whsenum");
$result1->execute();
$exclarray = $result1->fetchAll();

$USAarray = array(2, 3, 6, 7, 9, 10);  //array of US DCs
$CANarray = array(11, 12, 16);  //array of Canada DCs

if (in_array($whsenum, $USAarray)) {
    include_once '../../globalincludes/usa_asys.php';
#Query the Database into a result set - 
    $result = $aseriesconn->prepare("SELECT ' ', ITEM_NUMBER, PACKAGE_UNIT, DAYS_FRM_SLE, int(AVGD_BTW_SLE), PICK_QTY_SM, int(SLOT_QTY), case when temp.Count >= 1 then temp.Count else 0 end as newCount, (WAREHOUSE||ITEM_NUMBER) as exclkey FROM A.HSIPCORDTA.NPTSLD LEFT OUTER JOIN (Select  PDWHSE||PDITEM||PDPKGU as KEY, count(PDCOMP) as Count FROM A.HSIPCORDTA.NOTWPT WHERE PDBXSZ = 'CSE'  and PDWHSE = $whsenum GROUP BY PDWHSE||PDITEM||PDPKGU) temp on KEY = WAREHOUSE||ITEM_NUMBER||PACKAGE_UNIT WHERE WAREHOUSE = $whsenum and PACKAGE_TYPE = 'PFR' and case when temp.Count >= 1 then temp.Count else 0 end >= 20 and DAYS_FRM_SLE <= 5 ORDER BY case when temp.Count >= 1 then temp.Count else 0 end DESC");
    $result->execute();
    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);
} else {
    include_once '../../globalincludes/canada_asys.php';
#Query the Database into a result set - 
    $result = $aseriesconn->prepare("SELECT ' ', ITEM_NUMBER, PACKAGE_UNIT, DAYS_FRM_SLE, int(AVGD_BTW_SLE), PICK_QTY_SM, int(SLOT_QTY), case when temp.Count >= 1 then  temp.Count else 0 end as newCount, (WAREHOUSE||ITEM_NUMBER) as exclkey FROM A.ARCPCORDTA.NPTSLD LEFT OUTER JOIN (Select  PDWHSE||PDITEM||PDPKGU as KEY, count(PDCOMP) as Count FROM A.ARCPCORDTA.NOTWPT WHERE PDBXSZ = 'CSE'  and PDWHSE = $whsenum GROUP BY PDWHSE||PDITEM||PDPKGU) temp on KEY = WAREHOUSE||ITEM_NUMBER||PACKAGE_UNIT WHERE WAREHOUSE = $whsenum and PACKAGE_TYPE = 'PFR' and case when temp.Count >= 1 then temp.Count else 0 end >= 20 ORDER BY case when temp.Count >= 1 then temp.Count else 0 end DESC");
    $result->execute();
    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);
}
$output = array(
    "aaData" => array()
);
$row = array();

foreach ($resultsetarray as $key => $value) {
    $exclkeykindex = searchForExcl($resultsetarray[$key][8], $exclarray); //determine if item has been excluded and unset if true
    if ($exclkeykindex == TRUE) {
        unset($resultsetarray[$key]);
        continue;
    } else {
        unset($resultsetarray[$key][8]);
        unset($resultsetarray[$key][9]);
        $resultsetarray[$key] = array_values($resultsetarray[$key]);
        $row[] = $resultsetarray[$key];
    }
}



$output['aaData'] = $row;
echo json_encode($output);
//echo "<script> $.unblockUI(); </script>";
