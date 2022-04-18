<?php

include_once("../globalfunctions/newitem.php");
$post_grid5 = $_REQUEST["grid5select"];
$post_itempicked = $_REQUEST["item"];
$whspicked = intval($_REQUEST["whs"]);


if ($post_itempicked >= 1000000 && $post_itempicked <= 9999999) {
    $USAarray = array(2, 3, 6, 7, 9);
    $CANarray = array(11, 12, 16);

    if (in_array($whspicked, $USAarray)) {
        //START of USA True fit Calc
        $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
        $pdo_username = "BHUD01";
        $pdo_password = "2glacier2";
        $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

        #Query the Database into a result set - 
        $result = $aseriesconn->prepare("SELECT PCELEN,PCEHEI,PCEWID, PCLIQU FROM A.HSIPCORDTA.NPFCPC WHERE PCITEM = '" . $post_itempicked . "' and PCWHSE = 0");
        $result->execute();
        $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);
        //assign variables to len, wid, and height
        foreach ($resultsetarray as $rsrow => $value) {
            $var_PCELEN = $resultsetarray[$rsrow][0];
            $var_PCEHEI = $resultsetarray[$rsrow][1];
            $var_PCEWID = $resultsetarray[$rsrow][2];
            $var_PCLIQU = $resultsetarray[$rsrow][3];
        }

        //find example location to pull grid dimensions
        $exampleloc = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.HSIPCORDTA.NPFLSM WHERE case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end = '" . $post_grid5 . "' and LMWHSE = $whspicked");
        $exampleloc->execute();
        $examplelocarray = $exampleloc->fetchAll(PDO::FETCH_NUM);
        foreach ($examplelocarray as $locrow => $locvalue) {
            $var_gridheight = $examplelocarray[$locrow][1];
            $var_griddepth = $examplelocarray[$locrow][2];
            $var_gridwidth = $examplelocarray[$locrow][3];
        }

        $var_PCEHEIin = $var_PCEHEI / 2.54;
        $var_PCELENin = $var_PCELEN / 2.54;
        $var_PCEWIDin = $var_PCEWID / 2.54;

        //call truefitgrid function to calculate true fit.
        $var_truefitarray = _truefitgrid($post_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin);

        $var_EachRecSlot = $var_truefitarray[0];
        $var_maxtruefit = $var_truefitarray[1];
        $var_attempt1 = $var_truefitarray[2];
        $var_attempt2 = $var_truefitarray[3];
        $var_attempt3 = $var_truefitarray[4];
        $var_attempt4 = $var_truefitarray[5];
        $var_attempt5 = $var_truefitarray[6];
        $var_attempt6 = $var_truefitarray[7];
        $var_gridHprodL = $var_truefitarray[8];
        $var_gridHprodW = $var_truefitarray[9];
        $var_gridHprodH = $var_truefitarray[10];
        $var_gridDprodL = $var_truefitarray[11];
        $var_gridDprodW = $var_truefitarray[12];
        $var_gridDprodH = $var_truefitarray[13];
        $var_gridWprodL = $var_truefitarray[14];
        $var_gridWprodW = $var_truefitarray[15];
        $var_gridWprodH = $var_truefitarray[16];

        //call productorient function to determine how to place product in grid to achieve max true fit
        $var_orientarray = _productorient($var_maxtruefit, $var_attempt1, $var_attempt2, $var_attempt3, $var_attempt4, $var_attempt5, $var_attempt6, $var_gridHprodL, $var_gridHprodW, $var_gridHprodH, $var_gridDprodL, $var_gridDprodW, $var_gridDprodH, $var_gridWprodL, $var_gridWprodW, $var_gridWprodH);
        $var_itemheightorient = $var_orientarray[0];
        $var_itemlengthtorient = $var_orientarray[1];
        $var_itemwidthorient = $var_orientarray[2];
//      Logic to calculate true fit
//      Variables from "../PHPLogic/tflogic.php"
        echo 'The true fit for item <b>' . $post_itempicked . '</b> in a <b>' . $post_grid5 . '</b> is <b>' . $var_maxtruefit . '</b> units.';
        echo '<br><br><div class="line-separator"></div>';
        echo "<ul><li> $var_itemheightorient</li>";
        echo "<li> $var_itemlengthtorient</li>";
        echo "<li> $var_itemwidthorient</li></ul>";

        $var_truefitarrayround2 = _truefitgrid2iterations($post_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin);

        $var_round2tf = $var_truefitarrayround2[1] - $var_truefitarrayround2[0];
        echo '<div class="line-separator"></div> <br>';
        echo 'Two round true fit is <b>' . $var_truefitarrayround2[1] .'</b> units.';
    } else {
        //START of Canada True fit Calc
        $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
        $pdo_username = "BHUDS1";
        $pdo_password = "tucker1234";
        $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

        #Query the Database into a result set - 
        $result = $aseriesconn->prepare("SELECT PCELEN,PCEHEI,PCEWID, PCLIQU FROM A.ARCPCORDTA.NPFCPC WHERE PCITEM = '" . $post_itempicked . "' and PCWHSE = 0");
        $result->execute();
        $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);
        //assign variables to len, wid, and height
        foreach ($resultsetarray as $rsrow => $value) {
            $var_PCELEN = $resultsetarray[$rsrow][0];
            $var_PCEHEI = $resultsetarray[$rsrow][1];
            $var_PCEWID = $resultsetarray[$rsrow][2];
            $var_PCLIQU = $resultsetarray[$rsrow][3];
        }

        //find example location to pull grid dimensions
        $exampleloc = $aseriesconn->prepare("SELECT DISTINCT case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMHIGH,LMDEEP, LMWIDE,LMVOL9 FROM A.ARCPCORDTA.NPFLSM WHERE case when LMDEEP <>  24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end = '" . $post_grid5 . "'");
        $exampleloc->execute();
        $examplelocarray = $exampleloc->fetchAll(PDO::FETCH_NUM);
        foreach ($examplelocarray as $locrow => $locvalue) {
            $var_gridheight = $examplelocarray[$locrow][1];
            $var_griddepth = $examplelocarray[$locrow][2];
            $var_gridwidth = $examplelocarray[$locrow][3];
        }

        $var_PCEHEIin = $var_PCEHEI / 2.54;
        $var_PCELENin = $var_PCELEN / 2.54;
        $var_PCEWIDin = $var_PCEWID / 2.54;

        //call truefitgrid function to calculate true fit.
        $var_truefitarray = _truefitgrid($post_grid5, $var_gridheight, $var_griddepth, $var_gridwidth, $var_PCLIQU, $var_PCEHEIin, $var_PCELENin, $var_PCEWIDin);

        $var_EachRecSlot = $var_truefitarray[0];
        $var_maxtruefit = $var_truefitarray[1];
        $var_attempt1 = $var_truefitarray[2];
        $var_attempt2 = $var_truefitarray[3];
        $var_attempt3 = $var_truefitarray[4];
        $var_attempt4 = $var_truefitarray[5];
        $var_attempt5 = $var_truefitarray[6];
        $var_attempt6 = $var_truefitarray[7];
        $var_gridHprodL = $var_truefitarray[8];
        $var_gridHprodW = $var_truefitarray[9];
        $var_gridHprodH = $var_truefitarray[10];
        $var_gridDprodL = $var_truefitarray[11];
        $var_gridDprodW = $var_truefitarray[12];
        $var_gridDprodH = $var_truefitarray[13];
        $var_gridWprodL = $var_truefitarray[14];
        $var_gridWprodW = $var_truefitarray[15];
        $var_gridWprodH = $var_truefitarray[16];

        //call productorient function to determine how to place product in grid to achieve max true fit
        $var_orientarray = _productorient($var_maxtruefit, $var_attempt1, $var_attempt2, $var_attempt3, $var_attempt4, $var_attempt5, $var_attempt6, $var_gridHprodL, $var_gridHprodW, $var_gridHprodH, $var_gridDprodL, $var_gridDprodW, $var_gridDprodH, $var_gridWprodL, $var_gridWprodW, $var_gridWprodH);
        $var_itemheightorient = $var_orientarray[0];
        $var_itemlengthtorient = $var_orientarray[1];
        $var_itemwidthorient = $var_orientarray[2];
//      Logic to calculate true fit
//      Variables from "../PHPLogic/tflogic.php"
        echo 'The true fit for item <b>' . $post_itempicked . '</b> in a <b>' . $post_grid5 . '</b> is <b>' . $var_maxtruefit . '</b> units.';
        echo '<br><br><div class="line-separator"></div>';
        echo "<ul><li> $var_itemheightorient</li>";
        echo "<li> $var_itemlengthtorient</li>";
        echo "<li> $var_itemwidthorient</li></ul>";
    }
}