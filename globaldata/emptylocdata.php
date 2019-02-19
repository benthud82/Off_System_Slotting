<?php

if(!isset($addtlfilter)){
    $addtlfilter = '';
}

include_once '../../globalincludes/usa_asys.php';
include_once '../../globalincludes/newcanada_asys.php';

if ($var_whse == 11 || $var_whse == 12 || $var_whse == 16) {
    $useconn = $aseriesconn_can;
    $useschema = 'ARCPCORDTA';
} else {
    $useconn = $aseriesconn;
    $useschema = 'HSIPCORDTA';
}

$EMPTYLOC_result = $useconn->prepare("SELECT 
                                            CASE WHEN LMTIER between 'C03' and 'C25' then 'CSE' else LMTIER end ||LMGRD5||LMDEEP||CASE WHEN substr(LMTIER,1,1) = 'C' then 1  when  LENGTH(RTRIM(TRANSLATE(substr(LMLOC#,4,2), '*', ' 0123456789'))) = 0  then substr(LMLOC#,4,2) * 1 ELSE 1  end as KEYVAL,
                                            LMWHSE,
                                            LMLOC#,
                                            LMITEM, 
                                            LMPRIM,
                                            LMLOCK,
                                            LMFIXA,
                                            LMFIXT,
                                            LMSTGT,
                                            LMDEEP,
                                            LMHIGH,
                                            LMWIDE,
                                            LMVOL9,
                                            LMTIER,
                                            LMGRD5
                                        FROM
                                            $useschema.NPFLSM
                                        WHERE LMPRIM = 'P' and LMLOCK <> 'H' and LMITEM = '' 
                                        and LMLOC# not like 'N%'
                                        and LMLOC# not like 'Q%'
                                        and LMLOC# not like 'Z%'
                                        and LMWHSE = $var_whse $addtlfilter");  
$EMPTYLOC_result->execute();
$EMPTYLOC_array = $EMPTYLOC_result->fetchAll(pdo::FETCH_ASSOC);