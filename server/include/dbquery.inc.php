<?php
function queryServerDB($mysqli, $serverid) {
  $statement = "SELECT serverid, servername, currentstatus, currentplayercount, timesincelastsd, gamemode, operator, maxraminmb, freeraminmb, cpuusagepercent, ipaddress, hostname, queryportdefault, queryportdtadmin, rconpassword, dtqueryseckey FROM servers WHERE serverid=? LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
  $stmt->bind_param('i', $serverid);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows == 1) {
    $stmt->bind_result($serverid, $servername, $currentstatus, $currentplayercount, $timesincelastsd, $gamemode, $operator, $maxraminmb, $freeraminmb, $cpuusagepercent, $ipaddress, $hostname, $queryportdefault, $queryportdtadmin, $rconpassword, $dtqueryseckey);
    $stmt->fetch();
    return array("serverid"=>$serverid, "servername"=>$servername, "currentstatus"=>$currentstatus, "currentplayercount"=>$currentplayercount, "timesincelastsd"=>$timesincelastsd, "gamemode"=>$gamemode, "operator"=>$operator, "maxraminmb"=>$maxraminmb, "freeraminmb"=>$freeraminmb, "cpuusagepercent"=>$cpuusagepercent, "ipaddress"=>$ipaddress, "hostname"=>$hostname, "queryportdefault"=>$queryportdefault, "queryportdtadmin"=>$queryportdtadmin, "rconpassword"=>$rconpassword, "dtqueryseckey"=>$dtqueryseckey);
  } else {
    return false;
  }
}}

function getOnlineServers($mysqli) {
  $statement = "SELECT * FROM servers WHERE currentstatus='Online' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows;
  } else {
    return 0;
  }
}
 ?>
