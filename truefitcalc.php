<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">	

<html>

    <head>
        <title>True Fit Calculator</title>
        <?php
        include_once '../connections/conn_slotting.php';
        include_once 'sessioninclude.php';
        include_once 'headerincludes.php';
        include_once 'horizontalnav.php';
        include_once 'verticalnav.php';
        ?>



        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../tabstyles.css" rel="stylesheet" />
        <script src="../jquery.js" type="text/javascript"></script>
        <link href="../csvtable.css" rel="stylesheet" />
        <link rel="shortcut icon" type="image/ico" href="../favicon.ico" />  
        <link rel="stylesheet" href="../jquery-ui.css" type="text/css">
        <script src="../jquery.blockUI.js"></script>
        <script src="../jquery-ui.js"></script>
        <style type="text/css">
            #iteminput {visibility:hidden;}

        </style>

        <script>
            function show(el, vis) {
                var elem = document.getElementById(el);
                elem.style.visibility = (vis) ? 'visible' : 'hidden';
            }

        </script>

        <SCRIPT LANGUAGE="JavaScript">


            //script to get grid5 info after DC is selected.
            function getGrid5Info(whsvalue) {
                $.blockUI({css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }});

                if (whsvalue == "") {
                    document.getElementById("grid5selector").innerHTML = "";
                    $.unblockUI();
                    return;
                }
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("grid5selector").innerHTML = xmlhttp.responseText;
                        $.unblockUI();
                    }
                }
                xmlhttp.open("GET", "grid5pickdata.php?whspicked=" + whsvalue, true);
                xmlhttp.send();

            }

            //script to record selected grid5 from dropdown.

        </SCRIPT>

        <script>
            $(document).ready(function () {
                $('.line-separator').hide();
                $('#postrequest').hide();
                $("#loaddata").click(function () {
                    $.blockUI({css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .5,
                            color: '#fff'
                        }});
                    grid5select = $("#grid5select").val();
                    itempicked = $("#itempicked").val();
                    whsesel = $("#whsesel").val();
                    $.post("tfitemgriddata.php", {grid5select: grid5select, item: itempicked, whs: whsesel}, function (ajaxresult) {
                        $('.line-separator').show();
                        $('#postrequest').show();
                        $("#postrequest").html(ajaxresult);
                        $.unblockUI();
                    });
                });
                $("#itempicked").keyup(function (event) {
                    if (event.keyCode == 13) {
                        $("#loaddata").click();
                    }
                });
            });
        </script>

    </head>

    <body style="background-color: #FFFFFF;">
        <div class="main padder" style="margin-top: 75px;padding-left: 100px; "> 
            <script src="../jquery.watermarkinput.js" type="text/javascript"></script>

            <h2 style="padding-bottom: 0px;">True Fit Calculator</h2>


            <script>
                jQuery(function ($) {
                    $("#itempicked").Watermark("Item (no dashes)");
                });
            </script>

            <div class="submitwrapper" id="submitwrapper">
                <?php
                $indy = $sparks = $denver = $dallas = $jax = $NOTL = $vanc = $calg = '';
                if (isset($_GET['whse']) && !empty($_GET['whse'])) {
                    $whssel = $_GET['whse'];


                    switch ($whssel) {
                        case 2:
                            $indy = "selected";
                            break;
                        case 3:
                            $sparks = "selected";
                            break;
                        case 6:
                            $denver = "selected";
                            break;
                        case 7:
                            $dallas = "selected";
                            break;
                        case 9:
                            $jax = "selected";
                            break;
                        case 11:
                            $NOTL = "selected";
                            break;
                        case 12:
                            $vanc = "selected";
                            break;
                        case 16:
                            $calg = "selected";
                            break;
                    }
                }

                echo "<form method='GET' name='whsform'>
            <select style='float: left; margin-right: 10px;' name='whsepick' id='whsesel' onchange='getGrid5Info(this.value)'>
                <option value='0'>Choose Whse...</option>
                <option value='2' $indy>Indy</option>
                <option value='3'$sparks>Sparks</option>
                <option value='6'$denver>Denver</option>
                <option value='7'$dallas>Dallas</option>
                <option value='9'$jax>Jacksonville</option>
                <option value='11'$NOTL>NOTL</option>
                <option value='12'$vanc>Vancouver</option>
                <option value='16'$calg>Calgary</option>
                </select>
            </form>";
                ?>
                <form method="GET" onkeypress="return event.keyCode != 13">
                    <!--grid5selector is populated by grid5pickdata.php-->
                    <div id="grid5selector"></div>
                </form>
                <form method="GET" onkeypress="return event.keyCode != 13">
                    <div id="iteminput"><input type="text" id="itempicked" class="textinput" style="margin: 0px; float: left;"></div>
                </form>


                <input id="loaddata" type='submit' name='formSubmit' value='Calculate True Fit' class="submitdata" />
            </div>

            <br><br><br><br><div class="line-separator"></div> <br>

            <!--Post the info from tfitemgriddata.php-->
            <div id="postrequest" style="margin: 15px; min-width: 0px; font-family: calibri; font-size: 20px; color: white"></div>


            <script>
                $('#loaddata').hide();
                $('#itempicked').keyup(function () {
                    var max = 7;
                    var len = $(this).val().length;
                    if (len !== max) {
                        $('#loaddata').hide();
                    } else {
                        $('#loaddata').show();
                    }
                });
                
                    $("#reports").addClass('active');
            </script>
        </div>

    </body>
</html>

</body>
</html>

