
<?php
include_once '../connection/connection_details.php';
date_default_timezone_set('America/New_York');
$datetime = date('Y-m-d');
include_once '../sessioninclude.php';

$var_userid = strtoupper($_SESSION['MYUSER']);
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE UPPER(idslottingDB_users_ID) = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
$columns = "reslot_whse, reslot_item, reslot_pkgu, reslot_date, reslot_type";
$rowcount = 0;
$number = count($_POST["item"]);
if ($number > 0) {
    for ($i = 0; $i < $number; $i++) {
        if (trim($_POST["item"][$i] != '') && trim($_POST["pkgu"][$i] != '') && trim($_POST["date"][$i] != '') && trim($_POST["type"][$i] != '')) {
            $varitem = intval(trim($_POST["item"][$i]));
            $varpkgu = intval(trim($_POST["pkgu"][$i]));
            $vardate = (trim($_POST["date"][$i]));
            $vartype = (trim($_POST["type"][$i]));
            $sql = "INSERT IGNORE INTO slotting.reslot_tracking ($columns) VALUES ($var_whse, $varitem, $varpkgu, '$vardate', '$vartype' )";
            $query = $conn1->prepare($sql);
            $query->execute();
            $rowcount += 1;
        }
    }
    $detailinsertsuccess = 1;
}
?>

<!-- Progress/Success Modal-->
<div id="progressmodal_salesplanall" class="modal fade " role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
            <div class="h4" style="text-align: center; padding-bottom: 30px">Successfully added <?php echo $rowcount . ' items to your total move count!'; ?> </div>
        </div>
    </div>
</div>
<script>
    $('#progressmodal_salesplanall').modal('toggle');
</script>