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
                <div id="title" class="h2">Case Pick Dashboard</div>


                <!--Header info Stats-->
                <div id="headerstats"></div>


            </section>
        </section>


        <script>
            $("body").tooltip({selector: '[data-toggle="tooltip"]'});
            $("#help").addClass('active');
            $(document).ready(function () {
                headerdata();
            });


            //Data pull to refresh header case data
            function headerdata(building) {
                $.ajax({
                    data: {building: building},
                    url: 'globaldata/headerdata_test.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function (ajaxresult) {
                        $("#headerstats").html(ajaxresult);
                        $('.yestreturns').counterUp({
                            delay: 100,
                            time: 1200
                        });
                    }
                });
            }
        </script>

    </body>
</html>


