<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>
        <title>From Offsite Recs</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../jquery.js" type="text/javascript"></script>
        <script src="../DataTables-1.10.0/media/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../num_html.js" type="text/javascript"></script>
        <script src="../dataTables.columnFilter.js" type="text/javascript"></script>
        <script src="../tableTools2.js" type="text/javascript"></script>
        <script src="../fixedHeader.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../demo_table_jui.css" type="text/css">
        <link rel="stylesheet" href="../demo_page.css" type="text/css">
        <link rel="stylesheet" href="../jquery-ui-1.10.3.custom.css" type="text/css">
        <link rel="stylesheet" href="../jquery.dataTables_themeroller.css" type="text/css">
        <link rel="shortcut icon" type="image/ico" href="../favicon.ico" />        
        <link href="../csvtable.css" rel="stylesheet" />
        <link rel="stylesheet" href="../print.css" type="text/css" media="print">
        <link rel="stylesheet" href="../jquery-ui.css" type="text/css">
        <script src="../jquery-ui.js"></script>
        <script src="../highcharts.js"></script>
        <link href="../newstyle1.css" rel="stylesheet" type="text/css"/>
        <link href="../font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <script src="../jquery.blockUI.js"></script>
        <link rel="shortcut icon" type="image/ico" href="favicon.ico" />  
        <script src="../main.js" type="text/javascript"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
    </head>

    <body>
        <div class="main-content" style="padding-top: 30px;">
            <script src="../jquery.watermarkinput.js" type="text/javascript"></script>

