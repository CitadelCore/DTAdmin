<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller {

// Imports

use OTPHP\TOTP;                                  // OTPHP TOTP
use OTPHP\HOTP;                                  // OTPHP HOTP
use OTPHP\Factory;                               // OTPHP Factory
use Base32\Base32;                               // Base32

// User data functions

public function getUserFromUserID($mysqli, $id) {
  $statement = "SELECT id, userid, password, permissionlevel, firstname, lastname, email, disabled FROM members WHERE id=? LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($id, $userid, $password, $permissionlevel, $firstname, $lastname, $email, $disabled);
      $stmt->fetch();
      return array("id"=>$id, "userid"=>$userid, "password"=>$password, "permissionlevel"=>$permissionlevel, "firstname"=>$firstname, "lastname"=>$lastname, "email"=>$email, "disabled"=>$disabled);
    } else {
      return false;
    }
  } else {
    return false;
  }
}

public function getUserIDFromUsername($mysqli, $username) {
  $statement = "SELECT id FROM members WHERE userid=? LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($id);
      $stmt->fetch();
      return $id;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

public function checkUserDisabled($mysqli, $userid) {
  if ($stmt = $mysqli->prepare("SELECT * FROM members WHERE id=? AND disabled=? LIMIT 1")) {
      $truefalse = 1;
      $stmt->bind_param('ii', $userid, $truefalse);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        return true;
      } else {
        return false;
      }
    }
}

public function checkUserIDExists($mysqli, $userid) {
  if ($stmt = $mysqli->prepare("SELECT * FROM members WHERE id=? LIMIT 1")) {
      $stmt->bind_param('i', $userid);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        return true;
      } else {
        return false;
      }
    }
}

public function checkUsernameExists($mysqli, $username) {
  if ($stmt = $mysqli->prepare("SELECT * FROM members WHERE user_id=? LIMIT 1")) {
      $stmt->bind_param('s', $user_id);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        return true;
      } else {
        return false;
      }
    }
}

public function checkEmailExists($mysqli, $email) {
  if ($stmt = $mysqli->prepare("SELECT * FROM members WHERE email=? LIMIT 1")) {
      $stmt->bind_param('s', $email);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        return true;
      } else {
        return false;
      }
    }
}

public function checkPasswordHashExists($mysqli, $passwordhash) {
  if ($stmt = $mysqli->prepare("SELECT * FROM members WHERE passwordhash=? LIMIT 1")) {
      $stmt->bind_param('s', $passwordhash);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        return true;
      } else {
        return false;
      }
    }
}

public function checkInviteValid($mysqli, $invitecode) {
  if ($stmt = $mysqli->prepare("SELECT expiry FROM userinvites WHERE securitycode=? LIMIT 1")) {
      $stmt->bind_param('s', $invitecode);
      $stmt->execute();
      $stmt->bind_result($expiry);
      $stmt->fetch();
      if ($stmt->num_rows == 1) {
        if (time() >= $expiry) {
          return "expired";
        } else {
          return "valid";
        }
      } else {
        return "invalid";
      }
    }
}

// Multi Factor



}

?>
