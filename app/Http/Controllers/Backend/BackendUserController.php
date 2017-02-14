<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Session\SessionController;
use App\Http\Controllers\User\User2FAController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Permission\PermissionController;

class BackendUserController extends BackendController {

  static function authUser($userid, $password) {
    $twofactor = new User2FAController;
    $user = new UserProfileController;
    $permission = new PermissionController;
    $login = new LoginController;
    if ($twofactor->getUser2FAEnabled($user->getUserIDFromUsername($userid)) == true) {
     echo "590A";
    } else {
      if ($login->authenticate($userid, $password) == true) {
        echo "510A";
      } else {
        echo "520A";
      }
    }
  }

  static function authUser2FA($username, $password, $token) {
    $twofactor = new User2FAController;
    $user = new UserProfileController;
    $permission = new PermissionController;
    $login = new LoginController;
    if ($twofactor->getUser2FAEnabled($user->getUserIDFromUsername($userid)) == true) {
      if ($twofactor->verifyUser2FASecret($user->getUserIDFromUsername($userid), $token) == true) {
        if ($login->authenticate($userid, $password) == true) {
          echo "510A";
        } else {
          echo "520A";
        }
      } else {
        echo "550A";
      }
    } else {
      echo "560A";
  }
}
}
?>