<!--            <script>
                jQuery(function ($) {
                    $("#days").Watermark("Min Days OH");
                });
            </script>-->
            <script>
                $(document).ready(function () {

                });
            </script>


            <br>

            <div class="submitwrapper">
                <?php
                if (isset($_POST['amovedays'])) {
                    $a_movedays_default = $_POST['amovedays'];
                } else {
                    $a_movedays_default = 5;
                }
                if (isset($_POST['bmovedays'])) {
                    $b_movedays_default = $_POST['bmovedays'];
                } else {
                    $b_movedays_default = 5;
                }
                if (isset($_POST['cmovedays'])) {
                    $c_movedays_default = $_POST['cmovedays'];
                } else {
                    $c_movedays_default = 5;
                }
                if (isset($_POST['dmovedays'])) {
                    $d_movedays_default = $_POST['dmovedays'];
                } else {
                    $d_movedays_default = 5;
                }

                if (isset($_POST['atriggerdays'])) {
                    $a_trigger_default = $_POST['atriggerdays'];
                } else {
                    $a_trigger_default = 5;
                }
                if (isset($_POST['btriggerdays'])) {
                    $b_trigger_default = $_POST['btriggerdays'];
                } else {
                    $b_trigger_default = 5;
                }
                if (isset($_POST['ctriggerdays'])) {
                    $c_trigger_default = $_POST['ctriggerdays'];
                } else {
                    $c_trigger_default = 5;
                }
                if (isset($_POST['dtriggerdays'])) {
                    $d_trigger_default = $_POST['dtriggerdays'];
                } else {
                    $d_trigger_default = 5;
                }
                ?>
                <form method='POST'>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <select name='whse' id='whsesel' class="selectdropdown">
                                <option value='0'>Choose Whse...</option>
                                <option value='2' <?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 2) echo 'selected="selected"'; ?> >Indy</option>
                                <option value='3'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 3) echo 'selected="selected"'; ?>>Sparks</option>
                                <option value='6'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 6) echo 'selected="selected"'; ?>>Denver</option>
                                <option value='7'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 7) echo 'selected="selected"'; ?>>Dallas</option>
                                <option value='9'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 9) echo 'selected="selected"'; ?>>Jacksonville</option>
                                <option value='10'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 10) echo 'selected="selected"'; ?>>GIV</option>
                                <option value='11'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 11) echo 'selected="selected"'; ?>>NOTL</option>
                                <option value='12'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 12) echo 'selected="selected"'; ?>>Vancouver</option>
                                <option value='16'<?php if (isset($_POST['whse'])) if (intval($_POST['whse']) == 16) echo 'selected="selected"'; ?>>Calgary</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <input type='submit' name='formSubmit' value='Submit' class="submitbutton" id = 'submitrequest'/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="dashboard-stat blue-chambray">
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="amovedays" class="whitelabel">Enter Days to Move for A Items</label>
                                    <input type="text" class="smalltextbox" id="amovedays" name="amovedays" value="<?php echo $a_movedays_default ?>"/>
                                </div>
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="atriggerdays"class="whitelabel">Enter Min Days OH for A Items</label>
                                    <input type="text" class="smalltextbox" id="atriggerdays"  name="atriggerdays" value="<?php echo $a_trigger_default ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="dashboard-stat blue-chambray">
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="bmovedays"class="whitelabel">Enter Days to Move for B Items</label>
                                    <input type="text" class="smalltextbox"id="bmovedays" name="bmovedays" value="<?php echo $b_movedays_default ?>"/>
                                </div>
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="btriggerdays"class="whitelabel">Enter Min Days OH for B Items</label>
                                    <input type="text" class="smalltextbox"  name="btriggerdays" id="btriggerdays" value="<?php echo $b_trigger_default ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="dashboard-stat blue-chambray">
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="cmovedays" class="whitelabel">Enter Days to Move for C Items</label>
                                    <input type="text" class="smalltextbox"id="cmovedays" name="cmovedays"  value="<?php echo $c_movedays_default ?>"/>
                                </div>
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="ctriggerdays" class="whitelabel">Enter Min Days OH for C Items</label>
                                    <input type="text" class="smalltextbox"  name="ctriggerdays" id="ctriggerdays" value="<?php echo $c_trigger_default ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="dashboard-stat blue-chambray">
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="dmovedays" class="whitelabel">Enter Days to Move for D Items</label>
                                    <input type="text" class="smalltextbox"id="dmovedays" name="dmovedays"  value="<?php echo $d_movedays_default ?>"/>
                                </div>
                                <div class="row" style="text-align: right; padding: 5px">
                                    <label for="dtriggerdays" class="whitelabel">Enter Min Days OH for D Items</label>
                                    <input type="text" class="smalltextbox"  name="dtriggerdays" id="dtriggerdays" value="<?php echo $d_trigger_default ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
            <br>
            <div class="line-separator"></div> <br>

            <?php
            if (!empty($_POST['whse'])) {
                $var_whse = intval($_POST['whse']);
                $a_movedays = intval($_POST['amovedays']);
                $b_movedays = intval($_POST['bmovedays']);
                $c_movedays = intval($_POST['cmovedays']);
                $d_movedays = intval($_POST['dmovedays']);

                $a_trigger = intval($_POST['atriggerdays']);
                $b_trigger = intval($_POST['btriggerdays']);
                $c_trigger = intval($_POST['ctriggerdays']);
                $d_trigger = intval($_POST['dtriggerdays']);
            } else {
                die;
            }
            ?> 


            <?php
            ini_set('max_execution_time', 99999);
            require '../globalincludes/usa_asys.php';
                include_once 'connection/connection_details.php';

            //offsite ranges
            //pull in offsite ranges to exclude from location onhand pull
            $sql_locrange = $conn1->prepare("SELECT 
                                offsite_start, offsite_end
                            FROM
                                nahsi.offsite_ranges
                            WHERE
                                offsite_whse = '$var_whse'");
            $sql_locrange->execute();
            $array_locrange = $sql_locrange->fetchAll(pdo::FETCH_ASSOC);

            //build location ranges to exclude
            $locrange_exlude = ' and ';
            $locrange_include = ' and (';
            $keycount = sizeof($array_locrange) - 1;
            foreach ($array_locrange as $key => $value) {
                $loc_start = $array_locrange[$key]['offsite_start'];
                $loc_end = $array_locrange[$key]['offsite_end'];

                if ($key !== $keycount) {
                    $locrange_exlude .= " (LOLOC# not between " . "'$loc_start'" . " AND " . "'$loc_end') and ";
                    $locrange_include .= " LOLOC# between " . "'$loc_start'" . " AND " . "'$loc_end' or ";
                } else {
                    $locrange_exlude .= "  (LOLOC# not between " . "'$loc_start'" . " AND " . "'$loc_end')";
                    $locrange_include .= "  LOLOC#  between " . "'$loc_start'" . " AND " . "'$loc_end')";
                }
            }

            switch ($var_whse) {
                case "7":
                    $offsiterange = 'W5%';
                    break;
                case "6":
                    $offsiterange = '';
                    break;
                case "3":
                    $offsiterange = 'X%';
                    break;
                case "2":
                    $result = $aseriesconn->prepare("SELECT
                                                            WRSWHS           as WHSE       ,
                                                            WRSITM           as ITEM       ,
                                                            IMDESC           as DESCRIPTION,
                                                            1 as PKGU,
                                                            'A' as MCCLASS,
                                                            sum(WRSPAL)      as ALLOC      ,
                                                            'AAAAA'          as LOCATION   ,
                                                            sum(SHIP_QTY_MN) as DAILYQTY   ,
                                                            (
                                                                   SELECT
                                                                          SUM(LOONHD)
                                                                   FROM
                                                                          HSIPCORDTA.NPFLOC
                                                                   WHERE
                                                                          LOITEM     = WRSITM
                                                                          and LOWHSE = WRSWHS $locrange_exlude
                                                            )
                                                            as ONHAND,
                                                            (
                                                                   SELECT
                                                                          max(PCPPKU)
                                                                   FROM
                                                                          HSIPCORDTA.NPFCPC
                                                                   WHERE
                                                                          PCITEM = WRSITM
                                                            )
                                                            as PALLETQTY,
                                                            (
                                                                   SELECT
                                                                          SUM(LOONHD)
                                                                   FROM
                                                                          HSIPCORDTA.NPFLOC
                                                                   WHERE
                                                                          LOITEM     = WRSITM
                                                                          and LOWHSE = WRSWHS $locrange_include
                                                            )
                                                            as OFFSITEOH,
                                                            (
                                                                   SELECT
                                                                          SUM(LORMTQ)
                                                                   FROM
                                                                          HSIPCORDTA.NPFLOC
                                                                   WHERE
                                                                          LOITEM     = WRSITM
                                                                          and LOWHSE = WRSWHS $locrange_include
                                                            )
                                                            as OFFSITEMOVEQTY
                                                     FROM
                                                            HSIPCORDTA.NPFIMS
                                                            JOIN
                                                                   HSIPCORDTA.NPFWRS
                                                                   on
                                                                          IMITEM = WRSITM
                                                            JOIN
                                                                   HSIPCORDTA.NPTSLS
                                                                   on
                                                                          ITEM_NUMBER = IMITEM
                                                                          and WRSWHS  = WAREHOUSE
                                                     WHERE
                                                             WRSWHS = $var_whse 
                                                     GROUP BY WRSWHS, WRSITM, IMDESC, 'AAAAA', 1, 'A'
                                                     HAVING (
                                                                   SELECT
                                                                          SUM(LOONHD)
                                                                   FROM
                                                                          HSIPCORDTA.NPFLOC
                                                                   WHERE
                                                                          LOITEM     = WRSITM
                                                                          and LOWHSE = WRSWHS $locrange_include
                                                            ) > 0");

                    $result->execute();
                    $resultsetarray = $result->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case "9":

                    $result = $aseriesconn->prepare("SELECT DISTINCT WRSWHS as WHSE,
                                            WRSITM as ITEM,
                                            IMDESC as DESCRIPTION,
                                            LOPRTA as ALLOC,
                                            VCPKGU as PKGU,
                                            VCCLAS as MCCLASS,
                                            VCLOC# as LOCATION,
                                            SHIP_QTY_MN as DAILYQTY,
                                            (SELECT 
                                                    SUM(LOONHD)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and LOLOC# not like 'W51%' 
                                                    and LOLOC# not like 'W52%' 
                                                    and LOLOC# not like 'W53%' 
                                                    and LOLOC# not like 'W54%' 
                                                    and LOLOC# not like 'W55%'
                                                    and LOLOC# not like 'W56%'
                                                    and LOLOC# not like 'W57%') as ONHAND,
                                            (SELECT 
                                                    max(PCPPKU)
                                                FROM
                                                    HSIPCORDTA.NPFCPC
                                                WHERE
                                                    PCITEM = WRSITM) as PALLETQTY,
                                            (SELECT 
                                                    SUM(LOONHD)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and (LOLOC#  like 'W51%' 
                                                    or LOLOC#  like 'W52%' 
                                                    or LOLOC#  like 'W53%' 
                                                    or LOLOC#  like 'W54%' 
                                                    or LOLOC#  like 'W55%'
                                                    or LOLOC#  like 'W56%'
                                                    or LOLOC#  like 'W57%')) as OFFSITEOH,
                                             (SELECT 
                                                    SUM(LORMTQ)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and (LOLOC#  like 'W51%' 
                                                    or LOLOC#  like 'W52%' 
                                                    or LOLOC#  like 'W53%' 
                                                    or LOLOC#  like 'W54%' 
                                                    or LOLOC#  like 'W55%'
                                                    or LOLOC#  like 'W56%'
                                                    or LOLOC#  like 'W57%')) as OFFSITEMOVEQTY
                                        FROM
                                            HSIPCORDTA.NPFIMS,
                                            HSIPCORDTA.NPFLOC,
                                            HSIPCORDTA.NPFWRS,
                                            HSIPCORDTA.NPFMVC,
                                            HSIPCORDTA.NPTSLD
                                        WHERE 
                                            WRSITM = LOITEM and LOWHSE = WRSWHS
                                                and ITEM_NUMBER = WRSITM
                                                and WRSWHS = WAREHOUSE
                                                and VCPKGU = PACKAGE_UNIT
                                                and LOPKGU = VCPKGU
                                                and IMITEM = WRSITM
                                                and VCLOC# = CUR_LOCATION
                                                and LOLOC# = VCLOC#
                                                and VCWHSE = WRSWHS
                                                and VCITEM = WRSITM
                                                and WRSWHS = $var_whse
                                                and WRSITM IN (SELECT 
                                                    LOITEM
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE 
                                                     (LOLOC#  like 'W51%' 
                                                    or LOLOC#  like 'W52%' 
                                                    or LOLOC#  like 'W53%' 
                                                    or LOLOC#  like 'W54%' 
                                                    or LOLOC#  like 'W55%'
                                                    or LOLOC#  like 'W56%'
                                                    or LOLOC#  like 'W57%') AND LOWHSE = $var_whse)
                                       and LOLOC# not like 'W51%' 
                                                    and LOLOC# not like 'W52%' 
                                                    and LOLOC# not like 'W53%' 
                                                    and LOLOC# not like 'W54%' 
                                                    and LOLOC# not like 'W55%' 
                                                    and LOLOC# not like 'W56%'
                                                    and LOLOC# not like 'W57%'
                                        GROUP BY WRSWHS , WRSITM , IMDESC , LOPRTA, VCPKGU, VCCLAS, VCLOC#, SHIP_QTY_MN");

                    $result->execute();
                    $resultsetarray = $result->fetchAll(PDO::FETCH_ASSOC);

                    break;
                default :
                    $whsenum = '';
                    break;
            }


#Get line item info by PO#
            if (!isset($resultsetarray)) {
                $result = $aseriesconn->prepare("SELECT DISTINCT WRSWHS as WHSE,
                                            WRSITM as ITEM,
                                            IMDESC as DESCRIPTION,
                                            LOPRTA as ALLOC,
                                            VCPKGU as PKGU,
                                            VCCLAS as MCCLASS,
                                            VCLOC# as LOCATION,
                                            SHIP_QTY_MN / VCADBS as DAILYQTY,
                                            (SELECT 
                                                    SUM(LOONHD)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and LOLOC# not like '$offsiterange') as ONHAND,
                                            (SELECT 
                                                    max(PCPPKU)
                                                FROM
                                                    HSIPCORDTA.NPFCPC
                                                WHERE
                                                    PCITEM = WRSITM) as PALLETQTY,
                                            (SELECT 
                                                    SUM(LOONHD)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and LOLOC# like '$offsiterange') as OFFSITEOH,
                                             (SELECT 
                                                    SUM(LORMTQ)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and LOLOC# like '$offsiterange') as OFFSITEMOVEQTY
                                        FROM
                                            HSIPCORDTA.NPFIMS,
                                            HSIPCORDTA.NPFLOC,
                                            HSIPCORDTA.NPFWRS,
                                            HSIPCORDTA.NPFMVC,
                                            HSIPCORDTA.NPTSLD
                                        WHERE
                                            WRSITM = LOITEM and LOWHSE = WRSWHS
                                                and ITEM_NUMBER = WRSITM
                                                and WRSWHS = WAREHOUSE
                                                and VCPKGU = PACKAGE_UNIT
                                                and LOPKGU = VCPKGU
                                                and IMITEM = WRSITM
                                                and VCLOC# = CUR_LOCATION
                                                and LOLOC# = VCLOC#
                                                and VCWHSE = WRSWHS
                                                and VCITEM = WRSITM
                                                and WRSWHS = $var_whse
                                                and WRSITM IN (SELECT 
                                                    LOITEM
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOLOC# like '$offsiterange' AND LOWHSE = $var_whse)
                                        and LOLOC# not like '$offsiterange' 
                                        GROUP BY WRSWHS , WRSITM , IMDESC , LOPRTA, VCPKGU, VCCLAS, VCLOC#, SHIP_QTY_MN / VCADBS
                                        HAVING (SELECT 
                                                    SUM(LOONHD)
                                                FROM
                                                    HSIPCORDTA.NPFLOC
                                                WHERE
                                                    LOITEM = WRSITM and LOWHSE = WRSWHS
                                                    and LOLOC# like '$offsiterange') > 0    ");

                $result->execute();
                $resultsetarray = $result->fetchAll(PDO::FETCH_ASSOC);
            }
            include '../globalfunctions/slottingfunctions.php';
            include '../CUSTVIS/globalscripts.php';

            $totalpalletcount = 0;
            $displayarray = array();
            $counter = 0;
            foreach ($resultsetarray as $rsrow => $value) {


                $WHSE = $resultsetarray[$rsrow]['WHSE'];
                $ITEM = $resultsetarray[$rsrow]['ITEM'];
                $DESCRIPTION = $resultsetarray[$rsrow]['DESCRIPTION'];
                $ALLOC = intval($resultsetarray[$rsrow]['ALLOC']);
                $ONHAND = intval($resultsetarray[$rsrow]['ONHAND']) + intval($resultsetarray[$rsrow]['OFFSITEMOVEQTY']);
                $DAILYQTY = intval($resultsetarray[$rsrow]['DAILYQTY']);
                $MCCLASS = $resultsetarray[$rsrow]['MCCLASS'];
                $PALLETQTY = $resultsetarray[$rsrow]['PALLETQTY'];
                $OFFSITEOH = $resultsetarray[$rsrow]['OFFSITEOH'];
                $LOCATION = $resultsetarray[$rsrow]['LOCATION'];
                $OffsiteOH = $resultsetarray[$rsrow]['OFFSITEOH'];

                if ($WHSE == 9) {
                    $MCCLASS = _mcstandardize($MCCLASS); //standardize movement class to A-D
                }



                switch ($MCCLASS) {
                    case 'A':
                        $var_days = $a_trigger;
                        $movedays = $a_movedays;
                        break;
                    case 'B':
                        $var_days = $b_trigger;
                        $movedays = $b_movedays;
                        break;
                    case 'C':
                        $var_days = $c_trigger;
                        $movedays = $c_movedays;
                        break;
                    case 'D':
                        $var_days = $d_trigger;
                        $movedays = $d_movedays;
                        break;

                    default:
                        break;
                }

                $PKGU = $resultsetarray[$rsrow]['PKGU'];

                if ($DAILYQTY == 0) {
                    continue;
                }

                $DAYSOH = floor(($ONHAND - $ALLOC) / $DAILYQTY);

                $moveqty = $movedays * $DAILYQTY;  //calculate move qty based on movement class
                $palletcount = '-';

                if ($PALLETQTY > 0) {
                    $moveqty = min(ceil($moveqty / $PALLETQTY) * $PALLETQTY, $OFFSITEOH);  //round to nearest pallet qty or OH qty in offsite
                    $palletcount = ceil($moveqty / $PALLETQTY);
                }



                if ($DAYSOH > $var_days) {
                    continue;
                }
                if ($palletcount !== '-') {
                    $totalpalletcount += $palletcount;
                }
                $displayarray[$counter]['WHSE'] = $WHSE;
                $displayarray[$counter]['ITEM'] = $ITEM;
                $displayarray[$counter]['DESCRIPTION'] = $DESCRIPTION;
                $displayarray[$counter]['ONHAND'] = $ONHAND;
                $displayarray[$counter]['ALLOC'] = $ALLOC;
                $displayarray[$counter]['DAILYQTY'] = $DAILYQTY;
                $displayarray[$counter]['PALLETQTY'] = $PALLETQTY;
                $displayarray[$counter]['DAYSOH'] = $DAYSOH;
                $displayarray[$counter]['moveqty'] = $moveqty;
                $displayarray[$counter]['palletcount'] = $palletcount;
                $displayarray[$counter]['OffsiteOH'] = $OffsiteOH;
                $counter += 1;
            }

            foreach ($displayarray as $k => $v) {
                $sort['DAYSOH'][$k] = $v['DAYSOH'];
                $sort['DAILYQTY'][$k] = $v['DAILYQTY'];
            }


            if (isset($k)) {
                array_multisort($sort['DAYSOH'], SORT_ASC, $sort['DAILYQTY'], SORT_DESC, $displayarray);
            }
            ?>





            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat purple-plum">
                        <div class="visual">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo number_format($totalpalletcount); ?> 
                            </div>
                            <div class="desc">
                                Total Pallets to Move
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat purple-plum">
                        <div class="visual">
                            <i class="fa fa-exchange"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php echo number_format($counter); ?> 
                            </div>
                            <div class="desc">
                                Total Items
                            </div>
                        </div>
                    </div>
                </div>
            </div>









            <div class="widget widget-blue"  style="margin-top: 20px;">
                <div class="widget-title"><h3><i class="fa fa-file-text-o"></i> Move From Offsite Recommendations</h3>
                </div>
                <div class="widget-content">
                    <input type="button" onclick="tableToExcel('tblDetail', 'W3C Example Table')" value="Export to Excel">
                    <div class='table-responsive'>
                        <table class='table' id="tblDetail">
                            <thead>
                                <tr>
                                    <th style="text-transform: uppercase;">Whse</th>
                                    <th style="text-transform: uppercase;">Item</th>
                                    <th style="text-transform: uppercase;">Description</th>
                                    <th style="text-transform: uppercase;">Qty OH</th>
                                    <th style="text-transform: uppercase;">Offsite OH</th>
                                    <th style="text-transform: uppercase;">Allocations</th>
                                    <th style="text-transform: uppercase;">Daily Ship Qty</th>
                                    <th style="text-transform: uppercase;">Pallet Qty</th>
                                    <th style="text-transform: uppercase;">Days OH</th>
                                    <th style="text-transform: uppercase;">Qty To Move</th>
                                    <th style="text-transform: uppercase;">Pallet Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($displayarray as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>" . $displayarray[$key]['WHSE'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['ITEM'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['DESCRIPTION'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['ONHAND'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['OffsiteOH'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['ALLOC'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['DAILYQTY'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['PALLETQTY'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['DAYSOH'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['moveqty'] . "</td>";
                                    echo "<td>" . $displayarray[$key]['palletcount'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>



                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>


        <script>
            /*! http://mths.be/placeholder v2.0.8 by @mathias */
            ;
            (function (window, document, $) {

                // Opera Mini v7 doesn’t support placeholder although its DOM seems to indicate so
                var isOperaMini = Object.prototype.toString.call(window.operamini) == '[object OperaMini]';
                var isInputSupported = 'placeholder' in document.createElement('input') && !isOperaMini;
                var isTextareaSupported = 'placeholder' in document.createElement('textarea') && !isOperaMini;
                var prototype = $.fn;
                var valHooks = $.valHooks;
                var propHooks = $.propHooks;
                var hooks;
                var placeholder;

                if (isInputSupported && isTextareaSupported) {

                    placeholder = prototype.placeholder = function () {
                        return this;
                    };

                    placeholder.input = placeholder.textarea = true;

                } else {

                    placeholder = prototype.placeholder = function () {
                        var $this = this;
                        $this
                                .filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
                                .not('.placeholder')
                                .bind({
                                    'focus.placeholder': clearPlaceholder,
                                    'blur.placeholder': setPlaceholder
                                })
                                .data('placeholder-enabled', true)
                                .trigger('blur.placeholder');
                        return $this;
                    };

                    placeholder.input = isInputSupported;
                    placeholder.textarea = isTextareaSupported;

                    hooks = {
                        'get': function (element) {
                            var $element = $(element);

                            var $passwordInput = $element.data('placeholder-password');
                            if ($passwordInput) {
                                return $passwordInput[0].value;
                            }

                            return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
                        },
                        'set': function (element, value) {
                            var $element = $(element);

                            var $passwordInput = $element.data('placeholder-password');
                            if ($passwordInput) {
                                return $passwordInput[0].value = value;
                            }

                            if (!$element.data('placeholder-enabled')) {
                                return element.value = value;
                            }
                            if (value == '') {
                                element.value = value;
                                // Issue #56: Setting the placeholder causes problems if the element continues to have focus.
                                if (element != safeActiveElement()) {
                                    // We can't use `triggerHandler` here because of dummy text/password inputs :(
                                    setPlaceholder.call(element);
                                }
                            } else if ($element.hasClass('placeholder')) {
                                clearPlaceholder.call(element, true, value) || (element.value = value);
                            } else {
                                element.value = value;
                            }
                            // `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
                            return $element;
                        }
                    };

                    if (!isInputSupported) {
                        valHooks.input = hooks;
                        propHooks.value = hooks;
                    }
                    if (!isTextareaSupported) {
                        valHooks.textarea = hooks;
                        propHooks.value = hooks;
                    }

                    $(function () {
                        // Look for forms
                        $(document).delegate('form', 'submit.placeholder', function () {
                            // Clear the placeholder values so they don't get submitted
                            var $inputs = $('.placeholder', this).each(clearPlaceholder);
                            setTimeout(function () {
                                $inputs.each(setPlaceholder);
                            }, 10);
                        });
                    });

                    // Clear placeholder values upon page reload
                    $(window).bind('beforeunload.placeholder', function () {
                        $('.placeholder').each(function () {
                            this.value = '';
                        });
                    });

                }

                function args(elem) {
                    // Return an object of element attributes
                    var newAttrs = {};
                    var rinlinejQuery = /^jQuery\d+$/;
                    $.each(elem.attributes, function (i, attr) {
                        if (attr.specified && !rinlinejQuery.test(attr.name)) {
                            newAttrs[attr.name] = attr.value;
                        }
                    });
                    return newAttrs;
                }

                function clearPlaceholder(event, value) {
                    var input = this;
                    var $input = $(input);
                    if (input.value == $input.attr('placeholder') && $input.hasClass('placeholder')) {
                        if ($input.data('placeholder-password')) {
                            $input = $input.hide().next().show().attr('id', $input.removeAttr('id').data('placeholder-id'));
                            // If `clearPlaceholder` was called from `$.valHooks.input.set`
                            if (event === true) {
                                return $input[0].value = value;
                            }
                            $input.focus();
                        } else {
                            input.value = '';
                            $input.removeClass('placeholder');
                            input == safeActiveElement() && input.select();
                        }
                    }
                }

                function setPlaceholder() {
                    var $replacement;
                    var input = this;
                    var $input = $(input);
                    var id = this.id;
                    if (input.value == '') {
                        if (input.type == 'password') {
                            if (!$input.data('placeholder-textinput')) {
                                try {
                                    $replacement = $input.clone().attr({'type': 'text'});
                                } catch (e) {
                                    $replacement = $('<input>').attr($.extend(args(this), {'type': 'text'}));
                                }
                                $replacement
                                        .removeAttr('name')
                                        .data({
                                            'placeholder-password': $input,
                                            'placeholder-id': id
                                        })
                                        .bind('focus.placeholder', clearPlaceholder);
                                $input
                                        .data({
                                            'placeholder-textinput': $replacement,
                                            'placeholder-id': id
                                        })
                                        .before($replacement);
                            }
                            $input = $input.removeAttr('id').hide().prev().attr('id', id).show();
                            // Note: `$input[0] != input` now!
                        }
                        $input.addClass('placeholder');
                        $input[0].value = $input.attr('placeholder');
                    } else {
                        $input.removeClass('placeholder');
                    }
                }

                function safeActiveElement() {
                    // Avoid IE9 `document.activeElement` of death
                    // https://github.com/mathiasbynens/jquery-placeholder/pull/99
                    try {
                        return document.activeElement;
                    } catch (exception) {
                    }
                }

            }(this, document, jQuery))
                    ;</script>

        <script>
            $(function () {
                $('input, textarea').placeholder();
            });


            $(window).load(function () {
                debugger;

                var adays = <?php echo $a_movedays ?>;


            });

        </script>
    </body>

</html>

