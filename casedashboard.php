<!DOCTYPE html>
<html>

    <head>
        <title>Case Pick Dashboard</title>
        <?php
        include_once 'headerincludes.php';
        include_once 'connection/connection_details.php';
        include 'sessioninclude.php';
        ?>

    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder" style="padding-top: 75px;"> 

                <!--Picking Equipment Analysis-->
                <div class="col-sm-12">

                    <!--datatable for equipment by day-->
                    <section class="panel hidewrapper " id="section_dt_equipment" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h2">Picks by Equipment</header>
                        <div id="tablepanel_dt_equipment" class="panel-body" style="background: #efefef">
                            <div id="tablecontainer_dt_equipment" class="col-sm-12 ">
                                <table id="table_dt_equipment" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;  background-color:  white;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Current OP Picks</th>
                                            <th>Suggested OP Picks</th>
                                            <th>Current PTB Picks</th>
                                            <th>Suggested PTB Picks</th>
                                            <th>Current PJ Picks</th>
                                            <th>Suggested PJ Picks</th>
                                            <th>Potential Hours Reduced</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#help").addClass('active');

            oTable = $('#table_dt_equipment').dataTable({
                dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                destroy: true,
                "order": [[0, "desc"]],
                "scrollX": true,
                "aoColumnDefs": [
                    {"sClass": "lightgray", "aTargets": [1,2,5,6]}
                ],

                'sAjaxSource': "globaldata/casedash_equipmentpicks.php",
                buttons: [
                    'copyHtml5',
                    'excelHtml5'
                ]
            });
        </script>

    </body>
</html>


