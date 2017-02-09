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
    return false;
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

function checkInviteValid($mysqli, $invitecode) {
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

// User account functions

function updateUserProfile($mysqli, $userid, $updatedata) {
if (isset($updatedata["passwordhash"])) { if(strlen($updatedata["passwordhash"]) >= 1) {updateUserProfileData($mysqli, $userid, "password", htmlspecialchars($updatedata["passwordhash"])); }}
if (isset($updatedata["username"])) { if(strlen($updatedata["username"]) >= 1) { updateUserProfileData($mysqli, $userid, "userid", htmlspecialchars($updatedata["username"])); }}
if (isset($updatedata["firstname"])) { if(strlen($updatedata["firstname"]) >= 1) { updateUserProfileData($mysqli, $userid, "firstname", htmlspecialchars($updatedata["firstname"])); }}
if (isset($updatedata["lastname"])) { if(strlen($updatedata["lastname"]) >= 1) { updateUserProfileData($mysqli, $userid, "lastname", htmlspecialchars($updatedata["lastname"])); }}
if (isset($updatedata["email"])) { if(verifyUpdateEmail($updatedata["email"]) == true) { if(strlen($updatedata["email"]) >= 1) { updateUserProfileData($mysqli, $userid, "email", htmlspecialchars($updatedata["email"])); }}}
if (isset($updatedata["disabled"])) { updateUserProfileData($mysqli, $userid, "disabled", htmlspecialchars($updatedata["disabled"])); }
if (isset($updatedata["permissionlevel"])) { updateUserProfileData($mysqli, $userid, "permissionlevel", htmlspecialchars($updatedata["permissionlevel"])); }
}

function verifyUpdateEmail($address) {
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

function updateUserProfileData($mysqli, $userid, $varname, $vardata) {
  if ($stmt = $mysqli->prepare("UPDATE members
                                SET $varname=?
                                WHERE id=?")) {
    $stmt->bind_param('si', $vardata, $userid);
    $varname = mysqli_real_escape_string($mysqli, $varname);
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $vardata = mysqli_real_escape_string($mysqli, $vardata);
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
  if(test_data($passwordhash) == true) {
    if(test_data($username) == true) {
      if(test_data($firstname) == true) {
        if(test_data($lastname) == true) {
          if(test_data($email) == true) {
              // Final conflict checking, just in case.
              if(checkPasswordHashExists($mysqli, $createdata["passwordhash"]) == false) {
                if(checkEmailExists($mysqli, $createdata["email"]) == false) {
                  if(checkUsernameExists($mysqli, $createdata["username"]) == false) {
                    //if(verifyUpdateEmail($email) == true) {
                    // Disabled temporarily while staff migrate to TOWER emails
                      if ($stmt = $mysqli->prepare("INSERT INTO members
                                                    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)")) {
                        $stmt->bind_param('ssssssi', $username, $passwordhash, $permissionlevel, $firstname, $lastname, $email, $disabled);
                        $passwordhash = mysqli_real_escape_string($mysqli, $passwordhash);
                        $username = mysqli_real_escape_string($mysqli, $username);
                        $firstname = mysqli_real_escape_string($mysqli, $firstname);
                        $lastname = mysqli_real_escape_string($mysqli, $lastname);
                        $email = mysqli_real_escape_string($mysqli, $email);
                        $disabled = mysqli_real_escape_string($mysqli, $disabled);
                        $stmt->execute();
                        $stmt->store_result();
                        return true;
                    //  } else {
                        return false;
                    //  }
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
          } else { return false; }
        } else {return false; }
      } else {return false; }
    } else {return false; }
  } else {return false; }
}

function deleteUserProfile($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  sendAccountDeletedMail($mysqli, $userid);
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

function verifyUser($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  setUserDisabled($mysqli, $userid, 0);
  //fastcgi_finish_request(); // won't work until FastCGI is installed
  sendAccountVerifiedMail($mysqli, $userid);
}

function lockUser($mysqli, $userid, $lockedip) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  setUserDisabled($mysqli, $userid, 1);
  //fastcgi_finish_request(); // won't work until FastCGI is installed
  sendAccountLockedMail($mysqli, $userid, $lockedip);
}

function disableUser($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  setUserDisabled($mysqli, $userid, 1);
  //fastcgi_finish_request(); // won't work until FastCGI is installed
  sendAccountDisabledMail($mysqli, $userid);
}

function unlockUser($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  setUserDisabled($mysqli, $userid, 0);
  $mysqli->query("DELETE FROM login_attempts WHERE user_id = $userid");
  //fastcgi_finish_request(); // won't work until FastCGI is installed
  sendAccountUnlockedMail($mysqli, $userid);

}

function enableUser($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  setUserDisabled($mysqli, $userid, 0);
  //fastcgi_finish_request(); // won't work until FastCGI is installed
  sendAccountEnabledMail($mysqli, $userid);
}

function setUserDisabled($mysqli, $userid, $disabled) {
  $disabled= mysqli_real_escape_string($mysqli, $disabled);
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

// Multi Factor

function createUser2FASecret($mysqli, $userid) {
$userid = mysqli_real_escape_string($mysqli, $userid);
$secure = random_bytes(256);
$secure = Base32::encode($secure);
$email = getUserFromUserID($mysqli, $userid)['email'];

$totp = new TOTP(
    "$email",
    "$secure"
);

$totp->setParameter('image', 'https://localhost/dtadmin/assets/logo.png');
$tokenuri = $totp->getProvisioningUri();
$qrcodeuri = $totp->getQrCodeUri();

$stmt = $mysqli->prepare("INSERT INTO 2fa VALUES (NULL, ?, ?, ?, ?)");
  $stmt->bind_param('isss', $userid, $secure, $tokenuri, $qrcodeuri);
  $stmt->execute();
  $stmt->store_result();
}

function verifyUser2FASecret($mysqli, $userid, $token) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  $statement = "SELECT * FROM 2fa WHERE userid='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($tokenid, $userid, $sharedsecret, $tokenuri, $qrcodeuri);
      $stmt->fetch();

      $email = getUserFromUserID($mysqli, $userid)['email'];
      $totp = new TOTP(
          "$email",
          "$sharedsecret"
        );
      if ($totp->verify($token) == true) {
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
}

function getUser2FAEnabled($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  $statement = "SELECT * FROM 2fa WHERE userid='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function getUser2FAProvisioning($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  $statement = "SELECT * FROM 2fa WHERE userid='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($tokenid, $userid, $sharedsecret, $tokenuri, $qrcodeuri);
      $stmt->fetch();
        return $tokenuri;
      } else {
        return false;
      }
    } else {
      return false;
    }
}

function invalidateUser2FAToken($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  $statement = "SELECT * FROM 2fa WHERE userid='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $mysqli->query("DELETE FROM 2fa WHERE userid = $userid");
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
}

function getUser2FAQrcode($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  $statement = "SELECT * FROM 2fa WHERE userid='" . $userid . "' LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($tokenid, $userid, $sharedsecret, $tokenuri, $qrcodeuri);
      $stmt->fetch();
        return $qrcodeuri;
      } else {
        return false;
      }
    } else {
      return false;
    }
}

function enableUser2FA($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  if (getUser2FAEnabled($mysqli, $userid) == false) {
    createUser2FASecret($mysqli, $userid);
    sendAccount2FAEnabledMail($mysqli, $userid);
    return true;
  } else {
    return false;
  }
}

function disableUser2FA($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  if (getUser2FAEnabled($mysqli, $userid) == true) {
    invalidateUser2FAToken($mysqli, $userid);
    sendAccount2FADisabledMail($mysqli, $userid);
    return true;
  } else {
    return false;
  }
}

?>
