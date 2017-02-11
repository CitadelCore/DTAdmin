<?php
function checkUserHasPermission($mysqli, $userid, $permission) {
  $permissionlevel = getUserFromUserID($mysqli, $userid)['permissionlevel'];
    $result = $mysqli->query("SELECT " . $permission . " FROM usergroups WHERE groupname='" . $permissionlevel . "'");
      $grouppermission = $result->fetch_array();
      if ($grouppermission[$permission] == 1) {
        $result->close();
        return true;
      } else {
        $result->close();
        return false;
      }
}

function canUserModifyGroup($mysqli, $userid, $group) {
  $permissionlevel = getUserFromUserID($mysqli, $userid)['permissionlevel'];
  $statement = "SELECT groupid, groupname FROM usergroups WHERE groupname=? LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('s', $group);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($groupid, $groupname);
    $stmt->fetch();
    $statement = "SELECT groupid, groupname FROM usergroups WHERE groupname=? LIMIT 1";
    if ($stmt = $mysqli->prepare($statement)) {
      $stmt->bind_param('s', $permissionlevel);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($groupid2, $groupname2);
      $stmt->fetch();
      if ($groupid2 >= $groupid) {
        return false;
      } else {
        return true;
      }
    } else {
      return false;
    }
  } else {
    return false;
  }
}
?>
