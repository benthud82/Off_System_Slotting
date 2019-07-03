<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    include_once 'connection/connection_details.php';
    ?>
    <head>
        <title>OSS - Case Floor Locations</title>
        <!--        <link href="js/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>-->
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder" style="padding-top: 75px"> 
                <h1>Case Floor Location Errors</h1>

                <!--Add vector button-->
                <div class="row" style="padding: 30px;">
                    <button type="submit" class="btn btn-primary btn-lg pull-left" name="addlocbtn" id="addfloorbtn">Add Floor Location</button>
                </div>

                <!--Case Floor Errors-->
                <div class="col-lg-4 col-md-6">
                    <section class="panel hidewrapper " id="section_floorlocs_err" > 
                        <header class="panel-heading bg bg-danger h2">Table - Case Floor Errors</header>
                        <div id="panel_floorlocs_err" class="panel-body">
                            <table id="tbl_floorlocs_err" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th>Add Location</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </section>
                </div>

                <!--All Floor Loc Data-->
                <div class="col-lg-8 col-md-12">
                    <section class="panel hidewrapper " id="section_floorlocs_all" > 
                        <header class="panel-heading bg bg-inverse h2">Table - All Floor Locations</header>
                        <div id="panel_floorlocs_all" class="panel-body">
                            <table id="tbl_floorlocs_all" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th>Modify Location</th>
                                        <th>Location</th>
                                        <th>Primary?</th>
                                        <th>Floor?</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </section>
                </div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});

            $("#modules").addClass('active');

            oTable2 = $('#tbl_floorlocs_err').DataTable({
                dom: "<'row'<'col-sm-4 pull-left'l>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                destroy: true,
                "scrollX": true,
                'sAjaxSource': "globaldata/casefloorerrors.php",
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-plus-circle clickaddlocation' style='cursor: pointer;' data-toggle='tooltip' data-title='Add Location' data-placement='top' data-container='body'></i></div>");
                },
                buttons: [
                    'copyHtml5',
                    'excelHtml5'
                ]
            });

            oTable3 = $('#tbl_floorlocs_all').DataTable({
                dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                destroy: true,
                "scrollX": true,
                'sAjaxSource': "globaldata/casefloorall.php",
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $('td:eq(0)', nRow).append("<div class='text-center'><i class='fa fa-edit clickmodifylocation' style='cursor: pointer;' data-toggle='tooltip' data-title='Modify Location' data-placement='top' data-container='body'></i></div>");
                },
                buttons: [
                    'copyHtml5',
                    'excelHtml5'
                ]
            });

            //jquery to show modal to add location error
            $(document).on("click", ".clickaddlocation", function (e) {
                $('#addlocationmodal').modal('toggle');
                $('#add_loc').val($(this).closest('tr').find('td:eq(1)').text());
            });

            //jquery to show modal to modify current location
            $(document).on("click", ".clickmodifylocation", function (e) {
                $('#modifylocmodal').modal('toggle');
                $('#mod_loc').val($(this).closest('tr').find('td:eq(1)').text());
                $('#mod_prim').val($(this).closest('tr').find('td:eq(2)').text());
                $('#mod_floor').val($(this).closest('tr').find('td:eq(3)').text());
            });

            //jquery to show modal to add vector map settings
            $(document).on("click", "#addfloorbtn", function (e) {
                $('#addlocationmodal').modal('toggle');
            });

            //post add location
            $(document).on("click", "#submitaddloc", function (event) {
                event.preventDefault();
                var location = $('#add_loc').val();
                var prim = $('#add_prim').val();
                var floor = $('#add_floor').val();
                var formData = 'location=' + location + '&prim=' + prim + '&floor=' + floor;
                $.ajax({
                    url: 'formpost/postfloorlocadd.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $("#postsuccess").html(result);
                        $('#addlocationmodal').modal('hide');
                        $('#tbl_floorlocs_err').DataTable().ajax.reload();
                    }
                });
            });

            //post modify location
            $(document).on("click", "#submitmodloc", function (event) {
                event.preventDefault();
                var location = $('#mod_loc').val();
                var prim = $('#mod_prim').val();
                var floor = $('#mod_floor').val();
                var formData = 'location=' + location + '&prim=' + prim + '&floor=' + floor;
                $.ajax({
                    url: 'formpost/postfloorlocmod.php',
                    type: 'POST',
                    data: formData,
                    success: function (result) {
                        $("#postsuccess").html(result);
                        $('#modifylocmodal').modal('hide');
                        $('#tbl_floorlocs_all').DataTable().ajax.reload();
                    }
                });
            });



            $('.modal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        </script>

        <!-- Modify Location Floor -->
        <div id="modifylocmodal" class="modal fade " role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modify Floor Location Data</h4>
                    </div>
                    <form class="form-horizontal" id="postmodifylocation">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Location</label>
                                <div class="col-sm-3">
                                    <input type="text" name="mod_loc" id="mod_loc" class="form-control" placeholder="" tabindex="1" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Primary?</label>
                                <div class="col-sm-3">
                                    <select class="" id="mod_prim" name="mod_prim" style="width: 175px;padding: 5px; margin-right: 10px;">
                                        <option value="Y">YES</option>
                                        <option value="N">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Floor?</label>
                                <div class="col-sm-3">
                                    <select class="" id="mod_floor" name="mod_floor" style="width: 175px;padding: 5px; margin-right: 10px;">
                                        <option value="Y">YES</option>
                                        <option value="N">NO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="">
                                <button type="submit" class="btn btn-primary btn-lg pull-left" name="submitaddloc" id="submitmodloc">Modify Floor Location</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Location Floor-->
        <div id="addlocationmodal" class="modal fade " role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Floor Location Data</h4>
                    </div>
                    <form class="form-horizontal" id="postaddlocation">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Location</label>
                                <div class="col-sm-3">
                                    <input type="text" name="add_loc" id="add_loc" class="form-control" placeholder="" tabindex="1" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Primary?</label>
                                <div class="col-sm-3">
                                    <select class="" id="add_prim" name="add_prim" style="width: 175px;padding: 5px; margin-right: 10px;">
                                        <option value="P">YES</option>
                                        <option value=" ">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Floor?</label>
                                <div class="col-sm-3">
                                    <select class="" id="add_floor" name="add_floor" style="width: 175px;padding: 5px; margin-right: 10px;">
                                        <option value="Y">YES</option>
                                        <option value="N">NO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="">
                                <button type="submit" class="btn btn-primary btn-lg pull-left" name="submitaddloc" id="submitaddloc">Add Floor Location</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--modal to show if post was a success-->
        <div id="postsuccess"></div>

    </body>
</html>
