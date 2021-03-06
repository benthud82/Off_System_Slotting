<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    include_once 'connection/connection_details.php';
    include_once '../globalfunctions/slottingfunctions.php';
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


    $datesqlall = $conn1->prepare("SELECT DISTINCT
                                        DATE as dates
                                    FROM
                                        printvis.pm_traveldata
                                    WHERE
                                        WHSE = $var_whse
                                    ORDER BY DATE;");
    $datesqlall->execute();
    $datesqlallarray = $datesqlall->fetchAll(pdo::FETCH_ASSOC);
    $ids = array_column($datesqlallarray, 'dates');
    $includedates = '["' . implode('" , "', $ids) . '"]';


    $datesql = $conn1->prepare("SELECT 
                                    max(DATE) as recentdate
                                FROM
                                    printvis.pm_traveldata
                                WHERE
                                    WHSE = $var_whse;");
    $datesql->execute();
    $datesqlarary = $datesql->fetchAll(pdo::FETCH_ASSOC);
    $today = $datesqlarary[0]['recentdate'];
    ?>
    <head>
        <title>OSS - Actual Walk Distance</title>
        <link href="../jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>
        <?php include_once 'headerincludes.php'; ?>
<!--        <style>table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting {
                padding-right: 20px; padding-left: 2px; padding-top: 2px; padding-bottom: 2px}
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 2px; }
            td>a{text-decoration: underline;}
        </style>-->

    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 
                <div class="row" style="padding-bottom: 25px; padding-top: 75px;"> 

                    <div class="col-md-3 col-xl-2" style="">
                        <div class="form-group">
                            <label>Start Date:</label>
                            <input name="startfiscal" id="startfiscal" class="selectstyle" style="cursor: pointer; max-width: 120px;" value="<?php echo date("m/d/Y", strtotime($today)); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-2" style="">
                        <div class="form-group">
                            <label>End Date:</label>
                            <input name="endfiscal" id="endfiscal" class="selectstyle" style="cursor: pointer; max-width: 120px;" value="<?php echo date("m/d/Y", strtotime($today)); ?>"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 col-lg-2 col-xl-2 text-center">
                        <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();">Load Data</button>
                    </div>
                </div>

                <div id="tablecontainer" class="hidden">
                    <h2>Actual Feet Per Pick (FPP)</h2>
                    <table id="ptbtable" class="table table-striped table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cart FPP</th>
                                <th>Aisle FPP</th>
                                <th>Total FPP</th>
                            </tr>
                        </thead>
                    </table>
                </div>


            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});


            function gettable(startdatefromurl, enddatefromurl) {
                $('#tablecontainer').addClass('hidden');

                if (typeof startdatefromurl !== 'undefined') {
                    var startdate = startdatefromurl;
                    var enddate = enddatefromurl;
                    var userid = $('#userid').text();
                } else {
                    var userid = $('#userid').text();
                    var startdate = $('#startfiscal').val();
                    var enddate = $('#endfiscal').val();
                }



                oTable = $('#ptbtable').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "scrollX": true,
                    "order": [[0, "asc"]],
                    "aoColumnDefs": [
                        {
                            "aTargets": [0], // Column to target
                            "mRender": function (data, type, full) {
                                // 'full' is the row's data object, and 'data' is this column's data
                                // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                                return '<span class="bayclick" style="cursor: pointer;">' + data + '</span>';  //add class of bay click to toggle modal with actual pick detail for clicked bay
                            }
                        }
                    ],
                    'sAjaxSource': "globaldata/actualwalkdata.php?userid=" + userid + "&startdate=" + startdate + "&enddate=" + enddate,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]
                });
                $('#tablecontainer').removeClass('hidden');
                if (typeof startdatefromurl !== 'undefined') {
                    filldatevalue(startdatefromurl, enddatefromurl);  //file the item input field
                    cleanurl();  //clean the URL of post data
                }
            }
        </script>

        <script>
            $("#reports").addClass('active');

            //datepicker initialization and function to only show available dates from mysql table
            var availableDates = <?php echo $includedates; ?>;
            function available(date) {
                ymd = date.getFullYear() + "-" + ('0' + (date.getMonth() + 1)).slice(-2) + "-" + ('0' + date.getDate()).slice(-2);
                if ($.inArray(ymd, availableDates) !== -1) {
                    return [true, "", "Available"];
                } else {
                    return [false, "", "Not Available"];
                }
            }
            $('#startfiscal').datepicker({beforeShowDay: available});
            $('#endfiscal').datepicker({beforeShowDay: available});


            $(document).on("click touchstart", ".bayclick", function (e) {
                $('#itemactioncompletemodal').modal('toggle');
                $('#itemdetailcontainerloading').toggleClass('hidden');
                $('#divtablecontainer').addClass('hidden');
                var baycode = $(this).text();
                var userid = $('#userid').text();
                var datesel = $('#startfiscal').val();
                debugger;
                $.ajax({
                    url: 'globaldata/pickdetaildatabybay.php',
                    data: {baycode: baycode, userid: userid, datesel: datesel},
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $('#itemdetailcontainerloading').toggleClass('hidden');
                        $('#divtablecontainer').removeClass('hidden');
                        $("#pickdetaildata").html(ajaxresult);
                    }
                });
            });

            //is date in url to auto load data
            $(document).ready(function () {
                if (window.location.href.indexOf("date") > -1) {
                    debugger;
                    //Place this in the document ready function to determine if there is search variables in the URL.  
                    //Must clean the URL after load to prevent looping
                    var startdatefromurl = GetUrlValue('date');
                    var enddatefromurl = GetUrlValue('date');

                    gettable(startdatefromurl, enddatefromurl);  //pass the 
                }
            });


            function GetUrlValue(VarSearch) {  //parse URL to pull variable defined
                debugger;
                var SearchString = window.location.search.substring(1);
                var VariableArray = SearchString.split('&');
                for (var i = 0; i < VariableArray.length; i++) {
                    var KeyValuePair = VariableArray[i].split('=');
                    if (KeyValuePair[0] === VarSearch) {
                        return KeyValuePair[1];
                    }
                }
            }

            function cleanurl() { //clean the URL if called from another page
                var clean_uri = location.protocol + "//" + location.host + location.pathname;
                window.history.replaceState({}, document.title, clean_uri);
            }

            function filldatevalue(startdatefromurl, enddatefromurl) {  //fill item input text
                document.getElementById("startfiscal").value = startdatefromurl;
                document.getElementById("endfiscal").value = enddatefromurl;
            }

        </script>
    </body>
</html>
