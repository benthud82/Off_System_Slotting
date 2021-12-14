<?php

if ($var_whse == 6 || $var_whse == 9|| $var_whse == 3|| $var_whse == 7|| $var_whse == 2){
//    $whs6L01filter  = " and A.LMTIER <> 'L01' and A.SUGGESTED_TIER <> 'L01'";
     $whs6L01filter = ' ';
}else{
    $whs6L01filter = ' ';
}

$TOP_SCORE = $conn1->prepare("SELECT DISTINCT
                                        A . *,
                                        B.OPT_NEWGRIDVOL,
                                        B.OPT_PPCCALC,
                                        B.OPT_OPTBAY,
                                        B.OPT_CURRBAY,
                                        B.OPT_CURRDAILYFT,
                                        B.OPT_SHLDDAILYFT,
                                        B.OPT_ADDTLFTPERPICK,
                                        B.OPT_ADDTLFTPERDAY,
                                        B.OPT_WALKCOST,
                                        C.CURMAX,
                                        C.CURMIN,
                                        D.VCCTRF,
                                        E.SCORE_TOTALSCORE,
                                        E.SCORE_REPLENSCORE,
                                        E.SCORE_WALKSCORE,
                                        E.SCORE_TOTALSCORE_OPT,
                                        E.SCORE_REPLENSCORE_OPT,
                                        E.SCORE_WALKSCORE_OPT,
                                        F.CPCPFRC,
                                        F.CPCPFRA,
                                        openactions_assignedto,
                                        openactions_comment
                                    FROM
                                        slotting.my_npfmvc A
                                            join
                                        slotting.optimalbay B ON A.WAREHOUSE = B.OPT_WHSE
                                            and A.ITEM_NUMBER = B.OPT_ITEM
                                            and A.PACKAGE_UNIT = B.OPT_PKGU
                                            and A.PACKAGE_TYPE = B.OPT_CSLS
                                            join
                                        slotting.mysql_npflsm C ON C.LMWHSE = A.WAREHOUSE
                                            and C.LMITEM = A.ITEM_NUMBER
                                            and C.LMTIER = A.LMTIER
                                            and C.LMPKGU = A.PACKAGE_UNIT
                                            join
                                        slotting.system_npfmvc D ON D.VCWHSE = A.WAREHOUSE
                                            and D.VCITEM = A.ITEM_NUMBER
                                            and D.VCPKGU = A.PACKAGE_UNIT
                                            and D.VCFTIR = A.LMTIER
                                            join
                                        slotting.slottingscore E ON E.SCORE_WHSE = A.WAREHOUSE
                                            AND E.SCORE_ITEM = A.ITEM_NUMBER
                                            AND E.SCORE_PKGU = A.PACKAGE_UNIT
                                            AND E.SCORE_ZONE = A.PACKAGE_TYPE
                                            join
                                        slotting.npfcpcsettings F ON F.CPCWHSE = A.WAREHOUSE
                                            and F.CPCITEM = A.ITEM_NUMBER
                                       left join slotting.dsl2locs on dsl2whs = A.WAREHOUSE
                                        and dsl2item = A.ITEM_NUMBER and dsl2pkgu = A.PACKAGE_UNIT
                                        LEFT JOIN
                                        slotting.item_settings ON WHSE = WAREHOUSE AND ITEM = ITEM_NUMBER
                                            AND PKGU = PACKAGE_UNIT
                                         LEFT JOIN slotting.slottingdb_itemactions on openactions_whse = SCORE_WHSE and openactions_item = SCORE_ITEM
                                    WHERE
                                        A.WAREHOUSE = $var_whse
                                            and PACKAGE_TYPE = '$zone' and  LMSLR not in (2,4) and A.PACKAGE_UNIT = 1  
                                                AND (HOLDLOCATION IS NULL or HOLDLOCATION = ' ')
                                                and dsl2csls is null $whs6L01filter $itemnumsql
                                    ORDER BY E.SCORE_TOTALSCORE_OPT - E.SCORE_TOTALSCORE DESC, E.SCORE_TOTALSCORE asc, E.SCORE_REPLENSCORE asc, E.SCORE_WALKSCORE asc
                                    LIMIT $returncount");
$TOP_SCORE->execute();
$TOP_REPLEN_COST_array = $TOP_SCORE->fetchAll(pdo::FETCH_ASSOC);

