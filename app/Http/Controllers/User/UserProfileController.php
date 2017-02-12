<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\UserController as UserController;

class UserProfileController extends UserController {
  public function updateUserProfile($mysqli, $userid, $updatedata) {
  if (isset($updatedata["passwordhash"])) { if(strlen($updatedata["passwordhash"]) >= 1) {updateUserProfileData($mysqli, $userid, "password", htmlspecialchars($updatedata["passwordhash"])); }}
  if (isset($updatedata["username"])) { if(strlen($updatedata["username"]) >= 1) { updateUserProfileData($mysqli, $userid, "userid", htmlspecialchars($updatedata["username"])); }}
  if (isset($updatedata["firstname"])) { if(strlen($updatedata["firstname"]) >= 1) { updateUserProfileData($mysqli, $userid, "firstname", htmlspecialchars($updatedata["firstname"])); }}
  if (isset($updatedata["lastname"])) { if(strlen($updatedata["lastname"]) >= 1) { updateUserProfileData($mysqli, $userid, "lastname", htmlspecialchars($updatedata["lastname"])); }}
  if (isset($updatedata["email"])) { if(verifyUpdateEmail($updatedata["email"]) == true) { if(strlen($updatedata["email"]) >= 1) { updateUserProfileData($mysqli, $userid, "email", htmlspecialchars($updatedata["email"])); }}}
  if (isset($updatedata["disabled"])) { updateUserProfileData($mysqli, $userid, "disabled", htmlspecialchars($updatedata["disabled"])); }
  if (isset($updatedata["permissionlevel"])) { updateUserProfileData($mysqli, $userid, "permissionlevel", htmlspecialchars($updatedata["permissionlevel"])); }
  }

  private function verifyUpdateEmail($address) {
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

  private function updateUserProfileData($mysqli, $userid, $varname, $vardata) {
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

  public function createUserProfile($mysqli, $createdata) {
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

  public function deleteUserProfile($mysqli, $userid) {
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

  public function verifyUser($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    setUserDisabled($mysqli, $userid, 0);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    sendAccountVerifiedMail($mysqli, $userid);
  }

  public function lockUser($mysqli, $userid, $lockedip) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    setUserDisabled($mysqli, $userid, 1);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    sendAccountLockedMail($mysqli, $userid, $lockedip);
  }

  public function disableUser($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    setUserDisabled($mysqli, $userid, 1);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    sendAccountDisabledMail($mysqli, $userid);
  }

  public function unlockUser($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    setUserDisabled($mysqli, $userid, 0);
    $mysqli->query("DELETE FROM login_attempts WHERE user_id = $userid");
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    sendAccountUnlockedMail($mysqli, $userid);

  }

  public function enableUser($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    setUserDisabled($mysqli, $userid, 0);
    //fastcgi_finish_request(); // won't work until FastCGI is installed
    sendAccountEnabledMail($mysqli, $userid);
  }

  private function setUserDisabled($mysqli, $userid, $disabled) {
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
}
?>
