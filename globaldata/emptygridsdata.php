<?php

if ($var_whse == 11 || $var_whse == 12 || $var_whse == 16) {
    $useconn = $aseriesconn_can;
    $useschema = 'ARCPCORDTA';
} else {
    $useconn = $aseriesconn;
    $useschema = 'HSIPCORDTA';
}

if($OPT_OPTBAY < 10){
    $sqloptbay = '0'.$OPT_OPTBAY;
} else{
    $sqloptbay = $OPT_OPTBAY;
}

if ($zone == 'LSE') {
    $bayfilter = " and substr(LMLOC#,4,2) = '$sqloptbay' and LMTIER = '" . $TOP_REPLEN_COST_array[$topcostkey]['SUGGESTED_TIER'] . "'";
} else {
    $bayfilter = ' ';
}


$EMPTYGRID_result = $aseriesconn->prepare("SELECT 
                                            DISTINCT LMGRD5, CASE WHEN LMTIER between 'C03' and 'C25' then 'CSE' else LMTIER end as LMTIER, LMHIGH, LMDEEP, LMWIDE, CASE WHEN LMTIER between 'C03' and 'C25' then 'CSE' else LMTIER end||LMGRD5||LMDEEP||CASE WHEN substr(LMTIER,1,1) = 'C' then 1  when  LENGTH(RTRIM(TRANSLATE(substr(LMLOC#,4,2), '*', ' 0123456789'))) = 0  then substr(LMLOC#,4,2) * 1 ELSE 1  end as EMPTYGRID, LMVOL9
                                        FROM
                                            $useschema.NPFLSM
                                        WHERE LMPRIM = 'P' and LMLOCK <> 'H' 
                                        and LMITEM = '' 
                                        and LMWHSE = $var_whse 
                                        and LMLOC# not like 'N%'
                                        and LMLOC# not like 'Q%'
                                        $bayfilter 
                                        ORDER BY LMVOL9 DESC");
$EMPTYGRID_result->execute();
$EMPTYGRID_array = $EMPTYGRID_result->fetchAll(pdo::FETCH_ASSOC);
