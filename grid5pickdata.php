<?php
$whspicked = intval($_GET['whspicked']);
$USAarray = array(2, 3, 6, 7, 9);
$CANarray = array(11, 12, 16);

if (in_array($whspicked, $USAarray)) {
    //START of USA Grid5 pick data
    $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
    $pdo_username = "BHUD01";
    $pdo_password = "5glacier5";
    $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

    $resultgrids = $aseriesconn->prepare("SELECT case when LMDEEP <> 24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMVOL9, count(LMCOMP) FROM A.HSIPCORDTA.NPFLSM WHERE LMTIER = 'L04' and LMWHSE = $whspicked GROUP BY case when LMDEEP <> 24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end, LMVOL9 HAVING count(LMCOMP) >= 50 ORDER BY LMVOL9 asc");
    $resultgrids->execute();
    $resultgridsarray = $resultgrids->fetchAll(PDO::FETCH_NUM);
    ?>


    <select id='grid5select' class = 'tfcalcgridselect' style="float: left; margin-right: 10px;" onchange="show('iteminput', true)">
        <option value ="">Choose Grid5...</option>
        <?php
        foreach ($resultgridsarray as $key => $value):
            echo '<option value = "' . $value[0] . '">' . $value[0] . '</option>';
        endforeach;
        ?>
</select>
<?php
}else{
    //START of Canada Grid5 pick data
    $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
    $pdo_username = "BHUDS1";
    $pdo_password = "tucker1234";
    $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

    $resultgrids = $aseriesconn->prepare("SELECT case when LMDEEP <> 24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end as LMGRD5, LMVOL9, count(LMCOMP) FROM A.ARCPCORDTA.NPFLSM WHERE LMTIER = 'L04' and LMWHSE = $whspicked GROUP BY case when LMDEEP <> 24 then LMGRD5||'Sub'||LMDEEP else LMGRD5 end, LMVOL9 HAVING count(LMCOMP) >= 25 ORDER BY LMVOL9 asc");
    $resultgrids->execute();
    $resultgridsarray = $resultgrids->fetchAll(PDO::FETCH_NUM);
    ?>


    <select id='grid5select' class = 'tfcalcgridselect' style="float: left; margin-right: 10px;" onchange="show('iteminput', true)">
        <option value ="">Choose Grid5...</option>
        <?php
        foreach ($resultgridsarray as $key => $value):
            echo '<option value = "' . $value[0] . '">' . $value[0] . '</option>';
        endforeach;
       
echo "</select>";

}




