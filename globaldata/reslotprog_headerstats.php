<?php
$var_userid = $_SESSION['MYUSER'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


$hdr_movecountsql = $conn1->prepare("SELECT 
                                                                                    COUNT(*) as RESLOTCOUNT
                                                                                FROM
                                                                                    slotting.reslot_tracking_progress
                                                                                WHERE
                                                                                    YEAR(reslotprog_date) = YEAR(CURDATE())
                                                                                        AND reslotprog_whse = $var_whse;");
$hdr_movecountsql->execute();
$hdr_movecountsqlarray = $hdr_movecountsql->fetchAll(pdo::FETCH_ASSOC);
$movecount = $hdr_movecountsqlarray[0]['RESLOTCOUNT'];

$hdr_yearincrease = $conn1->prepare("SELECT 
                                                                    SUM(reslotprog_movered) AS TOT_MOVERED,
                                                                    SUM(reslotprog_walkred) / 5280 AS TOT_WALKRED
                                                                FROM
                                                                    slotting.reslot_tracking_progress
                                                                WHERE
                                                                    reslotprog_whse = $var_whse
                                                                GROUP BY reslotprog_whse");
$hdr_yearincrease->execute();
$hdr_yearincrease_array = $hdr_yearincrease->fetchAll(pdo::FETCH_ASSOC);
$movered = $hdr_yearincrease_array[0]['TOT_MOVERED'];
$walkred = $hdr_yearincrease_array[0]['TOT_WALKRED'];

$movecountcolor = 'blue-madison';

if ($movered < 0) {
    $movecolor = 'red-intense';
} else {
    $movecolor = 'green-jungle';
}

if ($walkred < 0) {
    $walkcolor = 'red-intense';
} else {
    $walkcolor = 'green-jungle';
}
?>

<div class="row" style="padding-top: 25px">
    <div class="col-lg-4 " id="stat_totaltime">
        <div class="dashboard-stat dashboard-stat-v2 <?php echo $movecountcolor ?>">  
            <div class="visual">
                <i class="fa fa-info-circle"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1349"><?php echo $movecount ?></span>
                </div>
                <div class="desc"> Total Re-Slots Being Tracked</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 " id="stat_totaltime">
        <div class="dashboard-stat dashboard-stat-v2 <?php echo $movecolor ?>">  
            <div class="visual">
                <i class="fa fa-info-circle"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1349"><?php echo intval($movered) ?></span>
                </div>
                <div class="desc">Yearly Replenishments Decreased</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 " id="stat_totaltime">
        <div class="dashboard-stat dashboard-stat-v2 <?php echo $walkcolor ?>">  
            <div class="visual">
                <i class="fa fa-info-circle"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="1349"><?php echo number_format($walkred, 1) ?></span>
                </div>
                <div class="desc">Yearly Miles Decreased</div>
            </div>
        </div>
    </div>

</div>