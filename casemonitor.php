<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    include_once 'connection/connection_details.php';
    ?>
    <head>
        <title>Case Pick Auditor</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>

    <body style="">
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>


        <section id="content"> 
            <section class="main padder"> 
                <div class="row" style="padding-top: 75px;">
                    <!--Full pallet capacity-->
                    <div class="col-sm-6 col-md-4 col-lg-2"> 
                        <section id="panel_fullpallcap"class="panel text-center" onclick="_fullpalletcap();"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Full Pallet <br>Capacity</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_fullpallcap" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                    <!--Deck capacity-->
                    <div class="col-sm-6 col-md-4 col-lg-2"> 
                        <section id="panel_deckcap"class="panel text-center" onclick="_deckcap();"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Deck<br>Capacity</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_deckcap" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                    <!--Pallet Pkgu opp-->
                    <div class="col-sm-6 col-md-4 col-lg-2"> 
                        <section id="panel_palletopp"class="panel text-center" onclick="_pallpkgu();"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Pallet Pkgu<br>Opportunity</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_palletopp" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                    <!--Move to NC tier-->
                    <div class="col-sm-6 col-md-4 col-lg-2"> 
                        <section id="panel_nc_movein"class="panel text-center" onclick="_tononcon();"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Move to<br>Noncon Tier</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_nc_movein" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                    <!--Move out NC tier-->
                    <div class="col-sm-6 col-md-4 col-lg-2"> 
                        <section id="panel_nc_moveout"class="panel text-center" onclick="_fromnoncon();"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Move out of<br>Noncon Tier</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_nc_moveout" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                    <!--Case Floor Errors-->
                    <div class="col-sm-6 col-md-4 col-lg-2"> 
                        <section id="panel_floorerr_head"class="panel text-center" onclick="_floorerr();"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Case Floor<br>Errors</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_floorerr" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                </div>
                <div class="row" style="margin-top: 75px">

                    <!--All datatables-->
                    <div class="col-sm-12">

                        <!--datatable for full pallet capacity-->
                        <section class="panel hidewrapper hidden" id="section_fullpalletcap" style="margin-bottom: 50px; margin-top: 20px;"> 
                            <header class="panel-heading bg bg-inverse h2">Tier C03 (Standard Full Pallet) Location Listing</header>
                            <div id="tablepanel_fullpallet" class="panel-body" style="background: #efefef">
                                <div id="tablecontainer_fullpalletcap" class="col-sm-12 ">
                                    <table id="table_fullpallcap" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;  background-color:  white;">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Item</th>
                                                <th>Grid5</th>
                                                <th>Loc. Height</th>
                                                <th>Loc. Depth</th>
                                                <th>Loc. Width</th>
                                                <th>Loc. Volume</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!--datatable for deck capacity-->
                        <section class="panel hidewrapper hidden" id="section_deckcap" style="margin-bottom: 50px; margin-top: 20px;"> 
                            <header class="panel-heading bg bg-inverse h2">Tier C06 (Standard Deck) Location Listing</header>
                            <div id="tablepanel_deckcap" class="panel-body" style="background: #efefef">
                                <div id="tablecontainer_deckcap" class="col-sm-12 ">
                                    <table id="table_deckcap" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;  background-color:  white;">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Item</th>
                                                <th>Grid5</th>
                                                <th>Loc. Height</th>
                                                <th>Loc. Depth</th>
                                                <th>Loc. Width</th>
                                                <th>Loc. Volume</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!--datatable for pallet pkgu-->
                        <section class="panel hidewrapper hidden" id="section_pallpkgu" style="margin-bottom: 50px; margin-top: 20px;"> 
                            <header class="panel-heading bg bg-inverse h2">Pallet Package Units Missing</header>
                            <div id="tablepanel_pallpkgu" class="panel-body" style="background: #efefef">
                                <div id="tablecontainer_pallpkgu" class="col-sm-12 ">
                                    <table id="table_pallpkgu" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;  background-color:  white;">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Case Pkgu</th>
                                                <th>Location</th>
                                                <th>DSLS</th>
                                                <th>ADBS</th>
                                                <th>Avg. Inv.</th>
                                                <th>Daily Pick Avg.</th>
                                                <th>Daily Unit Avg.</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!--datatable for move TO noncon-->
                        <section class="panel hidewrapper hidden" id="section_tononcon" style="margin-bottom: 50px; margin-top: 20px;"> 
                            <header class="panel-heading bg bg-inverse h2">Move Items TO Noncon Tier</header>
                            <div id="tablepanel_tononcon" class="panel-body" style="background: #efefef">
                                <div id="tablecontainer_tononcon" class="col-sm-12 ">
                                    <table id="table_tononcon" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;  background-color:  white;">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Location</th>
                                                <th>Current Tier</th>
                                                <th>Case Pkgu</th>
                                                <th>Case Length</th>
                                                <th>Case Height</th>
                                                <th>Case Width</th>
                                                <th>Case Weight</th>
                                                <th>Conveyable Flag</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!--datatable for move FROM noncon-->
                        <section class="panel hidewrapper hidden" id="section_fromnoncon" style="margin-bottom: 50px; margin-top: 20px;"> 
                            <header class="panel-heading bg bg-inverse h2">Move Items FROM Noncon Tier</header>
                            <div id="tablepanel_fromnoncon" class="panel-body" style="background: #efefef">
                                <div id="tablecontainer_fromnoncon" class="col-sm-12 ">
                                    <table id="table_fromnoncon" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri;  background-color:  white;">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Location</th>
                                                <th>Current Tier</th>
                                                <th>Case Pkgu</th>
                                                <th>Case Length</th>
                                                <th>Case Height</th>
                                                <th>Case Width</th>
                                                <th>Case Weight</th>
                                                <th>Conveyable Flag</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <!--datatable for floor errors-->
                        <section id="allfloorerr" class="hidden">
                            <div class="col-lg-4 col-md-6">
                                <section class="panel hidewrapper " id="section_floorerr" > 
                                    <header class="panel-heading bg bg-danger h2">Table - Case Floor Errors</header>
                                    <div id="panel_floorerr" class="panel-body">
                                        <table id="tbl_floorerr" class="table table-bordered" cellspacing="0" style="font-size: 11px; font-family: Calibri; cursor: pointer;">
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
                    </div>

                </div>
            </section>
        </section>

        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $(document).ready(function () {
                var userid = $('#userid').text();
                //ajax for full pallet cap
                $.ajax({
                    url: 'globaldata/result_fullpallcap.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#result_fullpallcap").html(ajaxresult);
                    }
                });

                //ajax for deckcap
                $.ajax({
                    url: 'globaldata/result_deckcap.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#result_deckcap").html(ajaxresult);
                    }
                });

                //ajax for pallet pkgu opp
                $.ajax({
                    url: 'globaldata/result_palletopp.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#result_palletopp").html(ajaxresult);
                    }
                });

                //ajax for move to noncon tier
                $.ajax({
                    url: 'globaldata/result_nc_movein.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#result_nc_movein").html(ajaxresult);
                    }
                });

                //ajax for move to noncon tier
                $.ajax({
                    url: 'globaldata/result_nc_moveout.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#result_nc_moveout").html(ajaxresult);
                    }
                });

                //ajax for move to floor errors
                $.ajax({
                    url: 'globaldata/result_floorerr.php', //url for the ajax.  Variable numtype is either salesplan, billto, shipto
                    data: {userid: userid}, //pass salesplan, billto, shipto all through billto
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#result_floorerr").html(ajaxresult);
                    }
                });
            });
            $("#modules").addClass('active');

            function _fullpalletcap() {
                $('#section_fullpalletcap').removeClass('hidden');
                $('#section_deckcap').addClass('hidden');
                $('#section_pallpkgu').addClass('hidden');
                $('#section_tononcon').addClass('hidden');
                $('#section_fromnoncon').addClass('hidden');
                $('#allfloorerr').addClass('hidden');
                oTable = $('#table_fullpallcap').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[0, "asc"]],
                    "scrollX": true,

                    'sAjaxSource': "globaldata/casemonitor_fullpallcap.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
            }

            function _deckcap() {
                $('#section_deckcap').removeClass('hidden');
                $('#section_fullpalletcap').addClass('hidden');
                $('#section_pallpkgu').addClass('hidden');
                $('#section_tononcon').addClass('hidden');
                $('#section_fromnoncon').addClass('hidden');
                $('#allfloorerr').addClass('hidden');
                oTable = $('#table_deckcap').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[0, "asc"]],
                    "scrollX": true,

                    'sAjaxSource': "globaldata/casemonitor_deckcap.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
            }

            function _pallpkgu() {
                $('#section_deckcap').addClass('hidden');
                $('#section_fullpalletcap').addClass('hidden');
                $('#section_pallpkgu').removeClass('hidden');
                $('#section_tononcon').addClass('hidden');
                $('#section_fromnoncon').addClass('hidden');
                $('#allfloorerr').addClass('hidden');
                oTable = $('#table_pallpkgu').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[6, "desc"]],
                    "scrollX": true,

                    'sAjaxSource': "globaldata/casemonitor_pallpkgu.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
            }

            function _tononcon() {
                $('#section_deckcap').addClass('hidden');
                $('#section_fullpalletcap').addClass('hidden');
                $('#section_pallpkgu').addClass('hidden');
                $('#section_tononcon').removeClass('hidden');
                $('#section_fromnoncon').addClass('hidden');
                $('#allfloorerr').addClass('hidden');
                oTable = $('#table_tononcon').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[1, "desc"]],
                    "scrollX": true,

                    'sAjaxSource': "globaldata/casemonitor_tononcon.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
            }

            function _fromnoncon() {
                $('#section_deckcap').addClass('hidden');
                $('#section_fullpalletcap').addClass('hidden');
                $('#section_pallpkgu').addClass('hidden');
                $('#section_tononcon').addClass('hidden');
                $('#section_fromnoncon').removeClass('hidden');
                $('#allfloorerr').addClass('hidden');
                oTable = $('#table_fromnoncon').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[1, "desc"]],
                    "scrollX": true,

                    'sAjaxSource': "globaldata/casemonitor_fromnoncon.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
            }

            function _floorerr() {
                $('#section_deckcap').addClass('hidden');
                $('#section_fullpalletcap').addClass('hidden');
                $('#section_pallpkgu').addClass('hidden');
                $('#section_tononcon').addClass('hidden');
                $('#section_fromnoncon').addClass('hidden');
                $('#allfloorerr').removeClass('hidden');
                oTable = $('#tbl_floorerr').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[1, "asc"]],
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

            }

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
                        $('#addlocationmodal').modal('hide');
                        $('#tbl_floorerr').DataTable().ajax.reload();
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
    </body>
</html>
