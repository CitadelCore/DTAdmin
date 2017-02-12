<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\UserController as UserController;

class UserSecretController extends UserController {
  public function queryUserSecret($mysqli, $secret) {
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

  public function deleteUserSecret($mysqli, $secretid, $userid) {
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

  public function deleteAllUserSecrets($mysqli, $userid) {
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

  public function createUserSecret($mysqli, $keynote, $userid) {
    $date = date('Y-m-d h:i:s');
    $randkey = getRandomString(50);
    $statement = "INSERT INTO usersecrets VALUES(NULL, $userid, '$randkey', '$keynote ', '$date')";
    if ($stmt = $mysqli->prepare($statement)) {
      $stmt->execute();
      $stmt->store_result();
    }
  }
}

?>
