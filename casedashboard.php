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
                                            <th>Potential Picking <br>Hours Reduced</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                <!--Case Moves by Date Highchart-->
                <div class="col-sm-12">
                    <section class="panel hidewrapper" id="graph_historicalreplens_actual" style="margin-bottom: 50px; margin-top: 20px;"> 
                        <header class="panel-heading bg bg-inverse h2">Historical Completed Case Replens<i class="fa fa-close pull-right closehidden" style="cursor: pointer;" id="close_replengraph_actual"></i><i class="fa fa-chevron-up pull-right clicktotoggle-chevron" style="cursor: pointer;"></i></header>
                        <div id="historicalreplens_actual" class="panel-body" style="background: #efefef">
                            <div id="chartpage_replen_actual"  class="page-break" style="width: 100%">
                                <div id="charts padded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="alert alert-info " style="font-size: 100%;"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <i class="fa fa-info-circle fa-lg"></i><span> Actual replenishments <strong>COMPLETED</strong> by <strong>REQUESTED </strong>date. Move must be completed before it will be recorded.</span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="alert alert-success" style="font-size: 100%;"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <i class="fa fa-arrow-down fa-lg"></i><span> Positive improvement indicated by <strong>downward</strong> trending graph. </span></div>
                                        </div>
                                    </div>
                                    <div id="container_replens_actual" class="dashboardstyle printrotate"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#help").addClass('active');
            $(document).ready(function () {
                oTable = $('#table_dt_equipment').dataTable({
                    dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 text-center'B><'col-sm-4 pull-right'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-4 pull-left'i><'col-sm-8 pull-right'p>>",
                    destroy: true,
                    "order": [[0, "desc"]],
                    "scrollX": true,
                    "aoColumnDefs": [
                        {"sClass": "lightgray", "aTargets": [1, 2, 5, 6]}
                    ],
                    'sAjaxSource': "globaldata/casedash_equipmentpicks.php",
                    buttons: [
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });


                //options for actual replens highchart
                var options3 = {
                    chart: {
                        marginTop: 50,
                        marginBottom: 135,
                        renderTo: 'container_replens_actual',
                        type: 'spline'
                    }, credits: {
                        enabled: false
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                enabled: false
                            }
                        },
                        series: {
                            cursor: 'pointer',
                            point: {
                                events: {
                                    click: function () {
                                        window.open('movesdetail.php?startdate=' + this.category + '&enddate=' + this.category + '&movetype=' + this.series.name + '&formSubmit=Submit');
                                    }
                                }
                            }
                        }
                    },
                    title: {
                        text: ' '
                    },
                    xAxis: {
                        categories: [], labels: {
                            rotation: -90,
                            y: 25,
                            align: 'right',
                            step: 5,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        },
                        legend: {
                            y: "10",
                            x: "5"
                        }

                    },
                    yAxis: {
                        title: {
                            text: 'Completed Replenshments'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }],
                        opposite: true,
                        min: 0
                    }, tooltip: {
                        formatter: function () {
                            return '<b>' + this.series.name + '</b><br/>' +
                                    this.x + ': ' + Highcharts.numberFormat(this.y, 0) ;
                        }
                    },
                    series: []
                };
                $.ajax({
                    url: 'globaldata/casepick_replens_actual.php',
                    type: 'GET',
                    dataType: 'json',
                    async: 'true',
                    success: function (json) {
                        options3.xAxis.categories = json[0]['data'];
                        options3.series[0] = json[1];
                        options3.series[1] = json[2];
                        options3.series[1] = json[2];
                        options3.series[1].dashStyle= 'longdash';

                        chart = new Highcharts.Chart(options3);
                        series = chart.series;
                        $(window).resize();
                    }
                });
            });
        </script>

    </body>
</html>


