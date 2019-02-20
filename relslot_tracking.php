<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    include_once 'connection/connection_details.php';
    ?>
    <head>
        <title>Reslot Tracking</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder" style="margin-top: 75px;"> 

                <div class="row" style="padding-bottom: 30px;"> 
                    <div class="col-xs-12 ">
                        <button style="margin-left: 15px;"class="btn btn-default pull-left"  id="helpbutton_goal" type="button"onclick="showhelpmodal_goal();" style="margin-bottom: 5px;"><i class="fa fa-question-circle"></i> Help</button>
                    </div>
                </div>
                <?php include 'globaldata/reslotprog_headerstats.php'; ?>
                <div id="mastercontainer" class=" hidden"style="" >
                    <section class="panel hidewrapper" id="tbl_historicalscores" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h2">Table - Items Re-Slotted<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_tblitemsonhold"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                        <div id="tbl_itemsonhold" class="panel-body">
                            <div id="tablecontainer" class="">
                                <table id="ptbtable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Re-Slot Date</th>
                                            <th>Yearly Replen Reduction</th>
                                            <th>Yearly Walk Feet Reduction</th>
                                            <th>Reslot Type</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>


            </section>
        </section>

        <!--Modal for Goal Explanation-->
        <div id="container_helpmodal_goal" class="modal fade " role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Re-Slot Tracking FAQ'S</h4>
                    </div>
                    <div class="modal-body" id="" style="margin: 2px 25px 25px 25px;">
                        <h4 style="font-family: calibri">Header Stats FAQ'S</h4>
                        <ul style="font-family: calibri">
                            <li>Total Re-Slots Being Tracked - A count of re-slots asked to be tracked through either email or user request.</li>
                            <li>Yearly Replenishments Decreased - Estimated yearly replenishments reduced (+ number) or increased (- number). </li>
                            <li>Yearly Miles Decreased - Estimated yearly miles reduced (+ number) or increased (- number). </li>
                        </ul>
                        <h4 style="font-family: calibri">Table - Items Re-Slotted</h4>
                        <ul style="font-family: calibri">
                            <li>The table will show the detail for each item asked to be tracked for the current year.</li>
                            <li>The "Yearly Replen Reduction" column indicates the decrease (+) or increase (-) for replenishments estimated for the year.</li>
                            <li>The "Yearly Walk Feet Reduction" column indicates the decrease (+) or increase (-) for walk feet estimated for the year.</li>
                            <li>The "Reslot Type" column indicates the focus for the reslot (WALK, REPLEN, BOTH).</li>
                        </ul>
                        <h4 style="font-family: calibri">Key Calculations</h4>
                        <ul style="font-family: calibri">
                            <li>Replenishment Reduction Calculation</li>
                            <ul>
                                <li>Replens before re-slot: Annualized estimate of replens based on 90 days prior to reslotting the item.</li>
                                <li>Replens after re-slot: Annualized estimate of replens based on 90 days after to reslotting the item.</li>
                                <li>Yearly Replen Reduction/Increase: Difference of replens before re-slot and replens after re-slot.  Positive number indicates replenishment reduction.  Negative number indicates replenishment increase.</li>
                            </ul>
                            <li>Walk Reduction Calculation</li>
                            <ul>
                                <li>Walk distance before re-slot: Annualized estimate of aisle feet walked before relsotting the item.</li>
                                <li>Walk distance after re-slot: Annualized estimate of aisle feet walked after relsotting the item.</li>
                                <li>Yearly Walk Reduction/Increase: Difference of walk distance before re-slot and walk distance after re-slot.  Positive number indicates walk distance reduction.  Negative number indicates walk distance increase.</li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});

            $(document).ready(function () {
                gettable();
            });

            function gettable() {
                $('#mastercontainer').addClass('hidden');

                var userid = $('#userid').text();

                //Empty Locations
                oTable = $('#ptbtable').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "scrollX": true,
                    'sAjaxSource': "globaldata/dt_reslottrack.php?userid=" + userid,
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5'
                    ],
                    "aoColumnDefs": [
                        {
                            "aTargets": [0], // Column to target
                            "mRender": function (data, type, full) {
                                // 'full' is the row's data object, and 'data' is this column's data
                                // e.g. 'full[0]' is the comic id, and 'data' is the comic title
                                return '<a href="itemquery.php?itemnum=' + full[0] + '&userid=' + userid + '" target="_blank">' + data + '</a>';
                            }
                        }
                    ]
                });

                $('#mastercontainer').removeClass('hidden');
            }
            function showhelpmodal_goal() {  //show help modal
                $('#container_helpmodal_goal').modal('toggle');
            }
            $("#reports").addClass('active');
        </script>
    </body>
</html>
