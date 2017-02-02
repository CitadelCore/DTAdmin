<?php

// User secret key management

function queryUserSecret($mysqli, $secret) {
  if ($stmt2 = $mysqli->prepare("SELECT userid, secretkey
                                 FROM usersecrets
                                 WHERE secretkey=?
                                 LIMIT 1")) {
      $stmt2->bind_param('s', $secret);
      $stmt2->execute();
      $stmt2->store_result();
      if ($stmt2->num_rows == 1) {
        $stmt2->bind_result($userid, $secretkey);
        $stmt2->fetch();
        if (checkUserDisabled($mysqli, $userid) == false) {
          return "accepted";
        } else {
          return "denied";
        }
      } else {
        return "denied";
      }
}
}

function deleteUserSecret($mysqli, $secretid, $userid) {
  $statement = "SELECT * FROM usersecrets WHERE secretid='" . $secretid . "' AND userid='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->execute();
    $stmt->store_result();
      if ($stmt->num_rows == 1) {
        $statement = "DELETE FROM usersecrets WHERE secretid='" . $secretid . "' AND userid='" . $userid . "' LIMIT 1";
        if ($stmt = $mysqli->prepare($statement)) {
        $stmt->execute();
        $stmt->store_result();
        }
      }
    }
}

function deleteAllUserSecrets($mysqli, $userid) {
  $statement = "SELECT * FROM usersecrets WHERE userid='" . $userid . "'";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->execute();
    $stmt->store_result();
      if ($stmt->num_rows == 1) {
        $statement = "DELETE FROM usersecrets WHERE userid='" . $userid . "'";
        if ($stmt = $mysqli->prepare($statement)) {
        $stmt->execute();
        $stmt->store_result();
        }
      }
    }
}

function createUserSecret($mysqli, $keynote, $userid) {
  $date = date('Y-m-d h:i:s');
  $randkey = getRandomString(50);
  $statement = "INSERT INTO usersecrets VALUES(NULL, $userid, '$randkey', '$keynote ', '$date')";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->execute();
    $stmt->store_result();
  }
}

// User data functions

function getUserFromUserID($mysqli, $id) {
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
    return $mysqli->error;
  }
}

function checkUserDisabled($mysqli, $userid) {
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

function checkUserIDExists($mysqli, $userid) {
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

function checkUsernameExists($mysqli, $username) {
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

function checkEmailExists($mysqli, $email) {
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

function checkPasswordHashExists($mysqli, $passwordhash) {
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

// User account functions

function updateUserProfile($mysqli, $userid, $updatedata) {
if (isset($updatedata["passwordhash"])) { updateUserProfileData($mysqli, $userid, "password", htmlspecialchars($updatedata["passwordhash"])); }
if (isset($updatedata["firstname"])) { updateUserProfileData($mysqli, $userid, "firstname", htmlspecialchars($updatedata["firstname"])); }
if (isset($updatedata["lastname"])) { updateUserProfileData($mysqli, $userid, "lastname", htmlspecialchars($updatedata["lastname"])); }
if (isset($updatedata["email"])) { updateUserProfileData($mysqli, $userid, "email", htmlspecialchars($updatedata["email"])); }
if (isset($updatedata["disabled"])) { updateUserProfileData($mysqli, $userid, "disabled", htmlspecialchars($updatedata["disabled"])); }
if (isset($updatedata["permissionlevel"])) { updateUserProfileData($mysqli, $userid, "permissionlevel", htmlspecialchars($updatedata["permissionlevel"])); }
}

function updateUserProfileData($mysqli, $userid, $varname, $vardata) {
  if ($stmt = $mysqli->prepare("UPDATE members
                                SET $varname='$vardata'
                                WHERE id=?")) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    return true;
  } else {
    return false;
  }
}

function createUserProfile($mysqli, $createdata) {
  $passwordhash = $createdata["passwordhash"];
  $username = $createdata["username"];
  $firstname = $createdata["firstname"];
  $lastname = $createdata["lastname"];
  $email = $createdata["email"];
  $disabled = $createdata["disabled"];
  $permissionlevel = "user";
  // Final conflict checking, just in case.
  if(checkPasswordHashExists($mysqli, $updatedata["passwordhash"]) == false) {
    if(checkEmailExists($mysqli, $updatedata["email"]) == false) {
      if(checkUsernameExists($mysqli, $updatedata["username"]) == false) {
        if ($stmt = $mysqli->prepare("INSERT INTO members
                                      VALUES (NULL, '$username', '$passwordhash', '$permissionlevel', '$firstname', '$lastname', '$email', '$disabled')")) {
          $stmt->execute();
          $stmt->store_result();
          return true;
        } else {
          return false;
        }
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

function deleteUserProfile($mysqli, $userid) {
  deleteAllUserSecrets($mysqli, $userid);
  $statement = "SELECT * FROM members WHERE id='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->execute();
    $stmt->store_result();
      if ($stmt->num_rows == 1) {
        $statement = "DELETE FROM members WHERE id='" . $userid . "' LIMIT 1";
        if ($stmt = $mysqli->prepare($statement)) {
        $stmt->execute();
        $stmt->store_result();
        }
      }
    }
}

function setUserDisabled($mysqli, $userid, $disabled) {
  if ($stmt = $mysqli->prepare("UPDATE members
                                SET disabled='$disabled'
                                WHERE id=?")) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    return true;
  } else {
    return false;
  }
}

?>
