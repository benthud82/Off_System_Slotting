<!DOCTYPE html>
<html>
    <?php
    include 'sessioninclude.php';
    include_once 'connection/connection_details.php';
    ?>
    <head>
        <title>Reslot Tracking - Add Items</title>
        <?php include_once 'headerincludes.php'; ?>
    </head>
    <body>
        <!--include horz nav php file-->
        <?php include_once 'horizontalnav.php'; ?>
        <!--include vert nav php file-->
        <?php include_once 'verticalnav.php'; ?>
        <div class="container" style="margin-top: 75px">
            <!--Shows user if post to table was a success.-->
            <div id="postsuccess"></div>

            <h2 align="">Add items to be tracked through the re-slot tracking tool</h2>  
            <h4 align="">Note: Items added today will not be shown on the re-slot tracking tool until the next business day.</h4>  
            <h4>Go To Re-slot Tracking Tool<a href= "relslot_tracking.php"  target=_blank><i class='fa fa-external-link-square' style='cursor: pointer;     margin-left: 5px;' data-toggle='tooltip' data-title='Go to Re-slot Tracking Tool' data-placement='top' data-container='body' ></i></a></h4>

            <div class="form-group">
                <form name="add_name" id="add_name">


                    <div class="table-responsive" style="padding: 50px">  
                        <table class="table table-bordered" id="dynamic_field">  
                            <thead>
                            <th>Item</th>
                            <th>Package Unit</th>
                            <th>Date</th>
                            <th>Reslot Type</th>
                            </thead>
                            <tr id="row1" class="dynamic-added">  
                                <td><input type="text" name="item[]" placeholder="Enter Item" class="form-control name_list" required="" /></td>  
                                <td><input type="text" name="pkgu[]" placeholder="Enter Package Unit" class="form-control name_list" required="" value="1"/></td>  
                                <td><input type="date" name="date[]" placeholder="Enter Date" class="form-control name_list" required=""  value="<?php echo date('Y-m-d'); ?>" /></td>  
                                <td>
                                    <select name="type[]" value="BOTH" class="form-control name_list" required="">        
                                        <option value="BOTH">BOTH</option>
                                        <option value="WALK">WALK</option>
                                        <option value="REPLEN">REPLEN</option>
                                    </select>
                                </td>  
                                <td><button type="button" name="remove" id="1" class="btn btn-danger btn_remove">X</button></td>
                            </tr>  
                        </table>  
                        <button type="button" name="add" id="add" class="btn btn-success">Click to Add More Lines</button>
                        <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />  
                    </div>


                </form>  
            </div> 
        </div>


        <script type="text/javascript">
            $(document).ready(function () {
                var postURL = "formpost/relslottrack_additem.php";
                //intialize at 2 since 1 is loaded at page load
                var i = 2;


                $('#add').click(function () {
                    i++;
                    $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="item[]" placeholder="Enter Item" class="form-control name_list" required="" /></td><td><input type="text" name="pkgu[]" placeholder="Enter Package Unit" class="form-control name_list" required="" value="1"/></td><td><input type="date" name="date[]" placeholder="Enter Date" class="form-control name_list" required="" value="<?php echo date('Y-m-d'); ?>"/></td><td><select name="type[]" value="BOTH" class="form-control name_list" required=""><option value="BOTH">BOTH</option><option value="WALK">WALK</option><option value="REPLEN">REPLEN</option></select></td><td><button type="button" name="remove" id="' + i + '"class="btn btn-danger btn_remove">X</button></td></tr>');
                });


                $(document).on('click', '.btn_remove', function () {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });


                $('#submit').click(function () {
                    $.ajax({
                        url: postURL,
                        method: "POST",
                        data: $('#add_name').serialize(),
                        type: 'json',
                        success: function (data)
                        {
                            i = 1;
                            $('.dynamic-added').remove();
                            $('#add_name')[0].reset();
                            $("#postsuccess").html(data);

                        }
                    });
                });


            });
        </script>
    </body>
</html>