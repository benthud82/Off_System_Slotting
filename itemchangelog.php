<!DOCTYPE html>

<html>

    <head>
        <title>Change Log</title>
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
    </head>

    <body style="background-color: #FFFFFF;">
        <!--Main Content-->

        <div class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
            <h2 style="padding-bottom: 0px;">Item Characteristic Change Log</h2>
            <form method="GET">
                <select name="whse" class="selectstyle" style="min-width: 150px">
                    <option value="0">Choose Whse...</option>
                    <option value="2">Indy</option>
                    <option value="3">Sparks</option>
                    <option value="6">Denver</option>
                    <option value="7">Dallas</option>
                    <option value="9">Jacksonville</option>
                </select>

                <input id="datepicker" type="text" name="datepicker" class="selectstyle">
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
                    
                        $("#reports").addClass('active');
                </script>
                <input type="submit" name="formSubmit" value="Submit" />
            </form>    
            <?php

            function _validateDate($date) {
                $d = createFromFormat2('Y-m-d', $date);
                return $d && $d->format('Y-m-d') == $date;
            }

            if (isset($_GET['formSubmit'])) {
                $var_whse = intval($_GET['whse']);
                if ($var_whse == 0) {
                    print '<script type="text/javascript">';
                    print 'alert("Please choose a warehouse.")';
                    print '</script>';
                    die;
                }
                $var_datepick = $_GET['datepicker'];
                $date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';


                if (!preg_match($date_regex, $var_datepick)) {
                    print '<script type="text/javascript">';
                    print 'alert("The date ' . $var_datepick . ' is not a valid date.  Please try again.")';
                    print '</script>';
                    die;
                }
            } else {
                die;
            }
            ?>
            <br>
            <div class="line-separator"></div> <br>

            <div class="print">


                <div id="tablecontainer" class="">
                    <table id="ptbtable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                        <thead>
                            <tr>
                                <th style='min-width: 75px;'>Whse</th>
                                <th style='min-width: 75px;'>Item</th>
                                <th style='min-width: 75px;'>Field Chg.</th>
                                <th style='min-width: 75px;'>Before Value</th>
                                <th style='min-width: 75px;'>After Value</th>
                                <th style='min-width: 75px;'>TSM</th>
                                <th style='min-width: 75px;'>Date</th>
                                <th style='min-width: 75px;'>Location</th>
                                <th style='min-width: 75px;'>Perc Change</th>
                            </tr>
                        </thead>


                    </table>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    oTable = $('#ptbtable').dataTable({
                        'sAjaxSource': "../globaldata/dimensionchange.php?whse=<?php echo $var_whse; ?>&datepicker=<?php echo $var_datepick; ?>",
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
            </script>
        </div>
    </body>
</html>

