<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>
        <title>New Item Audit</title>
        <script>
            $("#reports").addClass('active');

        </script>
        <?php
        include_once '../connections/conn_slotting.php';
        include_once 'sessioninclude.php';
        include_once 'headerincludes.php';
        include_once 'horizontalnav.php';
        include_once 'verticalnav.php';
        ?>
<!--<script src="../jquery.js" type="text/javascript"></script>-->
<!--<script type="text/javascript" src="../hashchange.js"></script>-->
<!--<script type="text/javascript" src="../tabscript.js"></script>-->
        <!--<link href="../tabstyles.css" rel="stylesheet" />-->
        <!--<link href="../csvtable.css" rel="stylesheet" />-->
        <!--<link rel="shortcut icon" type="image/ico" href="../favicon.ico" />-->  
        <!--<script src="../dataTables.js" type="text/javascript"></script>-->
        <!--<script src="../dataTables.columnFilter.js" type="text/javascript"></script>-->
        <!--<script src="../TableTools.min.js" type="text/javascript"></script>-->
        <!--<link rel="stylesheet" href="../demo_table_jui.css" type="text/css">-->
        <!--<link rel="stylesheet" href="../demo_page.css" type="text/css">-->
        <link rel="stylesheet" href="../jquery-ui.css" type="text/css">
        <!--<link rel="stylesheet" href="../jquery.dataTables_themeroller.css" type="text/css">-->
        <!--<script src="../jquery-ui.js"></script>-->

    </head>

    <body style="background-color: #FFFFFF;">
        <!--Main Content-->

        <div class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
            <h2 style="padding-bottom: 0px;">New Item Setup Audit</h2>

            <div class="submitwrapper">
                <?php
                $indy = $sparks = $denver = $dallas = $jax = $NOTL = $vanc = $calg = '';
                $set_date = "'" . date("Y-m-d", time() - 86400) . "'";
                if (isset($_GET['whse']) && !empty($_GET['whse'])) {
                    $whssel = $_GET['whse'];
                    $set_date = "'" . $_GET['datepicker'] . "'";


                    switch ($whssel) {
                        case 2:
                            $indy = "selected";
                            break;
                        case 3:
                            $sparks = "selected";
                            break;
                        case 6:
                            $denver = "selected";
                            break;
                        case 7:
                            $dallas = "selected";
                            break;
                        case 9:
                            $jax = "selected";
                            break;
                        case 11:
                            $NOTL = "selected";
                            break;
                        case 12:
                            $vanc = "selected";
                            break;
                        case 16:
                            $calg = "selected";
                            break;
                    }
                }

                echo "<form method='GET'>

            <select name='whse' class='selectstyle' style='min-width: 200px;'>
                <option value='0'>Choose Whse...</option>
                <option value='2' $indy>Indy</option>
                <option value='3'$sparks>Sparks</option>
                <option value='6'$denver>Denver</option>
                <option value='7'$dallas>Dallas</option>
                <option value='9'$jax>Jacksonville</option>
                <option value='11'$NOTL>NOTL</option>
                <option value='12'$vanc>Vancouver</option>
                <option value='16'$calg>Calgary</option>
            </select>";
                ?>

                <input id="datepicker" type="text" name="datepicker" class="selectstyle"style="cursor: default">
                <script>
                    /*
                     * jQuery UI Datepicker: Parse and Format Dates
                     * http://salman-w.blogspot.com/2013/01/jquery-ui-datepicker-examples.html
                     */
                    $(function () {
                        $("#datepicker").datepicker({
                            dateFormat: "yy-mm-dd"
                        }).datepicker('setDate',<?php echo $set_date ?>);
                    });
                </script>
                <input type="submit" name="formSubmit" value="Submit" />
                </form>    
                <?php
                if (isset($_GET['formSubmit'])) {
                    $var_whse = intval($_GET['whse']);
                    $var_datepick = $_GET['datepicker'];
                } else {
                    die;
                }
                ?> 



                <br>
                <div class="line-separator"></div> <br>


                <div id="tablecontainer" class="">
                    <table id="ptbtable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                        <thead>
                            <tr>
                                <th style='min-width: 75px;'>Whse</th>
                                <th style='min-width: 75px;'>Item</th>
                                <th style='min-width: 75px;'>Pred Daily Dmd</th>
                                <th style='min-width: 75px;'>Ea. Length</th>
                                <th style='min-width: 75px;'>Ea. Height</th>
                                <th style='min-width: 75px;'>Ea. Width</th>
                                <th style='min-width: 75px;'>Ea. Stack Qty</th>
                                <th style='min-width: 75px;'>OK in Tote</th>
                                <th style='min-width: 75px;'>OK in Shelf</th>
                                <th style='min-width: 75px;'>OK in Flow</th>
                                <th style='min-width: 75px;'>OK to Rotate</th>
                                <th style='min-width: 75px;'>PFR at Corp</th>
                                <th style='min-width: 75px;'>PFR at DC</th>
                                <th style='min-width: 75px;'>Orientation</th>
                                <th style='min-width: 75px;'>Liquid</th>
                                <th style='min-width: 75px;'>Date</th>
                                <th style='min-width: 75px;'>Assigned Loc.</th>
                                <th style='min-width: 75px;'>Assigned Grid</th>
                                <th style='min-width: 75px;'>Rec. Grid</th>
                                <th style='min-width: 75px;'>Assigned Tier</th>
                                <th style='min-width: 75px;'>Rec. Tier</th>
                                <th style='min-width: 75px;'>Assigned Max</th>
                                <th style='min-width: 75px;'>Actual TF</th>
                                <th style='min-width: 75px;'>Rec. Slot Qty</th>
                                <th style='min-width: 75px;'>Assigned Min</th>
                                <th style='min-width: 75px;'>Audit Checks</th>
                            </tr>
                        </thead>



                        <tbody>
                            <?php
                            ini_set('max_execution_time', 99999);
                            include_once("../globalfunctions/newitem.php");

                            $USAarray = array(2, 3, 6, 7, 9);
                            $CANarray = array(11, 12, 16);

                            if (in_array($var_whse, $USAarray)) {
                                //START of USA Audit
                                $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
                                $pdo_username = "BHUD01";
                                $pdo_password = "tucker1234";
                                $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

                                #Query the Database into a result set - 
                                $result = $aseriesconn->prepare("SELECT DISTINCT PCITEM, PCELEN, PCEHEI, PCEWID, PCESTA, PCTOTE, PCSHLF, PCFLOR, PCEROT, PCORSH, PCLIQU, date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2)), IDEM13, PCCPKU, PCPFRC, PCPFRA, sum(EATRNQ) FROM A.HSIPCORDTA.NPFERA, A.HSIPCORDTA.NPFCPC, A.E3TSCHEIN.E3ITEM WHERE IITEM = EAITEM and IWHSE = EAWHSE and EAITEM = PCITEM AND EATLOC = 'NEW' and EASEQ3 = 1 and EASTAT = 'C' AND PCWHSE = 0 and (date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2))) = '" . $var_datepick . "' and EAWHSE = '" . $var_whse . "' and (PCELEN * PCEHEI * PCEWID) > 0 GROUP BY PCITEM, PCELEN, PCEHEI, PCEWID, PCESTA, PCTOTE, PCSHLF, PCFLOR, PCEROT, PCORSH, PCLIQU, date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2)), IDEM13, PCCPKU, PCPFRC, PCPFRA");
                                $result->execute();
                                $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

                                foreach ($resultsetarray as $rsrow => $value) {

                                    $var_auditcount = $var_gridheight = $var_griddepth = $var_gridwidth = $var_LOMAXC = $var_LOMINC = $var_tranqty = 0;
                                    $var_PCITEM = $var_PCELEN = $var_PCEHEI = $var_PCEWID = $var_PCESTA = $var_PCTOTE = $var_PCSHLF = $var_PCFLOR = $var_PCEROT = $var_PCORSH = $var_PCLIQU = $var_DCPCITEM = $var_DCPCELEN = $var_DCPCEHEI = $var_DCPCEWID = $var_DCPCESTA = $var_DCPCTOTE = $var_DCPCSHLF = $var_DCPCFLOR = $var_DCPCEROT = $var_DCPCORSH = $var_DCPCLIQU = $var_Date = $var_IDEM13 = $var_VCLOC = $var_VCFIXA = $var_VCGRD5 = $var_VCCTRF = $var_VCMAXC = $var_PCCPKU = $var_PCEPKU = $var_DCPCPFRA = $var_PCPFRA = $var_DCPCPFRC = $var_PCPFRC = '-';
                                    $var_LMLOC = $var_LMFIXA = $var_grid5 = '';

                                    $var_PCITEM = $resultsetarray[$rsrow][0];
                                    $var_PCELEN = $resultsetarray[$rsrow][1];
                                    $var_PCEHEI = $resultsetarray[$rsrow][2];
                                    $var_PCEWID = $resultsetarray[$rsrow][3];
                                    $var_PCESTA = $resultsetarray[$rsrow][4];
                                    $var_PCTOTE = $resultsetarray[$rsrow][5];
                                    $var_PCSHLF = $resultsetarray[$rsrow][6];
                                    $var_PCFLOR = $resultsetarray[$rsrow][7];
                                    $var_PCEROT = $resultsetarray[$rsrow][8];
                                    $var_PCORSH = $resultsetarray[$rsrow][9];
                                    $var_PCLIQU = $resultsetarray[$rsrow][10];
                                    $var_Date = $resultsetarray[$rsrow][11];
                                    $var_IDEM13 = $resultsetarray[$rsrow][12];
                                    $var_PCCPKG = $resultsetarray[$rsrow][13];
                                    $var_PCPFRC = $resultsetarray[$rsrow][14];
                                    $var_PCPFRA = $resultsetarray[$rsrow][15];
                                    $var_tranqty = $resultsetarray[$rsrow][16];

                                    /* Pull DC specific Data to determine if setting is different */
                                    $DCresult = $aseriesconn->prepare("SELECT DISTINCT PCITEM, PCELEN, PCEHEI, PCEWID, PCESTA, PCTOTE, PCSHLF, PCFLOR, PCEROT, PCORSH, PCLIQU, date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2)), PCPFRC, PCPFRA FROM A.HSIPCORDTA.NPFERA, A.HSIPCORDTA.NPFCPC, A.E3TSCHEIN.E3ITEM WHERE IITEM = EAITEM and IWHSE = EAWHSE and EAITEM = PCITEM AND EATLOC = 'NEW' and EASEQ3 = 1 and EASTAT = 'C' AND PCWHSE = '" . $var_whse . "' and (char('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2))) = '" . $var_datepick . "' and EAWHSE = '" . $var_whse . "' and PCITEM = '" . $var_PCITEM . "'");
                                    $DCresult->execute();
                                    $DCresultsetarray = $DCresult->fetchAll(PDO::FETCH_NUM);

                                    foreach ($DCresultsetarray as $DCrsrow => $DCvalue) {
                                        $var_DCPCITEM = $DCresultsetarray[$DCrsrow][0];
                                        $var_DCPCELEN = $DCresultsetarray[$DCrsrow][1];
                                        $var_DCPCEHEI = $DCresultsetarray[$DCrsrow][2];
                                        $var_DCPCEWID = $DCresultsetarray[$DCrsrow][3];
                                        $var_DCPCESTA = $DCresultsetarray[$DCrsrow][4];
                                        $var_DCPCTOTE = $DCresultsetarray[$DCrsrow][5];
                                        $var_DCPCSHLF = $DCresultsetarray[$DCrsrow][6];
                                        $var_DCPCFLOR = $DCresultsetarray[$DCrsrow][7];
                                        $var_DCPCEROT = $DCresultsetarray[$DCrsrow][8];
                                        $var_DCPCORSH = $DCresultsetarray[$DCrsrow][9];
                                        $var_DCPCLIQU = $DCresultsetarray[$DCrsrow][10];
                                        $var_DCPCPFRC = $DCresultsetarray[$DCrsrow][12];
                                        $var_DCPCPFRA = $DCresultsetarray[$DCrsrow][13];
                                    }

                                    $var_DCPCELENin = $var_PCELEN / 2.54;
                                    $var_DCPCEHEIin = $var_PCEHEI / 2.54;
                                    $var_DCPCEWIDin = $var_PCEWID / 2.54;

                                    /* Pull DC slot info */
                                    $MVCresult = $aseriesconn->prepare("SELECT LMLOC#, LMFIXA, case when LMDEEP <> 24 then LMGRD5||'sub'||LMDEEP else LMGRD5 end, LMHIGH,LMDEEP, LMWIDE, LOMAXC, LOMINC, LMTIER FROM A.HSIPCORDTA.NPFLSM, A.HSIPCORDTA.NPFLOC WHERE  LMLOC# = LOLOC# and LMWHSE = LOWHSE and LMWHSE = '" . $var_whse . "' and LMITEM = '" . $var_PCITEM . "' AND LMTIER like 'L%'");
                                    $MVCresult->execute();
                                    $MVCresultsetarray = $MVCresult->fetchAll(PDO::FETCH_NUM);

                                    foreach ($MVCresultsetarray as $MVCrsrow => $MVCvalue) {
                                        $var_LMLOC = $MVCresultsetarray[$MVCrsrow][0];
                                        $var_LMFIXA = $MVCresultsetarray[$MVCrsrow][1];
                                        $var_grid5 = $MVCresultsetarray[$MVCrsrow][2];
                                        $var_gridheight = $MVCresultsetarray[$MVCrsrow][3];
                                        $var_griddepth = $MVCresultsetarray[$MVCrsrow][4];
                                        $var_gridwidth = $MVCresultsetarray[$MVCrsrow][5];
                                        $var_LOMAXC = $MVCresultsetarray[$MVCrsrow][6];
                                        $var_LOMINC = $MVCresultsetarray[$MVCrsrow][7];
                                        $var_ASSTIER = $MVCresultsetarray[$MVCrsrow][8];
                                    }
                                    if ($var_gridheight == 0 || $var_LOMAXC == 0 || $var_LMLOC == '') {
                                        continue;
                                    }

                                    if ($var_ASSTIER !== 'L04' && $var_ASSTIER !== 'L06') {
                                        continue;
                                    }
                                    //Find true fit of TSM assigned grid5
                                    $var_truefitarray = _truefitgrid($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_DCPCEHEIin, $var_DCPCELENin, $var_DCPCEWIDin);
                                    $var_maxtruefit = $var_truefitarray[1];

                                    $var_DailyDem = ($var_IDEM13 / 28);
                                    $var_2weekdmd = ceil($var_DailyDem * 10);

                                    //Call slotqty function to determine how many should slot in primary
                                    $var_EachSLOTQTY = _slotqty($var_PCCPKG, $var_2weekdmd, $var_tranqty, $var_DailyDem);

                                    //Call newmc function to determine starting movement class
                                    $var_preditemMC = _newmc($var_DailyDem);

                                    //Call predtier function to determine slotting tier
                                    $var_predtier = _predtier($var_preditemMC, $var_whse);

                                    //Call okgrids function to determine okgrids
                                    $okgrids = _okgrids($var_preditemMC, $var_whse);


                                    $emptygrids = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.HSIPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) AND (LMITEM = '') and (LMTIER in ('" . $var_predtier . "')) and (LMFIXA in ('" . $okgrids . "')) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end not in ('06S15Sub22', '11S07Sub20') ORDER BY LMVOL9 ASC");
                                    $emptygrids->execute();
                                    $emptygridsarray = $emptygrids->fetchAll(PDO::FETCH_NUM);

                                    $var_PCEHEIin = $var_PCEHEI / 2.54;
                                    $var_PCELENin = $var_PCELEN / 2.54;
                                    $var_PCEWIDin = $var_PCEWID / 2.54;

                                    for ($i = 0; $i < count($emptygridsarray); $i++) {

                                        $var_availgrid5 = $emptygridsarray[$i][0];
                                        $var_gridheight = $emptygridsarray[$i][1];
                                        $var_griddepth = $emptygridsarray[$i][2];
                                        $var_gridwidth = $emptygridsarray[$i][3];

                                        //Call truefit function and return grid5 and max true fit if possible
                                        $var_truefitarray = _truefit($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin, $var_EachSLOTQTY, 9999);
                                        if (isset($var_truefitarray)) {
                                            break;
                                        }
                                    }
                                    $var_EachRecSlot = $var_truefitarray[0];
                                    $var_shouldslotqty = $var_truefitarray[1];


                                    if ($var_maxtruefit == 0) {
                                        $var_maxtruefit = .001;
                                    }
                                    $var_intMaxTF = intval($var_maxtruefit);
                                    $var_DailyDemFormatted = number_format($var_DailyDem, 2);
                                    echo "<tr><td>$var_whse</td>";
                                    echo "<td>$var_PCITEM</td>";
                                    echo "<td>$var_DailyDemFormatted</td>";

                                    if (($var_DCPCELEN != $var_PCELEN) && ($var_DCPCELEN != '-')) {
                                        if ($var_DCPCELEN == ' ' || $var_DCPCELEN == 0) {
                                            echo "<td>$var_PCELEN</td>";
                                        } else {
                                            echo "<td title='Length entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCELEN</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCELEN</td>";
                                    }

                                    if (($var_DCPCEHEI != $var_PCEHEI) && ($var_DCPCEHEI != '-')) {
                                        if ($var_DCPCEHEI == ' ' || $var_DCPCEHEI == 0) {
                                            echo "<td>$var_PCEHEI</td>";
                                        } else {
                                            echo "<td title='Height entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCEHEI</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCEHEI</td>";
                                    }

                                    if (($var_DCPCEWID != $var_PCEWID) && ($var_DCPCEWID != '-')) {
                                        if ($var_DCPCEWID == ' ' || $var_DCPCEWID == 0) {
                                            echo "<td>$var_PCEWID</td>";
                                        } else {
                                            echo "<td title='Width entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCEWID</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCEWID</td>";
                                    }


                                    if (($var_DCPCESTA != $var_PCESTA) && ($var_DCPCESTA != '-')) {
                                        if ($var_DCPCESTA == ' ' || $var_DCPCESTA == 0) {
                                            echo "<td>$var_PCESTA</td>";
                                        } else {
                                            echo "<td title='Stackable setting entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCESTA</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCESTA</td>";
                                    }


                                    if (($var_DCPCTOTE != $var_PCTOTE) && ($var_DCPCTOTE != '-')) {
                                        if ($var_DCPCTOTE == ' ') {
                                            echo "<td>$var_PCTOTE</td>";
                                        } else {
                                            echo "<td title='OK in tote setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCTOTE</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } elseif ($var_PCTOTE == 'N' || $var_DCPCTOTE == 'N') {
                                        echo "<td title='Either the corporate or local setting is N.' style='background-color:#ff00004d'>$var_PCTOTE</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCTOTE</td>";
                                    }


                                    if (($var_DCPCSHLF != $var_PCSHLF) && ($var_DCPCSHLF != '-')) {
                                        if ($var_DCPCSHLF == ' ') {
                                            echo "<td>$var_PCSHLF</td>";
                                        } else {
                                            echo "<td title='OK in shelf setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCSHLF</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } elseif ($var_DCPCSHLF == 'N' || $var_PCSHLF == 'N') {
                                        echo "<td title='Either the corporate or local setting is N.' style='background-color:#ff00004d'>$var_PCSHLF</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCSHLF</td>";
                                    }


                                    if (($var_DCPCFLOR != $var_PCFLOR) && ($var_DCPCFLOR != '-')) {
                                        if ($var_DCPCFLOR == ' ') {
                                            echo "<td>$var_PCFLOR</td>";
                                        } else {
                                            echo "<td title='OK in flow setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCFLOR</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } elseif ($var_PCCPKG > 0 && $var_PCFLOR == 'N') {
                                        echo "<td title='There is a case pkgu available.  Set OK in flow to Y.' style='background-color:#ff00004d'>$var_PCFLOR</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCFLOR</td>";
                                    }

                                    if (($var_DCPCEROT != $var_PCEROT) && ($var_DCPCEROT != '-')) {
                                        if ($var_DCPCEROT == ' ') {
                                            echo "<td>$var_PCEROT</td>";
                                        } else {
                                            echo "<td title='Rotate setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCEROT</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCEROT</td>";
                                    }


                                    if ($var_PCCPKG > 0 && $var_PCPFRC <> 'P') {
                                        echo "<td title='There is a case package available.  Set corporate PFR to P' style='background-color:#ff00004d'>$var_PCPFRC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCPFRC</td>";
                                    }


                                    if (($var_PCCPKG > 0 || $var_PCPFRC == 'P') && $var_DCPCPFRA <> 'Y') {
                                        echo "<td title='Corporate PFR is set to P.  Set DC setting to Y.' style='background-color:#ff00004d'>$var_DCPCPFRA</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_DCPCPFRA</td>";
                                    }

                                    if (($var_DCPCORSH != $var_PCORSH) && ($var_DCPCORSH != '-')) {
                                        if ($var_DCPCORSH == '   ') {
                                            echo "<td>$var_PCORSH</td>";
                                        } else {
                                            echo "<td style='background-color:#ff00004d'>$var_DCPCORSH</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCORSH</td>";
                                    }

                                    if (($var_DCPCLIQU != $var_PCLIQU) && ($var_DCPCLIQU != '-')) {
                                        if ($var_DCPCLIQU == '  ') {
                                            echo "<td>$var_PCLIQU</td>";
                                        } else {
                                            echo "<td title='Liquid setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCLIQU</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCLIQU</td>";
                                    }

                                    echo "<td>$var_Date</td>";
                                    echo "<td>$var_LMLOC</td>";
                                    echo "<td>$var_grid5</td>";
                                    echo "<td>$var_EachRecSlot</td>";

                                    echo "<td>$var_ASSTIER</td>";

                                    if ($var_ASSTIER <> $var_predtier) {
                                        echo "<td title='Predicted demand does not warrant a $var_ASSTIER tier.  Please place in a $var_predtier tier.' style='background-color:#ff00004d'>$var_predtier</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_predtier</td>";
                                    }
                                    if ($var_LOMAXC / $var_maxtruefit > 1) {
                                        echo "<td title='The set max of $var_LOMAXC is set above the true fit of $var_maxtruefit. Check item dimensions or change location max.' style='background-color:#ff00004d' >$var_LOMAXC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } elseif ($var_LOMAXC / $var_maxtruefit <= .95) {
                                        echo "<td title='The set max of $var_LOMAXC is set below the true fit of $var_maxtruefit.' style='background-color:#ff00004d'>$var_LOMAXC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_LOMAXC</td>";
                                    }

                                    echo "<td>$var_intMaxTF</td>";
                                    echo "<td>$var_EachSLOTQTY</td>";
                                    $var_recmin = round(($var_LOMAXC * .25), 0);
                                    if ($var_LOMINC / $var_recmin > 1.25 || $var_LOMINC / $var_recmin <= .80) {
                                        echo "<td title = 'Min should be $var_recmin.' style='background-color:#ff00004d'>$var_LOMINC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_LOMINC</td>";
                                    }
                                    echo "<td>$var_auditcount</td>";
                                }
                                echo "</tbody>";
                            } else {
                                //START of Canada Audit
                                $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
                                $pdo_username = "BHUDS1";
                                $pdo_password = "tucker1234";
                                $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

                                #Query the Database into a result set - 
                                $result = $aseriesconn->prepare("SELECT DISTINCT PCITEM, PCELEN, PCEHEI, PCEWID, PCESTA, PCTOTE, PCSHLF, PCFLOR, PCEROT, PCORSH, PCLIQU, date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2)), IDEM13, PCCPKU, PCPFRC, PCPFRA, sum(EATRNQ) FROM A.ARCPCORDTA.NPFERA, A.ARCPCORDTA.NPFCPC, A.E3TARC.E3ITEM WHERE IITEM = EAITEM and IWHSE = EAWHSE and EAITEM = PCITEM AND EATLOC = 'NEW' and EASEQ3 = 1 and EASTAT = 'C' AND PCWHSE = 0 and (date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2))) = '" . $var_datepick . "' and EAWHSE = '" . $var_whse . "' and (PCELEN * PCEHEI * PCEWID) > 0 GROUP BY PCITEM, PCELEN, PCEHEI, PCEWID, PCESTA, PCTOTE, PCSHLF, PCFLOR, PCEROT, PCORSH, PCLIQU, date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2)), IDEM13, PCCPKU, PCPFRC, PCPFRA");
                                $result->execute();
                                $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

                                foreach ($resultsetarray as $rsrow => $value) {

                                    $var_auditcount = $var_gridheight = $var_griddepth = $var_gridwidth = $var_LOMAXC = $var_LOMINC = $var_tranqty = 0;
                                    $var_PCITEM = $var_PCELEN = $var_PCEHEI = $var_PCEWID = $var_PCESTA = $var_PCTOTE = $var_PCSHLF = $var_PCFLOR = $var_PCEROT = $var_PCORSH = $var_PCLIQU = $var_DCPCITEM = $var_DCPCELEN = $var_DCPCEHEI = $var_DCPCEWID = $var_DCPCESTA = $var_DCPCTOTE = $var_DCPCSHLF = $var_DCPCFLOR = $var_DCPCEROT = $var_DCPCORSH = $var_DCPCLIQU = $var_Date = $var_IDEM13 = $var_VCLOC = $var_VCFIXA = $var_VCGRD5 = $var_VCCTRF = $var_VCMAXC = $var_PCCPKU = $var_PCEPKU = $var_DCPCPFRA = $var_PCPFRA = $var_DCPCPFRC = $var_PCPFRC = '-';
                                    $var_LMLOC = $var_LMFIXA = $var_grid5 = '';

                                    $var_PCITEM = $resultsetarray[$rsrow][0];
                                    $var_PCELEN = $resultsetarray[$rsrow][1];
                                    $var_PCEHEI = $resultsetarray[$rsrow][2];
                                    $var_PCEWID = $resultsetarray[$rsrow][3];
                                    $var_PCESTA = $resultsetarray[$rsrow][4];
                                    $var_PCTOTE = $resultsetarray[$rsrow][5];
                                    $var_PCSHLF = $resultsetarray[$rsrow][6];
                                    $var_PCFLOR = $resultsetarray[$rsrow][7];
                                    $var_PCEROT = $resultsetarray[$rsrow][8];
                                    $var_PCORSH = $resultsetarray[$rsrow][9];
                                    $var_PCLIQU = $resultsetarray[$rsrow][10];
                                    $var_Date = $resultsetarray[$rsrow][11];
                                    $var_IDEM13 = $resultsetarray[$rsrow][12];
                                    $var_PCCPKG = $resultsetarray[$rsrow][13];
                                    $var_PCPFRC = $resultsetarray[$rsrow][14];
                                    $var_PCPFRA = $resultsetarray[$rsrow][15];
                                    $var_tranqty = $resultsetarray[$rsrow][16];

                                    /* Pull DC specific Data to determine if setting is different */
                                    $DCresult = $aseriesconn->prepare("SELECT DISTINCT PCITEM, PCELEN, PCEHEI, PCEWID, PCESTA, PCTOTE, PCSHLF, PCFLOR, PCEROT, PCORSH, PCLIQU, date('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2)), PCPFRC, PCPFRA FROM A.ARCPCORDTA.NPFERA, A.ARCPCORDTA.NPFCPC, A.E3TARC.E3ITEM WHERE IITEM = EAITEM and IWHSE = EAWHSE and EAITEM = PCITEM AND EATLOC = 'NEW' and EASEQ3 = 1 and EASTAT = 'C' AND PCWHSE = '" . $var_whse . "' and (char('20' || substr(EATRND,2,2) || '-' || substr(EATRND,4,2) || '-' || substr(EATRND,6,2))) = '" . $var_datepick . "' and EAWHSE = '" . $var_whse . "' and PCITEM = '" . $var_PCITEM . "'");
                                    $DCresult->execute();
                                    $DCresultsetarray = $DCresult->fetchAll(PDO::FETCH_NUM);

                                    foreach ($DCresultsetarray as $DCrsrow => $DCvalue) {
                                        $var_DCPCITEM = $DCresultsetarray[$DCrsrow][0];
                                        $var_DCPCELEN = $DCresultsetarray[$DCrsrow][1];
                                        $var_DCPCEHEI = $DCresultsetarray[$DCrsrow][2];
                                        $var_DCPCEWID = $DCresultsetarray[$DCrsrow][3];
                                        $var_DCPCESTA = $DCresultsetarray[$DCrsrow][4];
                                        $var_DCPCTOTE = $DCresultsetarray[$DCrsrow][5];
                                        $var_DCPCSHLF = $DCresultsetarray[$DCrsrow][6];
                                        $var_DCPCFLOR = $DCresultsetarray[$DCrsrow][7];
                                        $var_DCPCEROT = $DCresultsetarray[$DCrsrow][8];
                                        $var_DCPCORSH = $DCresultsetarray[$DCrsrow][9];
                                        $var_DCPCLIQU = $DCresultsetarray[$DCrsrow][10];
                                        $var_DCPCPFRC = $DCresultsetarray[$DCrsrow][12];
                                        $var_DCPCPFRA = $DCresultsetarray[$DCrsrow][13];
                                    }

                                    $var_DCPCELENin = $var_PCELEN / 2.54;
                                    $var_DCPCEHEIin = $var_PCEHEI / 2.54;
                                    $var_DCPCEWIDin = $var_PCEWID / 2.54;

                                    /* Pull DC slot info */
                                    $MVCresult = $aseriesconn->prepare("SELECT LMLOC#, LMFIXA, case when LMDEEP <> 24 then LMGRD5||'sub'||LMDEEP else LMGRD5 end, LMHIGH,LMDEEP, LMWIDE, LOMAXC, LOMINC, LMTIER FROM A.ARCPCORDTA.NPFLSM, A.ARCPCORDTA.NPFLOC WHERE  LMLOC# = LOLOC# and LMWHSE = LOWHSE and LMWHSE = '" . $var_whse . "' and LMITEM = '" . $var_PCITEM . "' AND LMTIER like 'L%'");
                                    $MVCresult->execute();
                                    $MVCresultsetarray = $MVCresult->fetchAll(PDO::FETCH_NUM);

                                    foreach ($MVCresultsetarray as $MVCrsrow => $MVCvalue) {
                                        $var_LMLOC = $MVCresultsetarray[$MVCrsrow][0];
                                        $var_LMFIXA = $MVCresultsetarray[$MVCrsrow][1];
                                        $var_grid5 = $MVCresultsetarray[$MVCrsrow][2];
                                        $var_gridheight = $MVCresultsetarray[$MVCrsrow][3];
                                        $var_griddepth = $MVCresultsetarray[$MVCrsrow][4];
                                        $var_gridwidth = $MVCresultsetarray[$MVCrsrow][5];
                                        $var_LOMAXC = $MVCresultsetarray[$MVCrsrow][6];
                                        $var_LOMINC = $MVCresultsetarray[$MVCrsrow][7];
                                        $var_ASSTIER = $MVCresultsetarray[$MVCrsrow][8];
                                    }
                                    if ($var_gridheight == 0 || $var_LOMAXC == 0 || $var_LMLOC == '') {
                                        continue;
                                    }

                                    if ($var_ASSTIER !== 'L04' && $var_ASSTIER !== 'L06') {
                                        continue;
                                    }
                                    //Find true fit of TSM assigned grid5
                                    $var_truefitarray = _truefitgrid($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_DCPCEHEIin, $var_DCPCELENin, $var_DCPCEWIDin);
                                    $var_maxtruefit = $var_truefitarray[1];

                                    $var_DailyDem = ($var_IDEM13 / 28);
                                    $var_2weekdmd = ceil($var_DailyDem * 10);

                                    //Call slotqty function to determine how many should slot in primary
                                    $var_EachSLOTQTY = _slotqty($var_PCCPKG, $var_2weekdmd, $var_tranqty, $var_DailyDem);

                                    //Call newmc function to determine starting movement class
                                    $var_preditemMC = _newmc($var_DailyDem);

                                    //Call predtier function to determine slotting tier
                                    $var_predtier = _predtier($var_preditemMC, $var_whse);

                                    //Call okgrids function to determine okgrids
                                    $okgrids = _okgrids($var_preditemMC, $var_whse);


                                    $emptygrids = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.ARCPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) AND (LMITEM = '') and (LMTIER in ('" . $var_predtier . "')) and (LMFIXA in ('" . $okgrids . "')) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end not in ('06S15Sub22', '11S07Sub20') ORDER BY LMVOL9 ASC");
                                    $emptygrids->execute();
                                    $emptygridsarray = $emptygrids->fetchAll(PDO::FETCH_NUM);

                                    $var_PCEHEIin = $var_PCEHEI / 2.54;
                                    $var_PCELENin = $var_PCELEN / 2.54;
                                    $var_PCEWIDin = $var_PCEWID / 2.54;

                                    for ($i = 0; $i < count($emptygridsarray); $i++) {

                                        $var_availgrid5 = $emptygridsarray[$i][0];
                                        $var_gridheight = $emptygridsarray[$i][1];
                                        $var_griddepth = $emptygridsarray[$i][2];
                                        $var_gridwidth = $emptygridsarray[$i][3];

                                        //Call truefit function and return grid5 and max true fit if possible
                                        $var_truefitarray = _truefit($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin, $var_EachSLOTQTY, 9999);
                                        if (isset($var_truefitarray)) {
                                            break;
                                        }
                                    }
                                    $var_EachRecSlot = $var_truefitarray[0];
                                    $var_shouldslotqty = $var_truefitarray[1];


                                    if ($var_maxtruefit == 0) {
                                        $var_maxtruefit = .001;
                                    }
                                    $var_intMaxTF = intval($var_maxtruefit);
                                    $var_DailyDemFormatted = number_format($var_DailyDem, 2);
                                    echo "<tr><td>$var_whse</td>";
                                    echo "<td>$var_PCITEM</td>";
                                    echo "<td>$var_DailyDemFormatted</td>";

                                    if (($var_DCPCELEN != $var_PCELEN) && ($var_DCPCELEN != '-')) {
                                        if ($var_DCPCELEN == ' ' || $var_DCPCELEN == 0) {
                                            echo "<td>$var_PCELEN</td>";
                                        } else {
                                            echo "<td title='Length entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCELEN</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCELEN</td>";
                                    }

                                    if (($var_DCPCEHEI != $var_PCEHEI) && ($var_DCPCEHEI != '-')) {
                                        if ($var_DCPCEHEI == ' ' || $var_DCPCEHEI == 0) {
                                            echo "<td>$var_PCEHEI</td>";
                                        } else {
                                            echo "<td title='Height entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCEHEI</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCEHEI</td>";
                                    }

                                    if (($var_DCPCEWID != $var_PCEWID) && ($var_DCPCEWID != '-')) {
                                        if ($var_DCPCEWID == ' ' || $var_DCPCEWID == 0) {
                                            echo "<td>$var_PCEWID</td>";
                                        } else {
                                            echo "<td title='Width entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCEWID</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCEWID</td>";
                                    }


                                    if (($var_DCPCESTA != $var_PCESTA) && ($var_DCPCESTA != '-')) {
                                        if ($var_DCPCESTA == ' ' || $var_DCPCESTA == 0) {
                                            echo "<td>$var_PCESTA</td>";
                                        } else {
                                            echo "<td title='Stackable setting entered is different then corporate.' style='background-color:#ff00004d'>$var_DCPCESTA</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCESTA</td>";
                                    }


                                    if (($var_DCPCTOTE != $var_PCTOTE) && ($var_DCPCTOTE != '-')) {
                                        if ($var_DCPCTOTE == ' ') {
                                            echo "<td>$var_PCTOTE</td>";
                                        } else {
                                            echo "<td title='OK in tote setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCTOTE</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } elseif ($var_PCTOTE == 'N' || $var_DCPCTOTE == 'N') {
                                        echo "<td title='Either the corporate or local setting is N.' style='background-color:#ff00004d'>$var_PCTOTE</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCTOTE</td>";
                                    }


                                    if (($var_DCPCSHLF != $var_PCSHLF) && ($var_DCPCSHLF != '-')) {
                                        if ($var_DCPCSHLF == ' ') {
                                            echo "<td>$var_PCSHLF</td>";
                                        } else {
                                            echo "<td title='OK in shelf setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCSHLF</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } elseif ($var_DCPCSHLF == 'N' || $var_PCSHLF == 'N') {
                                        echo "<td title='Either the corporate or local setting is N.' style='background-color:#ff00004d'>$var_PCSHLF</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCSHLF</td>";
                                    }


                                    if (($var_DCPCFLOR != $var_PCFLOR) && ($var_DCPCFLOR != '-')) {
                                        if ($var_DCPCFLOR == ' ') {
                                            echo "<td>$var_PCFLOR</td>";
                                        } else {
                                            echo "<td title='OK in flow setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCFLOR</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } elseif ($var_PCCPKG > 0 && $var_PCFLOR == 'N') {
                                        echo "<td title='There is a case pkgu available.  Set OK in flow to Y.' style='background-color:#ff00004d'>$var_PCFLOR</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCFLOR</td>";
                                    }

                                    if (($var_DCPCEROT != $var_PCEROT) && ($var_DCPCEROT != '-')) {
                                        if ($var_DCPCEROT == ' ') {
                                            echo "<td>$var_PCEROT</td>";
                                        } else {
                                            echo "<td title='Rotate setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCEROT</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCEROT</td>";
                                    }


                                    if ($var_PCCPKG > 0 && $var_PCPFRC <> 'P') {
                                        echo "<td title='There is a case package available.  Set corporate PFR to P' style='background-color:#ff00004d'>$var_PCPFRC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_PCPFRC</td>";
                                    }


                                    if (($var_PCCPKG > 0 || $var_PCPFRC == 'P') && $var_DCPCPFRA <> 'Y') {
                                        echo "<td title='Corporate PFR is set to P.  Set DC setting to Y.' style='background-color:#ff00004d'>$var_DCPCPFRA</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_DCPCPFRA</td>";
                                    }

                                    if (($var_DCPCORSH != $var_PCORSH) && ($var_DCPCORSH != '-')) {
                                        if ($var_DCPCORSH == '   ') {
                                            echo "<td>$var_PCORSH</td>";
                                        } else {
                                            echo "<td style='background-color:#ff00004d'>$var_DCPCORSH</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCORSH</td>";
                                    }

                                    if (($var_DCPCLIQU != $var_PCLIQU) && ($var_DCPCLIQU != '-')) {
                                        if ($var_DCPCLIQU == '  ') {
                                            echo "<td>$var_PCLIQU</td>";
                                        } else {
                                            echo "<td title='Liquid setting is different then corporate.' style='background-color:#ff00004d'>$var_DCPCLIQU</td>";
                                            $var_auditcount = $var_auditcount + 1;
                                        }
                                    } else {
                                        echo "<td>$var_PCLIQU</td>";
                                    }

                                    echo "<td>$var_Date</td>";
                                    echo "<td>$var_LMLOC</td>";
                                    echo "<td>$var_grid5</td>";
                                    echo "<td>$var_EachRecSlot</td>";

                                    echo "<td>$var_ASSTIER</td>";

                                    if ($var_ASSTIER <> $var_predtier) {
                                        echo "<td title='Predicted demand does not warrant a $var_ASSTIER tier.  Please place in a $var_predtier tier.' style='background-color:#ff00004d'>$var_predtier</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_predtier</td>";
                                    }
                                    if ($var_LOMAXC / $var_maxtruefit > 1) {
                                        echo "<td title='The set max of $var_LOMAXC is set above the true fit of $var_maxtruefit. Check item dimensions or change location max.' style='background-color:#ff00004d' >$var_LOMAXC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } elseif ($var_LOMAXC / $var_maxtruefit <= .95) {
                                        echo "<td title='The set max of $var_LOMAXC is set below the true fit of $var_maxtruefit.' style='background-color:#ff00004d'>$var_LOMAXC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_LOMAXC</td>";
                                    }

                                    echo "<td>$var_intMaxTF</td>";
                                    echo "<td>$var_EachSLOTQTY</td>";
                                    $var_recmin = round(($var_LOMAXC * .25), 0);
                                    if ($var_LOMINC / $var_recmin > 1.25 || $var_LOMINC / $var_recmin <= .80) {
                                        echo "<td title = 'Min should be $var_recmin.' style='background-color:#ff00004d'>$var_LOMINC</td>";
                                        $var_auditcount = $var_auditcount + 1;
                                    } else {
                                        echo "<td>$var_LOMINC</td>";
                                    }
                                    echo "<td>$var_auditcount</td>";
                                }
                                echo "</tbody>";
                            }
                            ?>

                    </table>
                </div>
                <script>
                    $(document).ready(function () {
                        oTable = $('#ptbtable').dataTable({
                            dom: "<'row'<'col-sm-4 pull-left'B><'col-sm-4 text-center'><'col-sm-4 pull-right'>>" + "<'row'<'col-sm-12't>>" + "<'row'<'col-sm-4 pull-left'><'col-sm-8 pull-right'>>",
                            destroy: true,
                            "scrollX": true,
                            "iDisplayLength": -1,
                            "aaSorting": [],
                            buttons: [
                                'copyHtml5',
                                'excelHtml5'
                            ]
                        });


                    });
                    $("#reports").addClass('active');
                </script>
            </div>
        </div>
    </body>
</html>

