<?php

if (!isset($usedswaplocaionarray)) {
    $usedswaplocaionarray = array();
}

if (!isset($usedswapitemarray)) {
    $usedswapitemarray = array();
}



$usedlocationcommalist = "'" . implode("','", $usedswaplocaionarray) . "'";
$useditemcommalist = "'" . implode("','", $usedswapitemarray) . "'";
$NEW_LOC_TRUEFIT_array = array();

if ($zone == 'LSE') {
    $zonefilter = " = 'LSE'";
} else {
    $zonefilter = " <> 'LSE'";
}


$displayarray[$topcostkey]['MOVES_AFTER_LEVEL1_SWAP'] = '-';
$displayarray[$topcostkey]['MOVESCORE_AFTER_LEVEL1_SWAP'] = '-';
$displayarray[$topcostkey]['WALKSCORE_AFTER_LEVEL1_SWAP'] = '-';
$displayarray[$topcostkey]['TOTSCORE_AFTER_LEVEL1_SWAP'] = '-';
//currently limited to only swap items that want to downsize
//this will prevent scenario where you might upsize a swap item to a highly desirable location with a less desirable item
$SLOT_COST_ONELEVEL = $conn1->prepare("SELECT 
                                                A.*,
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
                                                E.SCORE_WALKSCORE_OPT
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
                                        WHERE
                                            A.WAREHOUSE = $var_whse and PACKAGE_TYPE $zonefilter and A.CUR_LOCATION $sparksbuild2filter
                                             and A.SUGGESTED_NEWLOCVOL < A.LMVOL9 and A.LMGRD5 = '$VCNGD5' and OPT_CURRBAY = $OPT_OPTBAY  and A.LMTIER = '$VCTTIR'
                                                 and A.ITEM_NUMBER not in ($useditemcommalist)
                                        ORDER BY E.SCORE_TOTALSCORE DESC, (A.LMVOL9 - A.SUGGESTED_NEWLOCVOL) DESC");
$SLOT_COST_ONELEVEL->execute();
$SLOT_COST_ONELEVEL_array = $SLOT_COST_ONELEVEL->fetchAll(pdo::FETCH_ASSOC);

//Loop through resultset to determine if there is a perfect match to free up needed perfect match for high cost item
foreach ($SLOT_COST_ONELEVEL_array as $key => $value) {
    $LEVEL_ONE_TIER = $SLOT_COST_ONELEVEL_array[$key]['SUGGESTED_TIER'];
    $LEVEL_ONE_GRD5 = $SLOT_COST_ONELEVEL_array[$key]['SUGGESTED_GRID5'];
    $LEVEL_ONE_DEPTH = $SLOT_COST_ONELEVEL_array[$key]['SUGGESTED_DEPTH'];
    $LEVEL_ONE_BAY = $SLOT_COST_ONELEVEL_array[$key]['OPT_OPTBAY'];
    $LEVEL_ONE_PCCHEI = $SLOT_COST_ONELEVEL_array[$key]['CPCCHEI'];
    $LEVEL_ONE_PCCLEN = $SLOT_COST_ONELEVEL_array[$key]['CPCCLEN'];
    $LEVEL_ONE_PCCWID = $SLOT_COST_ONELEVEL_array[$key]['CPCCWID'];
    $LEVEL_ONE_PCCPKU = $SLOT_COST_ONELEVEL_array[$key]['CPCCPKU'];
    $LEVEL_ONE_PCEHEI = $SLOT_COST_ONELEVEL_array[$key]['CPCEHEI'];
    $LEVEL_ONE_PCELEN = $SLOT_COST_ONELEVEL_array[$key]['CPCELEN'];
    $LEVEL_ONE_PCEWID = $SLOT_COST_ONELEVEL_array[$key]['CPCEWID'];
    $LEVEL_ONE_PCEPKU = $SLOT_COST_ONELEVEL_array[$key]['CPCEPKU'];
    $LEVEL_ONE_NEWGRIDHEI = intval(substr($LEVEL_ONE_GRD5, 0, 2));
    $LEVEL_ONE_NEWGRIDWDT = intval(substr($LEVEL_ONE_GRD5, 3, 2));
    $LEVEL_ONE_LIQ = $SLOT_COST_ONELEVEL_array[$key]['CPCLIQU'];
    $LEVEL_ONE_AVGSHIP = $SLOT_COST_ONELEVEL_array[$key]['SHIP_QTY_MN'];
    $LEVEL_ONE_SWAP_NEW_LOC_SLOTQTY = $SLOT_COST_ONELEVEL_array[$key]['SUGGESTED_SLOTQTY'];
    $LEVEL_ONE_SWAP_NEW_LOC_SHIPQTY = $SLOT_COST_ONELEVEL_array[$key]['SHIP_QTY_MN'];
    $LEVEL_ONE_SWAP_NEW_LOC_ADBS = $SLOT_COST_ONELEVEL_array[$key]['AVGD_BTW_SLE'];
    $LEVEL_ONE_DAILYUNIT = $SLOT_COST_ONELEVEL_array[$key]['AVG_DAILY_PICK'];
    $LEVEL_ONE_AVGINV = $SLOT_COST_ONELEVEL_array[$key]['AVG_INV_OH'];
    $LEVEL_ONE_CURRBAY = $SLOT_COST_ONELEVEL_array[$key]['OPT_CURRBAY'];

    $PERFGRID_LEVEL_ONE = $LEVEL_ONE_TIER . $LEVEL_ONE_GRD5 . $LEVEL_ONE_DEPTH . $LEVEL_ONE_BAY;

    //for case slotting, if optimal bay == 999 (PFR) then set match key to 999999 to indicate need to go to PFR
    if ($LEVEL_ONE_BAY == 999) {
        $LEVEL_ONE_match_key = 999999;
    } else {
        $LEVEL_ONE_match_key = array_search($PERFGRID_LEVEL_ONE, array_column($EMPTYLOC_array, 'KEYVAL'));
    }



    if ($LEVEL_ONE_match_key <> FALSE) { //a perfect grid match has been found.  Set as new location
        if ($LEVEL_ONE_match_key == 999999) {  //Move to case pick PFR
            $LEVEL_ONE_SWAP_NEW_LOC = 'CSE_PFR';
            $LEVEL_ONE_SWAP_NEW_GRD5 = 'C_PFR';
            $displayarray[$topcostkey]['AssgnGrid5'] = $LEVEL_ONE_SWAP_NEW_GRD5; //Add new grid5 to display array
        } else {
            $LEVEL_ONE_SWAP_NEW_LOC = $EMPTYLOC_array[$LEVEL_ONE_match_key]['LMLOC#'];
            $LEVEL_ONE_SWAP_NEW_GRD5 = $EMPTYLOC_array[$LEVEL_ONE_match_key]['LMGRD5'];
            $displayarray[$topcostkey]['AssgnGrid5'] = $LEVEL_ONE_SWAP_NEW_GRD5; //Add new grid5 to display array
        }

        unset($EMPTYLOC_array[$LEVEL_ONE_match_key]);
        $EMPTYLOC_array = array_values($EMPTYLOC_array);
        $displayarray[$topcostkey]['LEVEL_1_NEW_LOC'] = $LEVEL_ONE_SWAP_NEW_LOC; //add new location for level 1 item
        //Can now take newly emptied location with high cost item
        $NEW_LOC = $SLOT_COST_ONELEVEL_array[$key]['CUR_LOCATION'];
        $NEW_GRD5 = $SLOT_COST_ONELEVEL_array[$key]['LMGRD5'];
        $NEW_GRD_HGT = substr($NEW_GRD5, 0, 2);
        $NEW_GRD_DPT = $SLOT_COST_ONELEVEL_array[$key]['LMDEEP'];
        $NEW_GRD_WDT = substr($NEW_GRD5, 3, 2);

        $usedswaplocaionarray[] = $NEW_LOC;
        $usedswapitemarray[] =$SLOT_COST_ONELEVEL_array[$key]['ITEM_NUMBER'];


        $caseoreachTF = _caseoreachtf($LEVEL_ONE_TIER); //call function to determine which TF function to access.  Using the tier of the empty grid to determine which tf (case or each) to use
        if ($PCCHEI * $PCCLEN * $PCCWID * $PCCPKU > 0) { //if there is a case pkgu and all dimensions are set
            if ($caseoreachTF == 'Case') {
                //use case tf function
                $NEW_LOC_TRUEFIT_array = _truefitgrid2iterations_case($NEW_GRD5, $NEW_GRD_HGT, $NEW_GRD_DPT, $NEW_GRD_WDT, $PCLIQU, $PCCHEI, $PCCLEN, $PCCWID, $PCCPKU);  //call funcation to calculate TF based of grid5
            } elseif ($PCEHEI * $PCELEN * $PCEWID * $PCEPKU > 0) {
                //use each tf function
                $NEW_LOC_TRUEFIT_array = _truefitgrid2iterations($NEW_GRD5, $NEW_GRD_HGT, $NEW_GRD_DPT, $NEW_GRD_WDT, $PCLIQU, $PCEHEI, $PCELEN, $PCEWID);
            }
        } elseif ($PCEHEI * $PCELEN * $PCEWID * $PCEPKU > 0) {
            $NEW_LOC_TRUEFIT_array = _truefitgrid2iterations($NEW_GRD5, $NEW_GRD_HGT, $NEW_GRD_DPT, $NEW_GRD_WDT, $PCLIQU, $PCEHEI, $PCELEN, $PCEWID);
        } else {
            break;
        }
        if (count($NEW_LOC_TRUEFIT_array) > 0) {
            $NEW_LOC_TRUEFIT_round2 = $NEW_LOC_TRUEFIT_array[1]; //assign 2-iteration tf to variable
            $Newmin = _minloc($NEW_LOC_TRUEFIT_round2, $TOP_REPLEN_COST_array[$topcostkey]['SHIP_QTY_MN'], $PCCPKU);

            $impmoves_after_level1swap = _implied_daily_moves($NEW_LOC_TRUEFIT_round2, $Newmin, $TOP_REPLEN_COST_array[$topcostkey]['AVG_DAILY_UNIT'], $TOP_REPLEN_COST_array[$topcostkey]['AVG_INV_OH'],$TOP_REPLEN_COST_array[$topcostkey]['SHIP_QTY_MN'],$TOP_REPLEN_COST_array[$topcostkey]['AVGD_BTW_SLE']);
            $replen_score_level1swap = _replen_score_from_moves($impmoves_after_level1swap);


            if ($zone == 'CSE') { //calculate LSE or CSE walk cost
                $walk_score_level1swap_array = _walkcost_case($VCTTIR, $VCTTIR, $TOP_REPLEN_COST_array[$topcostkey]['AVG_DAILY_UNIT'], $TOP_REPLEN_COST_array[$topcostkey]['FLOOR']);
                $walk_score_level1swap = $walk_score_level1swap_array['WALK_SCORE'];
            } else {
                $walk_score_level1swap = _walkscore(intval(substr($NEW_LOC, 3, 2)), $OPT_OPTBAY, $TOP_REPLEN_COST_array[$topcostkey]['AVG_DAILY_PICK']);
            }




            $displayarray[$topcostkey]['MOVES_AFTER_LEVEL1_SWAP'] = $impmoves_after_level1swap;
            $displayarray[$topcostkey]['MOVESCORE_AFTER_LEVEL1_SWAP'] = abs($replen_score_level1swap);
            $displayarray[$topcostkey]['WALKSCORE_AFTER_LEVEL1_SWAP'] = abs($walk_score_level1swap);
            $displayarray[$topcostkey]['TOTSCORE_AFTER_LEVEL1_SWAP'] = abs($replen_score_level1swap) * abs($walk_score_level1swap);
        } else {
            $displayarray[$topcostkey]['MOVES_AFTER_LEVEL1_SWAP'] = '-';
            $displayarray[$topcostkey]['MOVESCORE_AFTER_LEVEL1_SWAP'] = '-';
            $displayarray[$topcostkey]['WALKSCORE_AFTER_LEVEL1_SWAP'] = '-';
            $displayarray[$topcostkey]['TOTSCORE_AFTER_LEVEL1_SWAP'] = '-';
        }



        $displayarray[$topcostkey]['LEVEL_1_OLD_LOC'] = $NEW_LOC;
        $displayarray[$topcostkey]['LEVEL_1_ITEM'] = $SLOT_COST_ONELEVEL_array[$key]['ITEM_NUMBER'];
//        $displayarray[$topcostkey]['AFTER_LEVEL1_SWAP_DAILY_MOVES'] = $replen_cost_return_array_LEVEL_ONE_SWAP['IMP_MOVES_DAILY'];
        break;
    }
}

if (count($SLOT_COST_ONELEVEL_array) <= 0) {
    $displayarray[$topcostkey]['AssgnGrid5'] = '-';
    $displayarray[$topcostkey]['MOVES_AFTER_LEVEL1_SWAP'] = '-';
    $displayarray[$topcostkey]['MOVESCORE_AFTER_LEVEL1_SWAP'] = '-';
    $displayarray[$topcostkey]['WALKSCORE_AFTER_LEVEL1_SWAP'] = '-';
    $displayarray[$topcostkey]['TOTSCORE_AFTER_LEVEL1_SWAP'] = '-';
}