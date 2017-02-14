<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\MembersModel;
use App\Model\UserInvitesModel;

class UserController extends Controller {

public function getUserFromUserID($id) {
  $model = MembersModel::where('id', $id)->first();
  if ($model !== null) {
    return $model;
  } else {
    return false;
  }
}

public function getUserIDFromUsername($username) {
  $model = MembersModel::where('user', $username)->first();
  if ($model !== null) {
    return $model;
  } else {
    return false;
  }
}

public function checkUserDisabled($userid) {
  $model = MembersModel::where('id', $userid)->where('disabled', 1)->first();
  if ($model !== null) {
    return true;
  } else {
    return false;
  }
}

public function checkUserIDExists($userid) {
  $model = MembersModel::where('id', $userid)->first();
  if ($model !== null) {
    return true;
  } else {
    return false;
  }
}

public function checkUsernameExists($username) {
  $model = MembersModel::where('user', $username)->first();
  if ($model !== null) {
    return true;
  } else {
    return false;
}}

public function checkEmailExists($email) {
  $model = MembersModel::where('email', $email)->first();
  if ($model !== null) {
    return true;
  } else {
    return false;
}}

public function checkPasswordHashExists($passwordhash) {
  $model = MembersModel::where('password', $passwordhash)->first();
  if ($model !== null) {
    return true;
  } else {
    return false;
}}

public function checkInviteValid($invitecode) {
  $model = UserInvitesModel::where('securitycode', $invitecode)->first();
  if ($model !== null) {
    $expiry = $model['expiry'];
    if (time() >= $expiry) {
      return "expired";
    } else {
      return "valid";
    }
  } else {
    return "invalid";
}}

}

?>
