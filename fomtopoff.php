<!DOCTYPE html>

<html>
    <head>
        <title>FOM Topoff</title>

        <?php
        include_once '../connections/conn_slotting.php';
        include_once 'sessioninclude.php';
        include_once 'headerincludes.php';
        include_once 'horizontalnav.php';
        include_once 'verticalnav.php';
        ?>

        <script>
            $("#reports").addClass('active');

        </script>
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




        <script>
            function showloaddata() {
                var hidnum = "0";
                var tiersel = $('#tier').val();
                var mcsel = $('#mc').val();
                if (tiersel === hidnum || mcsel === hidnum) {
                    $('#loaddata').hide();
                } else {
                    $('#loaddata').show();
                }
            }
        </script>


    </head>
    <body style="background-color: #FFFFFF;">
        <!--Main Content-->

        <div class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
            <h2 style="padding-bottom: 0px;">FOM Topoff Report</h2>


            <select class="selectstyle" id="tier" name="tier" onchange="showloaddata();" style="min-width: 150px; ">
                <option value=0>Choose Tier...</option>
                <option value="L02">L02 - Flow Rack</option>
                <option value="L04">L04 - Blue Bins</option>
                <option value="C01">C01 - Bulk Pallet</option>
                <option value="C02">C02 - Pick to Belt</option>
                <option value="C%">All Case</option>
            </select>
            <select class="selectstyle" id="mc" name="mc" onchange="showloaddata();" style="min-width: 150px; ">
                <option value=0>Choose MC...</option>
                <option value="A">A Movers</option>
                <option value="B">B Movers</option>
                <option value="C">C Movers</option>
                <option value="D">D Movers</option>
            </select>
            <input id="loaddata" type='submit' value='Load Data' class="submitdata" onclick="gettable();" />


            <div id="tablecontainer" class="">
                <table id="ptbtable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                    <thead>
                        <tr>
                            <th>Whse</th>
                            <th>Item</th>
                            <th>Location</th>
                            <th>Pkgu</th>
                            <th>On Hand</th>
                            <th>Loc Min</th>
                            <th>Loc Max</th>
                            <th>Tier</th>
                            <th>Grid 5</th>
                            <th>Reserve OH</th>
                            <th>Item MC</th>
                            <th>Avg Demand</th>
                            <th>High Demand</th>
                            <th>Move Type</th>
                            <th>Prob of Stockout</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <script>
                function gettable() {
                    $('.print').show();
                    var tiersel = $('#tier').val();
                    var mcsel = $('#mc').val();
                    var userid = $('#userid').text();
                    oTable = $('#ptbtable').dataTable({
                        dom: "<'row'<'col-sm-4 pull-left'B><'col-sm-4 text-center'><'col-sm-4 pull-right'>>" + "<'row'<'col-sm-12't>>" + "<'row'<'col-sm-4 pull-left'><'col-sm-8 pull-right'>>",
                        destroy: true,
                        "scrollX": true,
                        'sAjaxSource': "globaldata/data_fomtopoff.php?tier=" + tiersel + "&mc=" + mcsel + "&userid=" + userid,
                        "iDisplayLength": -1,
                        "order": [[13, "desc"]],
                        "aaSorting": [],
                        buttons: [
                            'copyHtml5',
                            'excelHtml5'
                        ]
                    });

                }
            </script>


            <script>
                $('#loaddata').hide();
                $('.print').hide();
            </script>
        </div>
    </body>
</html>

