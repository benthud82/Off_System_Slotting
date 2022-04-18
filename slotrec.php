<!DOCTYPE html>

<html>

    <head>
        <title>Slot Size Recommendation</title>
        <?php
        include_once '../connections/conn_slotting.php';
        include_once 'sessioninclude.php';
        include_once 'headerincludes.php';
        include_once 'horizontalnav.php';
        include_once 'verticalnav.php';
        ?>
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge" />-->
        <!--<script src="../jquery.js" type="text/javascript"></script>-->
        <!--<script type="text/javascript" src="../hashchange.js"></script>-->
        <!--<script type="text/javascript" src="../tabscript.js"></script>-->
        <!--<link href="../tabstyles.css" rel="stylesheet" />-->
        <!--<link href="../csvtable.css" rel="stylesheet" />-->
        <!--<link rel="shortcut icon" type="image/ico" href="../favicon.ico" />-->      


    <body style="background-color: #FFFFFF; height: 90%" >

        <!--Main Content-->
        <section id="content"> 
            <section class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
                <h2 style="padding-bottom: 0px;">New Item Slot Recommendation</h2>
                <script src="../jquery.watermarkinput.js" type="text/javascript"></script>
                <script>
                    $(function () {
                        $('#tran').hide();
                        $('#submitrequest').hide();
                        $("#reports").addClass('active');
                    });
                </script>
                <script>
                    $(document).ready(function () {
                        $('#whsesel').bind('change', function (e) {
                            if ($('#whsesel').val() !== '0') {
                                $('#tran').show();
                            } else {
                                $('#tran').hide();
                            }
                        });
                        whsesel = $("#whsesel").val();
                        if (whsesel !== '0') {
                            $('#tran').show();
                        }
                        $('#tran').on('input', function (e) {
                            var max = 9;
                            var len = $(this).val().length;
                            if (len !== max) {
                                $('#submitrequest').hide();
                            } else {
                                $('#submitrequest').show();
                            }
                        });
                    });
                </script>


                <br>

                <div class="submitwrapper">
                    <?php
                    $indy = $sparks = $denver = $dallas = $jax = $NOTL = $vanc = $calg = $GIV = '';
                    if (isset($_GET['whse']) && !empty($_GET['whse'])) {
                        $whssel = $_GET['whse'];


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
                            case 10:
                                $GIV = "selected";
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


                    //Fill in Transaction number if entered




                    echo "<form method='GET'>
           <select name='whse' id='whsesel'>
                <option value='0'>Choose Whse...</option>
                <option value='2' $indy>Indy</option>
                <option value='3'$sparks>Sparks</option>
                <option value='6'$denver>Denver</option>
                <option value='7'$dallas>Dallas</option>
                <option value='9'$jax>Jacksonville</option>
                <option value='10'$GIV>GIV</option>
                <option value='11'$NOTL>NOTL</option>
                <option value='12'$vanc>Vancouver</option>
                <option value='16'$calg>Calgary</option>
            </select>
            <input name='tran' class='textinput' id='tran'>
            <input type='submit' name='formSubmit' value='Submit' id = 'submitrequest'/>
        </form>"
                    ?>

                </div>
                <br>
                <div class="line-separator"></div> <br>
                <script>
                    jQuery(function ($) {
                        $("#tran").Watermark("Scan/Enter Trans#");
                    });
                </script>
                <?php
                if (!empty($_GET['tran']) && !empty($_GET['whse'])) {
                    $transnum = $_GET['tran'];
                    $var_whse = intval($_GET['whse']);
                } else {
                    die;
                }



                //Determine if user has selected a grid using the change grid form
                if (isset($_POST['grid5'])) {
                    $selectedgrid5 = $_POST['grid5'];
                }

                //Determine if user has selected a different MC from modifications
                $Asel = $Bsel = $Csel = $Dsel = '';
                if (isset($_POST['itemmc'])) {

                    $selectedmc = $_POST['itemmc'];
                    switch ($selectedmc) {
                        case 'A':
                            $Asel = "selected";
                            break;
                        case 'B':
                            $Bsel = "selected";
                            break;
                        case 'C':
                            $Csel = "selected";
                            break;
                        case 'D':
                            $Dsel = "selected";
                            break;
                    }
                }
                ?> 


                <?php
                ini_set('max_execution_time', 99999);
                $USAarray = array(2, 3, 6, 7, 9, 10);
                $CANarray = array(11, 12, 16);

                if (in_array($var_whse, $USAarray)) {
                    //START of USA Slot Rec
                    $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
                    $pdo_username = "BHUD01";
                    $pdo_password = "2glacier2";
                    $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

                    #Query the Database into a result set - 
                    $result = $aseriesconn->prepare("SELECT EAITEM, IMDESC, IMSTRN, IMSIZE, IMVEND, IMLOCT, EATRNQ from A.HSIPCORDTA.NPFERA, A.HSIPCORDTA.NPFIMS01 WHERE IMITEM = EAITEM and EATRN# = '" . $transnum . "' and EASEQ3 = 1");
                    $result->execute();
                    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

                    foreach ($resultsetarray as $rsrow => $value) {

                        $var_EAITEM = $resultsetarray[$rsrow][0];
                        $var_IMDESC = $resultsetarray[$rsrow][1];
                        $var_IMSTRN = $resultsetarray[$rsrow][2];
                        $var_IMSIZE = $resultsetarray[$rsrow][3];
                        $var_IMVEND = $resultsetarray[$rsrow][4];
                        $var_IMLOCT = $resultsetarray[$rsrow][5];
                        $var_EATRNQ = $resultsetarray[$rsrow][6];
                    }

                    if ($resultsetarray == null) {
                        echo "This transaction number is not valid.  Please enter another transaction.";
                        die;
                    }

                    /* --------------------------------------------------------------------- */
                    /* Retrieve CPC info
                      /* --------------------------------------------------------------------- */

                    $cpcresult = $aseriesconn->prepare("SELECT PCWHSE,PCITEM,PCELEN,PCEHEI,PCEWID,PCEWGT,PCEVOL,PCEPKU,PCCPKU,PCCLEN,PCCHEI,PCCWID,PCCWGT,PCCVOL,PCLIQU from A.HSIPCORDTA.NPFCPC WHERE PCITEM = '" . $var_EAITEM . "' and PCWHSE = 0");
                    $cpcresult->execute();
                    $cpcresultarray = $cpcresult->fetchAll(PDO::FETCH_NUM);

                    foreach ($cpcresultarray as $rsrow => $value) {
                        $var_PCELEN = number_format((float) $cpcresultarray[$rsrow][2], 2, '.', '');
                        $var_PCELENInch = number_format((float) $cpcresultarray[$rsrow][2] * .393701, 2, '.', '');
                        $var_PCEHEI = number_format((float) $cpcresultarray[$rsrow][3], 2, '.', '');
                        $var_PCEHEIInch = number_format((float) $cpcresultarray[$rsrow][3] * .393701, 2, '.', '');
                        $var_PCEWID = number_format((float) $cpcresultarray[$rsrow][4], 2, '.', '');
                        $var_PCEWIDInch = number_format((float) $cpcresultarray[$rsrow][4] * .393701, 2, '.', '');
                        $var_PCEWGT = number_format((float) $cpcresultarray[$rsrow][5], 2, '.', '');
                        $var_PCEVOL = number_format((float) $cpcresultarray[$rsrow][6], 2, '.', '');
                        $var_PCEPKU = intval($cpcresultarray[$rsrow][7]);
                        $var_PCCPKU = intval($cpcresultarray[$rsrow][8]);
                        $var_PCCLEN = number_format((float) $cpcresultarray[$rsrow][9], 2, '.', '');
                        $var_PCCLENInch = number_format((float) $cpcresultarray[$rsrow][9] * .393701, 2, '.', '');
                        $var_PCCHEI = number_format((float) $cpcresultarray[$rsrow][10], 2, '.', '');
                        $var_PCCHEIInch = number_format((float) $cpcresultarray[$rsrow][10] * .393701, 2, '.', '');
                        $var_PCCWID = number_format((float) $cpcresultarray[$rsrow][11], 2, '.', '');
                        $var_PCCWIDInch = number_format((float) $cpcresultarray[$rsrow][11] * .393701, 2, '.', '');
                        $var_PCCWGT = number_format((float) $cpcresultarray[$rsrow][12], 2, '.', '');
                        $var_PCCVOL = number_format((float) $cpcresultarray[$rsrow][13], 2, '.', '');
                        $var_PCLIQU = $cpcresultarray[$rsrow][14];
                    }



                    /* --------------------------------------------------------------------- */
                    /* E3 Info */
                    /* --------------------------------------------------------------------- */

                    $var_IDEM13 = .01;
                    $e3result = $aseriesconn->prepare("SELECT IITEM, max(IDEM13) from A.E3TSCHEIN.E3ITEM WHERE IITEM = '" . $var_EAITEM . "' and int(IWHSE) =  $var_whse group by IITEM");
                    $e3result->execute();
                    $e3resultarray = $e3result->fetchAll(PDO::FETCH_NUM);

                    foreach ($e3resultarray as $rsrow => $value) {
                        $var_IDEM13 = $e3resultarray[$rsrow][1];
                    }
                    ?>
                    <div class="tableitemchar">
                        <table>
                            <tr>
                                <td colspan="2" style="text-align:center"><strong>Item Physical Characteristics</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Item Code:</strong> <?php echo $var_EAITEM; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Description:</strong> <?php echo $var_IMDESC; ?></td>
                            </tr>
                            <tr>             
                                <td colspan="2"><strong>Strength:</strong> <?php echo $var_IMSTRN; ?></td>
                            </tr>
                            <tr>               
                                <td colspan="2"><strong>Size:</strong> <?php echo $var_IMSIZE; ?></td>
                            </tr>
                            <tr>               
                                <td colspan="2"><strong>Supplier:</strong> <?php echo $var_IMVEND; ?></td>
                            </tr>
                            <tr>               
                                <td colspan="2"><strong>Fridge Code:</strong> <?php echo $var_IMLOCT; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Liquid:</strong> <?php echo $var_PCLIQU; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Each Length:</strong> <?php echo $var_PCELEN; ?> cm <strong> | </strong> <?php echo $var_PCELENInch; ?> in</td>
                                <td><strong>Case Length:</strong> <?php echo $var_PCCLEN; ?> cm <strong> | </strong> <?php echo $var_PCCLENInch; ?> in</td>
                            </tr>
                            <tr>
                                <td><strong>Each Width:</strong> <?php echo $var_PCEWID; ?> cm <strong> | </strong> <?php echo $var_PCEWIDInch; ?> in</td>
                                <td><strong>Case Width:</strong> <?php echo $var_PCCWID; ?> cm <strong> | </strong> <?php echo $var_PCCWIDInch; ?> in</td>
                            </tr>
                            <tr>
                                <td><strong>Each Height:</strong> <?php echo $var_PCEHEI; ?> cm <strong> | </strong> <?php echo $var_PCEHEIInch; ?> in</td>
                                <td><strong>Case Height:</strong> <?php echo $var_PCCHEI; ?> cm <strong> | </strong> <?php echo $var_PCCHEIInch; ?> in</td>
                            </tr>
                            <tr>
                                <td><strong>Each Weight:</strong> <?php echo $var_PCEWGT; ?> lbs</td>
                                <td><strong>Case Weight:</strong> <?php echo $var_PCCWGT; ?> lbs</td>
                            </tr>
                            <tr>
                                <td><strong>Each Vol:</strong> <?php echo $var_PCEVOL; ?> cc</td>
                                <td><strong>Case Vol:</strong> <?php echo $var_PCCVOL; ?> cc</td>
                            </tr>
                            <tr>
                                <td><strong>Each Pkgu:</strong> <?php echo $var_PCEPKU; ?></td>
                                <td><strong>Case Pkgu:</strong> <?php echo $var_PCCPKU; ?></td>
                            </tr>
                        </table>
                    </div>

                    <?php
                    include_once("../globalfunctions/newitem.php");
                    $var_DailyDem = ($var_IDEM13 / 28);
                    $var_2weekdmd = $var_DailyDem * 10;

                    //Call slotqty function to determine how many should slot in primary
                    $var_EachSLOTQTY = _slotqty($var_PCCPKU, $var_2weekdmd, $var_EATRNQ, $var_DailyDem);

                    //Call newmc function to determine starting movement class
                    if (isset($selectedmc)) {
                        $var_preditemMC = $selectedmc;
                    } else {
                        $var_preditemMC = _newmc($var_DailyDem);
                    }

                    if ($var_preditemMC == '') {
                        $var_preditemMC = _newmc($var_DailyDem);
                    }

                    //Call predtier function to determine slotting tier
                    $var_predtier = _predtier($var_preditemMC, $var_whse);

                    //Call okgrids function to determine okgrids
                    $okgrids = _okgrids($var_preditemMC, $var_whse);

                    $emptygrids = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.HSIPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) AND (LMITEM = '') and (LMTIER in ('" . $var_predtier . "')) and LMLOCK <> 'H ' and LMGRD5 <> '     ' and (LMFIXA in ('" . $okgrids . "')) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end not in ('06S15Sub22', '11S07Sub20') ORDER BY LMVOL9 ASC");
                    $emptygrids->execute();
                    $emptygridsarray = $emptygrids->fetchAll(PDO::FETCH_NUM);

                    $var_PCEHEIin = $var_PCEHEI / 2.54;
                    $var_PCELENin = $var_PCELEN / 2.54;
                    $var_PCEWIDin = $var_PCEWID / 2.54;

                    if ($var_PCEHEIin == 0 || $var_PCELENin == 0 || $var_PCEWIDin == 0) {
                        echo "There is no loose package unit available.  Please choose another transaction.";
                        die;
                    }

                    if ($var_IMLOCT !== "  ") {
                        echo "This is an item that requires refridgeration.  Please choose another transaction.";
                        die;
                    }

                    if (!empty($selectedgrid5)) {//If user has overridden the recommended grid.
                        //find grid height, depth, width based on example location
                        $exampleloc = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.HSIPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end = '" . $selectedgrid5 . "'");
                        $exampleloc->execute();
                        $examplelocarray = $exampleloc->fetchAll(PDO::FETCH_NUM);
                        foreach ($examplelocarray as $locrow => $locvalue) {
                            $var_gridheight = $examplelocarray[$locrow][1];
                            $var_griddepth = $examplelocarray[$locrow][2];
                            $var_gridwidth = $examplelocarray[$locrow][3];
                        }

                        $var_truefitarray = _truefitgrid($selectedgrid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin);
                    } else { //perform normal true fit by iterating through all available grids.
                        for ($i = 0; $i < count($emptygridsarray); $i++) {

                            $var_grid5 = $emptygridsarray[$i][0];
                            $var_gridheight = $emptygridsarray[$i][1];
                            $var_griddepth = $emptygridsarray[$i][2];
                            $var_gridwidth = $emptygridsarray[$i][3];

                            //Call truefit function and return grid5 and max true fit if possible
                            $var_truefitarray = _truefit($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin, $var_EachSLOTQTY, 9999);
                            if (isset($var_truefitarray)) {
                                break;
                            }
                        }


                        //If cannot find grid for first recommended slot qty, only slot two weeks regardless of transaction qty
                        if (!isset($var_truefitarray)) {
                            $var_EachSLOTQTY = _slotqtyround2($var_PCCPKU, $var_2weekdmd, $var_EATRNQ);

                            for ($i = 0; $i < count($emptygridsarray); $i++) {

                                $var_grid5 = $emptygridsarray[$i][0];
                                $var_gridheight = $emptygridsarray[$i][1];
                                $var_griddepth = $emptygridsarray[$i][2];
                                $var_gridwidth = $emptygridsarray[$i][3];

                                $var_truefitarray = _truefit($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin, $var_EachSLOTQTY, 9999); //Call truefit function
                                if (isset($var_truefitarray)) {
                                    break;
                                }
                            }
                        }
                    }

                    if (!isset($var_truefitarray)) { //If still no location available return no location available
                        $var_EachRecSlot = 'No Grid Avail.';
                        $var_maxtruefit = '-';
                    } else {
                        //Assign returns from true fit calc function to variables
                        $var_EachRecSlot = $var_truefitarray[0];
                        $var_maxtruefit = $var_truefitarray[1];
                    }


                    $emptylocs = $aseriesconn->prepare("SELECT LMLOC#, RAND() as IDX FROM A.HSIPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) AND (LMITEM = '') and LMLOCK <> 'H ' and LMGRD5 <> '     ' and LMTIER in '" . $var_predtier . "' and (LMFIXA in ('" . $okgrids . "')) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end = '" . $var_EachRecSlot . "' and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end not in ('06S15Sub22') ORDER BY IDX FETCH FIRST 5 ROWS ONLY");
                    $emptylocs->execute();
                    $emptylocssarray = $emptylocs->fetchAll(PDO::FETCH_NUM);
                } else {

                    //START of Canada Slot Rec
                    $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
                    $pdo_username = "BHUDS1";
                    $pdo_password = "g1acier1";
                    $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

                    #Query the Database into a result set - 
                    $result = $aseriesconn->prepare("SELECT EAITEM, IMDESC, IMSTRN, IMSIZE, IMVEND, IMLOCT, EATRNQ from A.ARCPCORDTA.NPFERA, A.ARCPCORDTA.NPFIMS01 WHERE IMITEM = EAITEM and EATRN# = '" . $transnum . "' and EASEQ3 = 1");
                    $result->execute();
                    $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

                    foreach ($resultsetarray as $rsrow => $value) {

                        $var_EAITEM = $resultsetarray[$rsrow][0];
                        $var_IMDESC = $resultsetarray[$rsrow][1];
                        $var_IMSTRN = $resultsetarray[$rsrow][2];
                        $var_IMSIZE = $resultsetarray[$rsrow][3];
                        $var_IMVEND = $resultsetarray[$rsrow][4];
                        $var_IMLOCT = $resultsetarray[$rsrow][5];
                        $var_EATRNQ = $resultsetarray[$rsrow][6];
                    }

                    /* --------------------------------------------------------------------- */
                    /* Retrieve CPC info
                      /* --------------------------------------------------------------------- */

                    $cpcresult = $aseriesconn->prepare("SELECT PCWHSE,PCITEM,PCELEN,PCEHEI,PCEWID,PCEWGT,PCEVOL,PCEPKU,PCCPKU,PCCLEN,PCCHEI,PCCWID,PCCWGT,PCCVOL,PCLIQU from A.ARCPCORDTA.NPFCPC WHERE PCITEM = '" . $var_EAITEM . "' and PCWHSE = 0");
                    $cpcresult->execute();
                    $cpcresultarray = $cpcresult->fetchAll(PDO::FETCH_NUM);

                    foreach ($cpcresultarray as $rsrow => $value) {
                        $var_PCELEN = number_format((float) $cpcresultarray[$rsrow][2], 2, '.', '');
                        $var_PCELENInch = number_format((float) $cpcresultarray[$rsrow][2] * .393701, 2, '.', '');
                        $var_PCEHEI = number_format((float) $cpcresultarray[$rsrow][3], 2, '.', '');
                        $var_PCEHEIInch = number_format((float) $cpcresultarray[$rsrow][3] * .393701, 2, '.', '');
                        $var_PCEWID = number_format((float) $cpcresultarray[$rsrow][4], 2, '.', '');
                        $var_PCEWIDInch = number_format((float) $cpcresultarray[$rsrow][4] * .393701, 2, '.', '');
                        $var_PCEWGT = number_format((float) $cpcresultarray[$rsrow][5], 2, '.', '');
                        $var_PCEVOL = number_format((float) $cpcresultarray[$rsrow][6], 2, '.', '');
                        $var_PCEPKU = intval($cpcresultarray[$rsrow][7]);
                        $var_PCCPKU = intval($cpcresultarray[$rsrow][8]);
                        $var_PCCLEN = number_format((float) $cpcresultarray[$rsrow][9], 2, '.', '');
                        $var_PCCLENInch = number_format((float) $cpcresultarray[$rsrow][9] * .393701, 2, '.', '');
                        $var_PCCHEI = number_format((float) $cpcresultarray[$rsrow][10], 2, '.', '');
                        $var_PCCHEIInch = number_format((float) $cpcresultarray[$rsrow][10] * .393701, 2, '.', '');
                        $var_PCCWID = number_format((float) $cpcresultarray[$rsrow][11], 2, '.', '');
                        $var_PCCWIDInch = number_format((float) $cpcresultarray[$rsrow][11] * .393701, 2, '.', '');
                        $var_PCCWGT = number_format((float) $cpcresultarray[$rsrow][12], 2, '.', '');
                        $var_PCCVOL = number_format((float) $cpcresultarray[$rsrow][13], 2, '.', '');
                        $var_PCLIQU = $cpcresultarray[$rsrow][14];
                    }



                    /* --------------------------------------------------------------------- */
                    /* E3 Info */
                    /* --------------------------------------------------------------------- */

                    $var_IDEM13 = .01;
                    $e3result = $aseriesconn->prepare("SELECT IITEM, max(IDEM13) from A.E3TARC.E3ITEM WHERE IITEM = '" . $var_EAITEM . "' and IWHSE = '0" . $var_whse . "' group by IITEM");
                    $e3result->execute();
                    $e3resultarray = $e3result->fetchAll(PDO::FETCH_NUM);

                    foreach ($e3resultarray as $rsrow => $value) {
                        $var_IDEM13 = $e3resultarray[$rsrow][1];
                    }
                    ?>
                    <div class="tableitemchar">
                        <table>
                            <tr>
                                <td colspan="2" style="text-align:center"><strong>Item Physical Characteristics</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Item Code:</strong> <?php echo $var_EAITEM; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Description:</strong> <?php echo $var_IMDESC; ?></td>
                            </tr>
                            <tr>             
                                <td colspan="2"><strong>Strength:</strong> <?php echo $var_IMSTRN; ?></td>
                            </tr>
                            <tr>               
                                <td colspan="2"><strong>Size:</strong> <?php echo $var_IMSIZE; ?></td>
                            </tr>
                            <tr>               
                                <td colspan="2"><strong>Supplier:</strong> <?php echo $var_IMVEND; ?></td>
                            </tr>
                            <tr>               
                                <td colspan="2"><strong>Fridge Code:</strong> <?php echo $var_IMLOCT; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Liquid:</strong> <?php echo $var_PCLIQU; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Each Length:</strong> <?php echo $var_PCELEN; ?> cm <strong> | </strong> <?php echo $var_PCELENInch; ?> in</td>
                                <td><strong>Case Length:</strong> <?php echo $var_PCCLEN; ?> cm <strong> | </strong> <?php echo $var_PCCLENInch; ?> in</td>
                            </tr>
                            <tr>
                                <td><strong>Each Width:</strong> <?php echo $var_PCEWID; ?> cm <strong> | </strong> <?php echo $var_PCEWIDInch; ?> in</td>
                                <td><strong>Case Width:</strong> <?php echo $var_PCCWID; ?> cm <strong> | </strong> <?php echo $var_PCCWIDInch; ?> in</td>
                            </tr>
                            <tr>
                                <td><strong>Each Height:</strong> <?php echo $var_PCEHEI; ?> cm <strong> | </strong> <?php echo $var_PCEHEIInch; ?> in</td>
                                <td><strong>Case Height:</strong> <?php echo $var_PCCHEI; ?> cm <strong> | </strong> <?php echo $var_PCCHEIInch; ?> in</td>
                            </tr>
                            <tr>
                                <td><strong>Each Weight:</strong> <?php echo $var_PCEWGT; ?> lbs</td>
                                <td><strong>Case Weight:</strong> <?php echo $var_PCCWGT; ?> lbs</td>
                            </tr>
                            <tr>
                                <td><strong>Each Vol:</strong> <?php echo $var_PCEVOL; ?> cc</td>
                                <td><strong>Case Vol:</strong> <?php echo $var_PCCVOL; ?> cc</td>
                            </tr>
                            <tr>
                                <td><strong>Each Pkgu:</strong> <?php echo $var_PCEPKU; ?></td>
                                <td><strong>Case Pkgu:</strong> <?php echo $var_PCCPKU; ?></td>
                            </tr>
                        </table>
                    </div>

                    <?php
                    include_once("../globalfunctions/newitem.php");
                    $var_DailyDem = ($var_IDEM13 / 28);
                    $var_2weekdmd = $var_DailyDem * 10;

                    //Call slotqty function to determine how many should slot in primary
                    $var_EachSLOTQTY = _slotqty($var_PCCPKU, $var_2weekdmd, $var_EATRNQ, $var_DailyDem);

                    //Call newmc function to determine starting movement class
                    $var_preditemMC = _newmc($var_DailyDem);

                    //Call predtier function to determine slotting tier
                    $var_predtier = _predtier($var_preditemMC, $var_whse);

                    //Call okgrids function to determine okgrids
                    $okgrids = _okgrids($var_preditemMC, $var_whse);

                    $emptygrids = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.ARCPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) AND  LMLOCK <> 'H ' and LMGRD5 <> '     ' and (LMITEM = '') and (LMTIER in ('" . $var_predtier . "')) and (LMFIXA in ('" . $okgrids . "')) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end not in ('06S15Sub22', '11S07Sub20') ORDER BY LMVOL9 ASC");
                    $emptygrids->execute();
                    $emptygridsarray = $emptygrids->fetchAll(PDO::FETCH_NUM);

                    $var_PCEHEIin = $var_PCEHEI / 2.54;
                    $var_PCELENin = $var_PCELEN / 2.54;
                    $var_PCEWIDin = $var_PCEWID / 2.54;

                    if ($var_PCEHEIin == 0 || $var_PCELENin == 0 || $var_PCEWIDin == 0) {
                        echo "There is no loose package unit available.  Please choose another transaction.";
                        die;
                    }

                    if ($var_IMLOCT !== "  ") {
                        echo "This is an item that requires refridgeration.  Please choose another transaction.";
                        die;
                    }

                    if (isset($selectedgrid5)) {//If user has overridden the recommended grid.
                        //find grid height, depth, width based on example location
                        $exampleloc = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.ARCPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end = '" . $selectedgrid5 . "'");
                        $exampleloc->execute();
                        $examplelocarray = $exampleloc->fetchAll(PDO::FETCH_NUM);
                        foreach ($examplelocarray as $locrow => $locvalue) {
                            $var_gridheight = $examplelocarray[$locrow][1];
                            $var_griddepth = $examplelocarray[$locrow][2];
                            $var_gridwidth = $examplelocarray[$locrow][3];
                        }

                        $var_truefitarray = _truefitgrid($selectedgrid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin);
                    } else { //perform normal true fit by iterating through all available grids.
                        for ($i = 0; $i < count($emptygridsarray); $i++) {

                            $var_grid5 = $emptygridsarray[$i][0];
                            $var_gridheight = $emptygridsarray[$i][1];
                            $var_griddepth = $emptygridsarray[$i][2];
                            $var_gridwidth = $emptygridsarray[$i][3];

                            //Call truefit function and return grid5 and max true fit if possible
                            $var_truefitarray = _truefit($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin, $var_EachSLOTQTY, 9999);
                            if (isset($var_truefitarray)) {
                                break;
                            }
                        }


                        //If cannot find grid for first recommended slot qty, only slot two weeks regardless of transaction qty
                        if (!isset($var_truefitarray)) {
                            $var_EachSLOTQTY = _slotqtyround2($var_PCCPKU, $var_2weekdmd, $var_EATRNQ);

                            for ($i = 0; $i < count($emptygridsarray); $i++) {

                                $var_grid5 = $emptygridsarray[$i][0];
                                $var_gridheight = $emptygridsarray[$i][1];
                                $var_griddepth = $emptygridsarray[$i][2];
                                $var_gridwidth = $emptygridsarray[$i][3];

                                $var_truefitarray = _truefit($var_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin, $var_EachSLOTQTY, 9999); //Call truefit function
                                if (isset($var_truefitarray)) {
                                    break;
                                }
                            }
                        }
                    }

                    //Assign returns from true fit calc function to variables
                    $var_EachRecSlot = $var_truefitarray[0];
                    $var_maxtruefit = $var_truefitarray[1];



                    $emptylocs = $aseriesconn->prepare("SELECT LMLOC#, RAND() as IDX FROM A.ARCPCORDTA.NPFLSM WHERE (LMWHSE = $var_whse) AND (LMITEM = '') and LMLOCK <> 'H ' and LMGRD5 <> '     ' and LMTIER in '" . $var_predtier . "' and (LMFIXA in ('" . $okgrids . "')) and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end = '" . $var_EachRecSlot . "' and case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end not in ('06S15Sub22') ORDER BY IDX FETCH FIRST 5 ROWS ONLY");
                    $emptylocs->execute();
                    $emptylocssarray = $emptylocs->fetchAll(PDO::FETCH_NUM);
                }
                ?>


                <div class ="background_wrapper">
                    <div class="slotrecs">
                        <table>
                            <tr>
                                <td colspan="2" style="text-align:center"><strong>Slotting Recommendations</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Predicted Four Week Demand: </strong></td>
                                <td><?php echo number_format($var_IDEM13, 2); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Location Max: </strong></td>
                                <td><?php echo intval($var_maxtruefit); ?></td>
                            </tr>
                            <tr>

                                <td><strong>Recommended Location Min: </strong></td>
                                <td><?php
                                    $var_recmin = ceil($var_maxtruefit * .25);
                                    echo intval($var_recmin);
                                    ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Slot Qty: </strong></td>
                                <td><?php echo $var_EachSLOTQTY; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Grid5: </strong></td>
                                <td><?php echo $var_EachRecSlot; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Movement Class: </strong></td>
                                <td><?php echo $var_preditemMC; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Tier: </strong></td>
                                <td><?php echo $var_predtier; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Location 1: </strong></td>
                                <td>
                                    <?php
                                    if (isset($emptylocssarray[0])) {
                                        echo $emptylocssarray[0][0];
                                    } else {
                                        echo'No Loc. Avail';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Location 2: </strong></td>
                                <td>
                                    <?php
                                    if (isset($emptylocssarray[1])) {
                                        echo $emptylocssarray[1][0];
                                    } else {
                                        echo'No Loc. Avail';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Location 3: </strong></td>
                                <td>
                                    <?php
                                    if (isset($emptylocssarray[2])) {
                                        echo $emptylocssarray[2][0];
                                    } else {
                                        echo'No Loc. Avail';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Location 4: </strong></td>
                                <td>
                                    <?php
                                    if (isset($emptylocssarray[3])) {
                                        echo $emptylocssarray[3][0];
                                    } else {
                                        echo'No Loc. Avail';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Recommended Location 5: </strong></td>

                                <td>
                                    <?php
                                    if (isset($emptylocssarray[4])) {
                                        echo $emptylocssarray[4][0];
                                    } else {
                                        echo'No Loc. Avail';
                                    }
                                    ?>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="vertical-separator"></div>
                    <!--Give the user the ability to change the recommended grid5-->
                    <div class ="modify">
                        <fieldset>
                            <legend><strong>Modifications</strong></legend>
                            <br>
                            <?php $grid5url = 'slotrec.php?tran=' . $transnum . '&whse=' . $var_whse . '&formSubmit=Submit'; ?>

                            <form method='post' action="<?php echo $grid5url ?>">

                                <select id='grid5' name='grid5'>  <!--Make a change to the system recommended grid 5-->
                                    <option value ="">Change Grid5...</option> Choose different grid5:
                                    <?php
                                    if (in_array($var_whse, $USAarray)) {
                                        //Pull in other grids for USA
                                        $resultgrids = $aseriesconn->prepare("SELECT case when LMDEEP <> 24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMVOL9, count(LMCOMP) FROM A.HSIPCORDTA.NPFLSM WHERE LMWHSE = $whssel and (LMTIER in ('" . $var_predtier . "')) and (LMFIXA in ('" . $okgrids . "')) AND (LMITEM = '') and LMLOCK <> 'H ' and LMGRD5 <> '     ' GROUP BY case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end, LMVOL9 ORDER BY LMVOL9 asc");
                                        $resultgrids->execute();
                                        $resultgridsarray = $resultgrids->fetchAll(PDO::FETCH_NUM);

                                        foreach ($resultgridsarray as $key => $value):
                                            if (isset($_POST['grid5']) && $selectedgrid5 == $value[0]) { //keep selected value in dropdown box
                                                echo '<option value = "' . $value[0] . '" selected>' . $value[0] . '</option>';
                                            } else { //defualt to select grid5...
                                                echo '<option value = "' . $value[0] . '">' . $value[0] . '</option>';
                                            }
                                        endforeach;
                                    } else {
                                        //Pull in other grids for Canada
                                        $resultgrids = $aseriesconn->prepare("SELECT case when LMDEEP <> 24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMVOL9, count(LMCOMP) FROM A.ARCPCORDTA.NPFLSM WHERE LMWHSE = $whssel and (LMTIER in ('" . $var_predtier . "')) and (LMFIXA in ('" . $okgrids . "')) AND (LMITEM = '') and LMLOCK <> 'H ' and LMGRD5 <> '     ' and LMVOL9 > 0 GROUP BY case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end, LMVOL9 ORDER BY LMVOL9 asc");
                                        $resultgrids->execute();
                                        $resultgridsarray = $resultgrids->fetchAll(PDO::FETCH_NUM);

                                        foreach ($resultgridsarray as $key => $value):
                                            echo '<option value = "' . $value[0] . '">' . $value[0] . '</option>';
                                        endforeach;
                                    }
                                    ?>
                                </select>
                                <br>
                                <select id='itemmc' name='itemmc'>  <!--Make a change to the system recommended item movement class-->
                                    <option value ="">Change Item MC...</option>
                                    <option value ="A" <?php echo $Asel ?> >A</option>
                                    <option value ="B"<?php echo $Bsel ?> >B</option>
                                    <option value ="C"<?php echo $Csel ?> >C</option>
                                    <option value ="D"<?php echo $Dsel ?> >D</option>
                                    <br>
                                    <input type='submit' name='formSubmit' value='Submit Modifications' />
                            </form>
                            <p>
                        </fieldset>
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

                    }(this, document, jQuery));



                </script>

                <script>
                    $(function () {
                        $('input, textarea').placeholder();
                    });

                    $("#reports").addClass('active');
                </script>

            </section>
        </section>

    </body>

</html>

