<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\UserController as UserController;
use App\Model\MembersModel;

class UserProfileController extends UserController {
  static public function UpdateUserProfile($userid, $updatedata) {
    if (isset($updatedata["passwordhash"])) { if(strlen($updatedata["passwordhash"]) >= 1) { UserProfileController::updateUserProfileData($userid, "password", htmlspecialchars($updatedata["passwordhash"])); }}
    if (isset($updatedata["username"])) { if(strlen($updatedata["username"]) >= 1) { UserProfileController::updateUserProfileData($userid, "userid", htmlspecialchars($updatedata["username"])); }}
    if (isset($updatedata["firstname"])) { if(strlen($updatedata["firstname"]) >= 1) { UserProfileController::updateUserProfileData($userid, "firstname", htmlspecialchars($updatedata["firstname"])); }}
    if (isset($updatedata["lastname"])) { if(strlen($updatedata["lastname"]) >= 1) { UserProfileController::updateUserProfileData($userid, "lastname", htmlspecialchars($updatedata["lastname"])); }}
    if (isset($updatedata["email"])) { if(UserProfileController::verifyUpdateEmail($updatedata["email"]) == true) { if(strlen($updatedata["email"]) >= 1) { UserProfileController::updateUserProfileData($userid, "email", htmlspecialchars($updatedata["email"])); }}}
    if (isset($updatedata["disabled"])) { UserProfileController::updateUserProfileData($userid, "disabled", htmlspecialchars($updatedata["disabled"])); }
    if (isset($updatedata["permissionlevel"])) { UserProfileController::updateUserProfileData($userid, "permissionlevel", htmlspecialchars($updatedata["permissionlevel"])); }
  }

  static public function updateUserProfileData($userid, $value, $data) {
    $model = MembersModel::where('id', $userid)->first();
    $model->$value = $data;
    $model->save();
  }

  static public function verifyUpdateEmail($address) {
    $split = explode("@", $address);
    if (count($split) == 1) {
      return false;
    } else {
      if ($split[1] == "towerdevs.xyz") {
        return true;
      } else {
        return false;
      }
    }
  }

  static public function createUserProfile($createdata) {
    $model = new MembersModel;
    if (checkPasswordHashExists($createdata['passwordhash']) == false) {
      if (checkEmailExists($createdata['email']) == false) {
        if (checkUsernameExists($createdata['username']) == false) {
          //if (verifyUpdateEmail($createdata['email']) == true) {
            $model->passwordhash = $createdata['passwordhash'];
            $model->username = $createdata['username'];
            $model->firstname = $createdata['firstname'];
            $model->lastname = $createdata['lastname'];
            $model->email = $createdata['email'];
            $model->disabled = $createdata['disabled'];
            $model->permissionlevel = "user";
            $model->save();
            return true;
          //} else {
          //  return false;
          //}
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  static public function deleteUserProfile($userid) {
    MailController::sendAccountDeletedMail(Auth::id());
    UserSecretController::deleteAllUserSecrets($userid);
    $model = MembersModel::where('id', $userid)->first();
    if ($model !== null) {
      $model->delete();
      return true;
    } else {
      return false;
    }
  }

  static public function verifyUser($userid) {
    UserProfileController::setUserDisabled($userid, 0);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    MailController::sendAccountVerifiedMail(Auth::id());
  }

  static public function lockUser($userid, $lockedip) {
    UserProfileController::setUserDisabled($userid, 1);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    MailController::sendAccountLockedMail(Auth::id());
  }

  static public function disableUser($userid) {
    UserProfileController::setUserDisabled($userid, 1);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    MailController::sendAccountDisabledMail(Auth::id());
  }

  static public function unlockUser($userid) {
    UserProfileController::setUserDisabled($userid, 0);
    $model = LoginAttemptsModel::where('user_id', $userid)->get();
    $model->delete();
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    MailController::sendAccountUnlockedMail(Auth::id());

  }

  static public function enableUser($userid) {
    UserProfileController::setUserDisabled($userid, 0);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    MailController::sendAccountEnabledMail(Auth::id());
  }

  static public function setUserDisabled($userid, $disabled) {
    $model = MembersModel::where('id', $userid);
    $model->disabled = $disabled;
    $model->save();
  }
}
?>
