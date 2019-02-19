<!DOCTYPE html>

<html>

    <head>
        <title>Change Log PFR Settings</title>
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
        <!--<script src="../jquery.dataTables.js" type="text/javascript"></script>-->
        <!--<script src="../dataTables.columnFilter.js" type="text/javascript"></script>-->
        <!--<script src="../TableTools.min.js" type="text/javascript"></script>-->
        <!--<link rel="stylesheet" href="../demo_table_jui.css" type="text/css">-->
        <!--<link rel="stylesheet" href="../demo_page.css" type="text/css">-->
        <link rel="stylesheet" href="../jquery-ui.css" type="text/css">
        <!--<link rel="stylesheet" href="../jquery.dataTables_themeroller.css" type="text/css">-->
        <!--<script src="../jquery.blockUI.js"></script>-->
        <!--<script src="../jquery-ui.js"></script>-->
        <!--<link rel="shortcut icon" type="image/ico" href="../favicon.ico" />-->  

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

    </head>

    <body style="background-color: #FFFFFF;">
        <div class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
            <?php
            include_once("../globalfunctions/slottingfunctions.php");
            ?>

            <h2 style="padding-bottom: 0px;">Item PFR Change Log</h2>
            <form method="GET">
                <select name="whse" class="selectstyle" style="min-width: 150px;">
                    <option value="0">Choose Whse...</option>
                    <option value="2">Indy</option>
                    <option value="3">Sparks</option>
                    <option value="6">Denver</option>
                    <option value="7">Dallas</option>
                    <option value="9">Jacksonville</option>
                </select>

                <input id="datepicker" type="text" name="datepicker" class="selectstyle" >
                <script>
                    /*
                     * jQuery UI Datepicker: Parse and Format Dates
                     * http://salman-w.blogspot.com/2013/01/jquery-ui-datepicker-examples.html
                     */
                    $(function () {
                        $("#datepicker").datepicker({
                            dateFormat: "yy-mm-dd"
                        });
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
                            <th style='min-width: 75px;'>Field Changed</th>
                            <th style='min-width: 75px;'>Before Value</th>
                            <th style='min-width: 75px;'>After Value</th>
                            <th style='min-width: 75px;'>TSM</th>
                            <th style='min-width: 75px;'>Date</th>
                            <!--<th style='min-width: 75px;'>Location</th>-->

                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        ini_set('max_execution_time', 99999);

//                        $server = "Driver={Client Access ODBC Driver (32-bit)};System=A;Uid=user;Pwd=password;"; #the name of the iSeries
//                        $user = "BHUD01"; #a valid username that will connect to the DB
//                        $pass = "tucker1234"; #a password for the username
//
//                        $conn = odbc_connect($server, $user, $pass); #you may have to remove quotes
//                        if (!$conn) {
//                            print db2_conn_errormsg();
//                        }
//                        #Query the Database into a result set - 
//                        $result = odbc_exec($conn, "SELECT ATWHSE as Whse,  ATITEM as Item, ATFNAM as Field, ATBVAL as before, ATAVAL as after, ATCHGU as TSM, date('20' || substr(ATCHGD,2,2) || '-' || substr(ATCHGD,4,2) || '-' || substr(ATCHGD,6,2)) as Date FROM A.HSIPCORDTA.NPFCAT WHERE ATFNAM in ('PCPFRC', 'PCPFRA') and ATAVAL in ('Z', 'N')  and date('20' || substr(ATCHGD,2,2) || '-' || substr(ATCHGD,4,2) || '-' || substr(ATCHGD,6,2)) = '" . $var_datepick . "'");
//
//                        while (odbc_fetch_row($result)) {


                        $pdo_dsn = "odbc:DRIVER={iSeries Access ODBC DRIVER};SYSTEM=A";
                        $pdo_username = "BHUD01";
                        $pdo_password = "tucker1234";
                        $aseriesconn = new PDO($pdo_dsn, $pdo_username, $pdo_password, array());

#Query the Database into a result set - 
                        $result = $aseriesconn->prepare("SELECT ATWHSE as Whse,  ATITEM as Item, ATFNAM as Field, ATBVAL as before, ATAVAL as after, ATCHGU as TSM, date('20' || substr(ATCHGD,2,2) || '-' || substr(ATCHGD,4,2) || '-' || substr(ATCHGD,6,2)) as Date FROM A.HSIPCORDTA.NPFCAT WHERE ATFNAM in ('PCPFRC', 'PCPFRA') and ATAVAL in ('Z', 'N')  and date('20' || substr(ATCHGD,2,2) || '-' || substr(ATCHGD,4,2) || '-' || substr(ATCHGD,6,2)) = '" . $var_datepick . "'");
                        $result->execute();
                        $resultsetarray = $result->fetchAll(PDO::FETCH_NUM);

                        foreach ($resultsetarray as $key => $value) {






                            $var_ATWHSE = $resultsetarray[$key][0];
                            $var_ATITEM = $resultsetarray[$key][1];
                            $var_ATFNAM = $resultsetarray[$key][2];
                            $var_ATBVAL = $resultsetarray[$key][3];
                            $var_ATAVAL = $resultsetarray[$key][4];
                            $var_ATCHGU =  $resultsetarray[$key][5];
                            $var_Date = $resultsetarray[$key][6];


                            echo "<tr><td>$var_ATWHSE</td>";
                            echo "<td>$var_ATITEM</td>";
                            echo "<td>$var_ATFNAM</td>";
                            echo "<td>$var_ATBVAL</td>";
                            echo "<td>$var_ATAVAL</td>";
                            echo "<td>$var_ATCHGU</td>";
                            echo "<td>$var_Date</td>";
//                    echo "<td>$var_LOLOC</td></tr>";
                        }
                        echo "</tbody>"
                        ?>
                </table>
            </div>
        </div>
    </body>
</html>

<?php


