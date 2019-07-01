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
                        <section id="panel_nc_movein"class="panel text-center"> 
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
                        <section id="panel_nc_moveout"class="panel text-center"> 
                            <div class="panel-body bg-info panel-hover"> 
                                <div class="h4">Move out of<br>Noncon Tier</div>
                                <div class="line m-l m-r"></div> 
                                <!--Result div-->
                                <div id="result_nc_moveout" class="h4"></div>
                            </div>
                        </section> 
                    </div>
                </div>
                <div class="row" style="margin-top: 75px">

                    <!--datatable for full pallet capacity-->
                    <div class="col-xl-7">
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
                    </div>

                    <!--datatable for deck capacity-->
                    <div class="col-xl-7">
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
                    </div>

                    <!--datatable for pallet pkgu-->
                    <div class="col-xl-7">
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
            });


            function _fullpalletcap() {
                $('#section_fullpalletcap').removeClass('hidden');
                $('#section_deckcap').addClass('hidden');
                $('#section_pallpkgu').addClass('hidden');
                $('#section_tononcon').addClass('hidden');
                $('#section_fromnoncon').addClass('hidden');
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

        </script>

        <script>
            $("#modules").addClass('active');
        </script>
    </body>
</html>
