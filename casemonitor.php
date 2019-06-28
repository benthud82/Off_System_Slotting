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
                        <section id="panel_fullpallcap"class="panel text-center"> 
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
                        <section id="panel_deckcap"class="panel text-center"> 
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
                        <section id="panel_palletopp"class="panel text-center"> 
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
            
            

        </script>

        <script>
            $("#modules").addClass('active');
        </script>
    </body>
</html>
