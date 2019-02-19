<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Move From PFR</title>

        <?php
        include_once '../connections/conn_slotting.php';
        include_once 'sessioninclude.php';
        include_once 'headerincludes.php';
        include_once 'horizontalnav.php';
        include_once 'verticalnav.php';
        ?>


    </head>
    <body style="background-color: #FFFFFF;">
        <div class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
            <h2 style="padding-bottom: 0px;">Move From PFR</h2>




            <div id="tablecontainer" class="col-lg-7">
                <table id="ptbtable" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;">
                    <thead>
                        <tr>
                            <th>Mark as OK</th>
                            <th>Item</th>
                            <th>Pkgu</th>
                            <th>Days Since Sale</th>
                            <th>Avg Days Btw Sale</th>
                            <th>Avg Pick Qty</th>
                            <th>New Max</th>
                            <th>Total Picks</th>
                        </tr>
                    </thead>
                </table>
            </div>



            <!-- Mark as Reviewed Modal -->
            <div id="reviewmodal" class="modal fade " role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Mark as Reviewed</h4>
                        </div>
                        <form class="form-horizontal" id="postreview">
                            <div class="modal-body">
                                <div class="form-group hidden">
                                    <input type="text" name="itemnummodal" id="itemnummodal" class="form-control" tabindex="1" />
                                </div>
                                <div class="form-group hidden">
                                    <input type="text" name="locationmodal" id="locationmodal" class="form-control" tabindex="1" />
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mark item as reviewed: </label>
                                    <div class="col-md-9">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-lg pull-left" name="addreview" id="addreview">Yes!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <script>
                $(document).ready(function () {
                    gettable();
                });

                function gettable() {
                    $('#tablecontainer').addClass('hidden');
                    var userid = $('#userid').text();
                    oTable = $('#ptbtable').dataTable({
                        dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                        destroy: true,
                        "order": [[7, "desc"]],
                        "scrollX": true,
                        "fnCreatedRow": function (nRow, aData, iDataIndex) {
                            $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-check reviewclick' style='cursor: pointer; margin-right: 5px;' data-toggle='tooltip' data-title='Mark as reviewed?' data-placement='top' data-container='body' ></i></div>");
                        },
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
                        'sAjaxSource': "globaldata/data_frompfr.php?userid=" + userid,
                        buttons: [
                            'copyHtml5',
                            'excelHtml5'
                        ]
                    });
                    $('#tablecontainer').removeClass('hidden');

                }


                //Toggle review modal
                $(document).on("click", ".reviewclick", function (e) {
                    $('#reviewmodal').modal('toggle');
                    $('#itemnummodal').val($(this).closest('tr').find('td:eq(1)').text());
                });


                //mark item as reviewed through mysql post
                $(document).on("click", "#addreview", function (event) {
                    event.preventDefault();
                    var itemnum = $('#itemnummodal').val();
                    var userid = $('#userid').text();
                    debugger;
                    var formData = 'itemnum=' + itemnum + '&userid=' + userid;
                    $.ajax({
                        url: 'formpost/postmarkreviewed_frompfr.php',
                        type: 'POST',
                        data: formData,
                        success: function (result) {
                            $('#reviewmodal').modal('hide');
                            gettable();
                        }
                    });

                });


                $("#reports").addClass('active');
                $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            </script>

    </body>
</html>

