<?php
include '../sessioninclude.php';
include '../../connections/conn_printvis.php';
include '../../globalfunctions/custdbfunctions.php';
if (isset($_SESSION['MYUSER'])) {
    $var_userid = $_SESSION['MYUSER'];
    $whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
    $whssql->execute();
    $whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

    $var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];
    $whsesel = $whssqlarray[0]['slottingDB_users_PRIMDC'];
}
$build = intval($_POST['building']);
//average pick reduction opportunity
$sql_hourred = $conn1->prepare("SELECT 
                                                                AVG(equippicks_hourred) as HOUR_RED
                                                            FROM
                                                                printvis.casedash_equippicks
                                                            WHERE
                                                                equippicks_whse = $var_whse
                                                                    AND equippicks_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW();");
$sql_hourred->execute();
$array_hourred = $sql_hourred->fetchAll(pdo::FETCH_ASSOC);
$hourred = number_format($array_hourred[0]['HOUR_RED'], 2);

//daily replen reduction opportunity
$sql_replenred = $conn1->prepare("SELECT 
                                                            SUM(CURRENT_IMPMOVES) - SUM(SUGGESTED_IMPMOVES) AS REPLEN_RED
                                                        FROM
                                                            slotting.my_npfmvc_cse
                                                        WHERE
                                                            WAREHOUSE = $var_whse and BUILDING = $build");
$sql_replenred->execute();
$array_replenred = $sql_replenred->fetchAll(pdo::FETCH_ASSOC);
$replenred = intval($array_replenred[0]['REPLEN_RED']);
?>


<div class="row" style="padding-top: 25px">
    <div class="col-lg-3 " id="stat_hourred">
        <div class="dashboard-stat dashboard-stat-v2 yellow-casablanca">  
            <div class="visual">
                <i class="fa fa-cubes"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="yestreturns" data-counter="counterup" data-value="<?php echo $hourred ?>"><?php echo $hourred ?></span>
                </div>
                <div class="desc"> Avg. Daily Picking Hour Reduction </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 " id="stat_replenred">
        <div class="dashboard-stat dashboard-stat-v2 yellow-casablanca">  
            <div class="visual">
                <i class="fa fa-tags"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span class="yestreturns" data-counter="counterup" data-value="<?php echo $replenred ?>"><?php echo $replenred ?></span>
                </div>
                <div class="desc"> Daily Replen Reduction Opportunity </div>
            </div>
        </div>
    </div>

</div>


