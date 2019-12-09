<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    include_once 'connection/connection_details.php';
    ?>
    <head>
        <title>Case Pick Slotting Reports</title>
        <?php include_once 'headerincludes.php'; ?>
        <style>table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting {
                padding-right: 20px; padding-left: 2px; padding-top: 2px; padding-bottom: 2px}
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 2px; }
            td>a{text-decoration: underline;}
        </style>

    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 
                <div class="row" style="padding-bottom: 25px; padding-top: 75px;"> 
                    <div class="pull-left  col-lg-2">
                        <label>Select Tier:</label>
                        <select class="selectstyle" id="tiersel" name="tiersel" style="width: 100px;padding: 5px; margin-right: 10px;"onchange="getgrid5data(this.value);">
                            <option value="DECK">DECK</option>
                            <!--<option value="PALLET">PALLET</option>-->
                            <!--<option value="PFR">PFR</option>-->
                        </select>

                    </div>
                    <div class="pull-left  col-lg-2" >
                        <label>Report Type:</label>
                        <select class="selectstyle" id="reportsel" name="reportsel" style="width: 120px;padding: 5px; margin-right: 10px;">
                            <option value="MOVEIN">Move In</option>
                            <option value="MOVEOUT">Move Out</option>
                        </select>
                    </div>
                    <div class="col-lg-2" >
                        <button id="loaddata" type="button" class="btn btn-primary" onclick="gettable();" style="margin-bottom: 5px;">Load Data</button>
                    </div>
                </div>

                <div id="tablecontainer" class="hidden">
                    <table id="ptbtable" class="table table-striped table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                        <thead>
                            <tr>
                                <th>Whse</th>
                                <th>Item</th>
                                <th>Loc</th>
                                <th>DSLS</th>
                                <th>ADBS</th>
                                <th>Cur Grid5</th>
                                <th>Cur Depth</th>
                                <th>Sug Grid5</th>
                                <th>Sug Depth</th>
                                <th>Curr Tier</th>
                                <th>Sug Tier</th>
                                <th>Sug Level</th>
                                <th>Sug Max</th>
                                <th>Sug Min</th>
                                <th>Imp. Replen</th>
                                <th>Cur Replen</th>
                                <th>Dly Pick</th>
                                <th>Dly Unit</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <!--Include acutal move modal-->
                <?php include_once 'globaldata/actualmovemodal.php'; ?>
                <?php include_once 'globaldata/actualpickmodal.php'; ?>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});

            $(document).on("click touchstart", ".moveauditclick", function (e) {
                $('#actualmovemodal').modal('toggle');
                $('#itemdetailcontainerloading').toggleClass('hidden');
                $('#divtablecontainer').addClass('hidden');
                var lseorcse = 'moveauditclicklse';
                var itemcode = $(this).closest('tr').find('td:eq(1)').text();

                var userid = $('#userid').text();
                debugger;
                $.ajax({
                    url: 'globaldata/moveaudithistory.php',
                    data: {itemcode: itemcode, userid: userid, lseorcse: lseorcse},
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $('#itemdetailcontainerloading').toggleClass('hidden');
                        $('#divtablecontainer').removeClass('hidden');
                        $("#movedetaildata").html(ajaxresult);
                    }
                });
            });

            $(document).on("click touchstart", ".pickauditclick", function (e) {
                $('#actualpickmodal').modal('toggle');
                $('#itemdetailcontainerloading_pick').toggleClass('hidden');
                $('#divtablecontainer_pick').addClass('hidden');
                var lseorcse = 'pickauditclicklse';
                var itemcode = $(this).closest('tr').find('td:eq(1)').text();

                var userid = $('#userid').text();
                debugger;
                $.ajax({
                    url: 'globaldata/pickaudithistory.php',
                    data: {itemcode: itemcode, userid: userid, lseorcse: lseorcse},
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $('#itemdetailcontainerloading_pick').toggleClass('hidden');
                        $('#divtablecontainer_pick').removeClass('hidden');
                        $("#pickdetaildata").html(ajaxresult);
                    }
                });
            });

            function gettable() {
                $('#tablecontainer').addClass('hidden');
                var userid = $('#userid').text();
                var reportsel = $('#reportsel').val();
                var tiersel = $('#tiersel').val();

                oTable = $('#ptbtable').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "scrollX": true,
                    "aoColumnDefs": [
                        {
                            "aTargets": [1], // Column to target
                            "mRender": function (data, type, full) {
                                // 'full' is the row's data object, and 'data' is this column's data
                                // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                                return '<a href="itemquery.php?itemnum=' + full[1] + '&userid=' + userid + '" target="_blank">' + data + '</a>';
                            }
                        }
                    ],
//                    "rowCallback": function (row, data, index) {
//                        $('td:eq(13)', row).addClass("moveauditclick");
//                        $('td:eq(14)', row).addClass("pickauditclick");
//                    },
                    'sAjaxSource': "globaldata/casereport.php?userid=" + userid + "&reportsel=" + reportsel + "&tiersel=" + tiersel,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ]
                });
                $('#tablecontainer').removeClass('hidden');

            }
        </script>

        <script>
            $("#case").addClass('active');

        </script>
    </body>
</html>
