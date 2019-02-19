
<?php
include_once '../connection/connection_details.php';
ini_set('max_execution_time', 99999);
ini_set('memory_limit', '-1');
$var_userid = $_POST['userid'];
$var_item = $_POST['itemcode'];
$var_lseorcse = $_POST['lseorcse'];
if ($var_lseorcse == 'pickauditclicklse') {
    $zonesql = " PDBXSZ <> 'CSE' ";
} else {
    $zonesql =  " PDBXSZ = 'CSE' ";
}

$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
if ($var_whse > 10) {
    include_once '../../globalincludes/newcanada_asys.php';
} else {
    include_once '../../globalincludes/usa_asys.php';
}

$startdate = date('Ymd', strtotime('-90 days'));

//detail data query
$result1 = $aseriesconn->prepare("SELECT PDWCS#, PDWKNO, CASE WHEN (PDSHPD<99999) THEN (date(('20' || RIGHT(PDSHPD,2)) || '-' || substr(PDSHPD,1,1) || '-' || substr(PDSHPD,2,2))) WHEN PDSHPD>99999 THEN (date(('20' || RIGHT(PDSHPD,2)) || '-' || substr(PDSHPD,1,2) || '-' || substr(PDSHPD,3,2))) END as ORDDATE, PDBXSZ, PDLOC#, PDPKGU, PDPCKS FROM A.HSIPCORDTA.NOTWPT WHERE PDWHSE = $var_whse and PDITEM = '$var_item' and $zonesql and  (CASE WHEN (PDSHPD<99999) THEN (date(('20' || RIGHT(PDSHPD,2)) || '-' || substr(PDSHPD,1,1) || '-' || substr(PDSHPD,2,2))) WHEN PDSHPD>99999 THEN (date(('20' || RIGHT(PDSHPD,2)) || '-' || substr(PDSHPD,1,2) || '-' || substr(PDSHPD,3,2))) END) >= (CURRENT DATE - 90 Days)  and PDPCKS > 0 ORDER BY PDACTY DESC, PDACTM DESC, PDSHPD DESC");
$result1->execute();
$result1array = $result1->fetchAll(pdo::FETCH_ASSOC);

//summary data query
$result2 = $aseriesconn->prepare("SELECT count(*) as PICKCOUNT FROM A.HSIPCORDTA.NOTWPT WHERE PDWHSE = $var_whse and PDITEM = '$var_item' and $zonesql and  (CASE WHEN (PDSHPD<99999) THEN (date(('20' || RIGHT(PDSHPD,2)) || '-' || substr(PDSHPD,1,1) || '-' || substr(PDSHPD,2,2))) WHEN PDSHPD>99999 THEN (date(('20' || RIGHT(PDSHPD,2)) || '-' || substr(PDSHPD,1,2) || '-' || substr(PDSHPD,3,2))) END) >= (CURRENT DATE - 90 Days)   and PDPCKS > 0 ");
$result2->execute();
$result2array = $result2->fetchAll(pdo::FETCH_ASSOC);
?>
<div class="" id="divtablecontainer_pick">
<!--start of div for summary data-->
<div class="row">
    <div class="col-lg-3"> <div class="h5"><?php echo 'Pick Count: ' . $result2array[0]['PICKCOUNT']; ?> </div> </div>
    <div class="col-lg-3"> <div class="h5"><?php echo 'Est. Yearly Picks: ' . ($result2array[0]['PICKCOUNT']) * 4; ?> </div> </div>
    <div class="col-lg-3"> <div class="h5"><?php echo 'Est. Daily Picks: ' . number_format(($result2array[0]['PICKCOUNT']) / (64.28),2); ?> </div> </div>
</div>


<!--start of div table for detail data-->

    <div  class='col-sm-12 col-md-12 col-lg-12 print-1wide'  style="float: none;">

        <div class='widget-content widget-table'  style="position: relative;">
            <div class='divtable'>
                <div class='divtableheader'>
                    <div class='divtabletitle width12_5' style="cursor: default">WCS#</div>
                    <div class='divtabletitle width12_5' style="cursor: default">W/O#</div>
                    <div class='divtabletitle width12_5' style="cursor: default">Order Date</div>
                    <div class='divtabletitle width12_5' style="cursor: default">Box Size</div>
                    <div class='divtabletitle width12_5' style="cursor: default">Pick Location</div>
                    <div class='divtabletitle width12_5' style="cursor: default">Pkgu</div>
                    <div class='divtabletitle width12_5' style="cursor: default">Ship Quantity</div>
                </div>
<?php foreach ($result1array as $key => $value) { ?>
                    <div class='divtablerow itemdetailexpand'>

                                <!--<div class='divtabledata width10 '><i class="fa fa-plus-square fa-lg " style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Toggle Detail"></i></div>-->
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['PDWCS#']); ?> </div>
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['PDWKNO']); ?> </div>
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['ORDDATE']); ?> </div>
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['PDBXSZ']); ?> </div>
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['PDLOC#']); ?> </div>
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['PDPKGU']); ?> </div>
                        <div class='divtabledata width12_5'> <?php echo trim($result1array[$key]['PDPCKS']); ?> </div>
                    </div>

<?php } ?>
            </div>
        </div>

    </div>    
</div>    

