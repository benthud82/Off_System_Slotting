<?php
include_once '../connection/connection_details.php';
$var_userid = $_POST['userid'];
$whssql = $conn1->prepare("SELECT slottingDB_users_PRIMDC from slotting.slottingdb_users WHERE idslottingDB_users_ID = '$var_userid'");
$whssql->execute();
$whssqlarray = $whssql->fetchAll(pdo::FETCH_ASSOC);

$BAYCODE = $_POST['baycode'];
$mapsel = $_POST['mapsel'];
$var_whse = $whssqlarray[0]['slottingDB_users_PRIMDC'];


switch ($mapsel) {
    case "replen":
        $result2 = $conn1->prepare("SELECT 
                                ITEM_NUMBER,
                                CUR_LOCATION,
                                (CURRENT_IMPMOVES - SUGGESTED_IMPMOVES) * 253.00 as ADDTLREPLENS
                            FROM
                                slotting.my_npfmvc
                                    JOIN
                                slotting.slottingscore ON WAREHOUSE = SCORE_WHSE
                                    and ITEM_NUMBER = SCORE_ITEM
                                    and SCORE_PKGU = PACKAGE_UNIT
                            WHERE
                                CASE WHEN LMTIER = 'L01' then CUR_LOCATION = '$BAYCODE' WHEN LMTIER = 'L05' then CONCAT(SUBSTR(CUR_LOCATION, 1, 3),'01')  = '$BAYCODE' else
                                        SUBSTR(CUR_LOCATION, 1, 5) = '$BAYCODE' end
                                    and WAREHOUSE = $var_whse
                            ORDER BY CURRENT_IMPMOVES - SUGGESTED_IMPMOVES DESC");  //$orderby pulled from: include 'slopecat_switch_orderby.php';
        $result2->execute();
        $itemscorearray = $result2->fetchAll(pdo::FETCH_ASSOC);

        $total = 0;
        $count = count($itemscorearray);
        foreach ($itemscorearray as $key => $value) {
            $total += $itemscorearray[$key]['ADDTLREPLENS'];
        }
        $totalscoreaverage = number_format($total,2);
        ?>

        <section class="panel"> 
            <?php
            foreach ($itemscorearray as $key => $value) {
                if ($key == 0) {
                    ?>
                    <header class="panel-heading bg h3 text-center bg-softblue">Additional Replens </header>
                    <div class="panel-body  text-center" style="border-bottom: 3px solid #ccc;">
                        <div class="widget-content-blue-wrapper changed-up">
                            <div class="widget-content-blue-inner padded">
                                <div class="h4"><i class="fa fa-info-circle"></i> Replen Reduction Opp.</div>
                                <div class="line m-l m-r"></div> 
                                <div class="value-block">
                                    <!--Walk Score-->
                                    <div class="h2" id="score_quarter"><?php echo number_format($totalscoreaverage,2) ?></div> 
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <!-- Current Quarter Panel -->            


                <!-- List group -->
                <div class="list-group">
                    <div class="list-group-item"> 
                        <a href="itemquery.php?itemnum=<?php echo $itemscorearray[$key]['ITEM_NUMBER'] . '&userid=' . $var_userid; ?>" target="_blank"> <span class=""><?php echo $itemscorearray[$key]['ITEM_NUMBER'] . ' | ' . $itemscorearray[$key]['CUR_LOCATION'] ?></span> </a>
                        <span class="pull-right"><strong><?php echo number_format($itemscorearray[$key]['ADDTLREPLENS'])?></strong></span> 

                    </div>
                </div>



            <?php } ?>

        </section>
        <?php
        break;
    case "pickall":

        $result2 = $conn1->prepare("SELECT 
                                        ITEM_NUMBER,
                                        CUR_LOCATION,
                                        SCORE_WALKSCORE,
                                        SCORE_REPLENSCORE,
                                        SCORE_TOTALSCORE,
                                        AVG_DAILY_PICK
                                    FROM
                                        slotting.my_npfmvc
                                    JOIN
                                        slotting.slottingscore ON WAREHOUSE = SCORE_WHSE
                                            and ITEM_NUMBER = SCORE_ITEM
                                            and SCORE_PKGU = PACKAGE_UNIT
                                    WHERE
                                    CASE WHEN LMTIER = 'L01' then CUR_LOCATION = '$BAYCODE' WHEN LMTIER = 'L05' then CONCAT(SUBSTR(CUR_LOCATION, 1, 3),'01')  = '$BAYCODE' else
                                        SUBSTR(CUR_LOCATION, 1, 5) = '$BAYCODE' end
                                        and WAREHOUSE = $var_whse
                                    ORDER BY SCORE_WALKSCORE ASC");  //$orderby pulled from: include 'slopecat_switch_orderby.php';
        $result2->execute();
        $itemscorearray = $result2->fetchAll(pdo::FETCH_ASSOC);

        $total = 0;
        $count = count($itemscorearray);
        foreach ($itemscorearray as $key => $value) {
            $total += $itemscorearray[$key]['SCORE_WALKSCORE'] * 100;
        }
        if ($count > 0){
        $totalscoreaverage = number_format($total / $count, 2) . '%';
        }else{
            $totalscoreaverage = 'N/A';
        }
        ?>

        <section class="panel"> 
            <?php
            foreach ($itemscorearray as $key => $value) {
                if ($key == 0) {
                    ?>
                    <header class="panel-heading bg h3 text-center bg-softblue">Walk Scores by Bay </header>
                    <div class="panel-body  text-center" style="border-bottom: 3px solid #ccc;">
                        <div class="widget-content-blue-wrapper changed-up">
                            <div class="widget-content-blue-inner padded">
                                <div class="h4"><i class="fa fa-info-circle"></i> Average Walk Score</div>
                                <div class="line m-l m-r"></div> 
                                <div class="value-block">
                                    <!--Walk Score-->
                                    <div class="h2" id="score_quarter"><?php echo $totalscoreaverage ?></div> 
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

                <!-- Current Quarter Panel -->            


                <!-- List group -->
                <div class="list-group">
                    <div class="list-group-item"> 
			
						
                        <a href="itemquery.php?itemnum=<?php echo $itemscorearray[$key]['ITEM_NUMBER'] . '&userid=' . $var_userid; ?>" target="_blank"> <span class=""><?php echo $itemscorearray[$key]['ITEM_NUMBER'] . ' | ' . $itemscorearray[$key]['CUR_LOCATION'] ?></span> </a>
                        <span class="pull-right"><strong><?php echo number_format($itemscorearray[$key]['SCORE_WALKSCORE'] * 100, 1) . '% | APD: ' . number_format($itemscorearray[$key]['AVG_DAILY_PICK'],1 ); ?></strong></span> 
				
                    </div>
                </div>



            <?php } ?>

        </section>
        <?php
        break;
    default:
        break;
}




