<?php
namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserProfileController;
use App\Model\MembersModel;
use App\Model\UserGroupsModel;

class PermissionController extends Controller {
  static function checkUserHasPermission($userid, $permission) {
    $user = new UserProfileController;
    $permissionlevel = $user->getUserFromUserID($userid['id'])['permissionlevel'];
    $model = UserGroupsModel::where('groupname', $permissionlevel)->get()->first();
    if ($model[$permission] == 1) {
      return true;
    } else {
      return false;
    }
  }

  static function canUserModifyGroup($userid, $group) {
    $user = new UserProfileController;
    $permissionlevel = $user->getUserFromUserID($userid['id'])['permissionlevel'];
    $model = UserGroupsModel::where('groupname', $group)->get()->first();
    $model2 = UserGroupsModel::where('groupname', $permissionlevel)->get()->first();
    if ($model['groupid'] >= $model2['groupid']) {
      return false;
    } else {
      return true;
    }
  }
}
?>
