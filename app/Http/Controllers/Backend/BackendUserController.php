<?php
namespace App\Http\Controllers\Backend;

// Meta Classes
use App\Http\Controllers\Controller;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;

// Session Controllers
use App\Http\Controllers\Session\SessionController;

// User Controllers
use App\Http\Controllers\User\User2FAController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserSecretController;
use App\Http\Controllers\User\UserProfileController;

// Permission Controllers
use App\Http\Controllers\Permission\PermissionController;

// Models
use App\Model\UserInvitesModel;

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

  static function authUser2FA($userid, $password, $token) {
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

  static public function checkInviteValid($invitecode) {
    $model = UserInvitesModel::where('securitycode', $invitecode)->first();
    if ($model !== null) {
      if (time() >= $model['expiry']) {
        return "expired";
      } else {
        return "valid";
      }
    } else {
      return "invalid";
    }
  }
}
?>
