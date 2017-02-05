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
?>
