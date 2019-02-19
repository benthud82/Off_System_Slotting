<?php

mysql_connect('ustxgpl4307w10.us.hsi.local', 'bentley', 'dave41');
$res = mysql_query("SHOW FULL PROCESSLIST");
while ($row=mysql_fetch_array($res)) {
  $pid=$row["Id"];
  if ($row['Command']=='Sleep') {
      if ($row["Time"] > 3 ) { //any sleeping process more than 3 secs
         $sql="KILL $pid";
         echo "\n$sql"; //added for log file
         mysql_query($sql);
      }
  }
}

//mysql_connect('nahsifljaws01', 'slotadmin', 'slotadmin');
//$res = mysql_query("SHOW FULL PROCESSLIST");
//while ($row=mysql_fetch_array($res)) {
//  $pid=$row["Id"];
//  if ($row['Command']=='Sleep') {
//      if ($row["Time"] > 3 ) { //any sleeping process more than 3 secs
//         $sql="KILL $pid";
//         echo "\n$sql"; //added for log file
//         mysql_query($sql);
//      }
//  }
//}