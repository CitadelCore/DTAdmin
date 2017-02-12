<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\UserController as UserController;

class User2FAController extends UserController {
  private function createUser2FASecret($mysqli, $userid) {
  $userid = mysqli_real_escape_string($mysqli, $userid);
  $secure = random_bytes(256);
  $securecrypt = Base32::encode($secure);
  $email = getUserFromUserID($mysqli, $userid)['email'];

  $totp = new TOTP(
      "$email",
      NULL
  );

  $totp->setParameter('image', 'https://localhost/dtadmin/assets/logo.png');
  $totp->setIssuer('DTAdmin');
  $tokenuri = $totp->getProvisioningUri();
  $qrcodeuri = $totp->getQrCodeUri();
  $sharedsecret = $totp->getSecret();

  if ($stmt = $mysqli->prepare("INSERT INTO 2fa VALUES (NULL, ?, ?, ?, ?, 1)")) {
    $stmt->bind_param('isss', $userid, $sharedsecret, $tokenuri, $qrcodeuri);
    $stmt->execute();
    $stmt->store_result();
    return true;
  } else {
    return false;
  }}

  public function verifyUser2FASecret($mysqli, $userid, $token) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $statement = "SELECT * FROM 2fa WHERE userid=? LIMIT 1";
    if ($stmt = $mysqli->prepare($statement)) {
      $stmt->bind_param('i', $userid);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        $stmt->bind_result($tokenid, $userid, $sharedsecret, $tokenuri, $qrcodeuri, $disabled);
        $stmt->fetch();

        $email = getUserFromUserID($mysqli, $userid)['email'];
        $totp = new TOTP(
            "$email",
            "$sharedsecret"
          );
          $totp->now();
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

  public function getUser2FAExists($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $statement = "SELECT * FROM 2fa WHERE userid=? LIMIT 1";
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

  public function getUser2FAEnabled($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $statement = "SELECT * FROM 2fa WHERE userid=? AND disabled=0 LIMIT 1";
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

  public function getUser2FAProvisioning($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $statement = "SELECT * FROM 2fa WHERE userid=? LIMIT 1";
    if ($stmt = $mysqli->prepare($statement)) {
      $stmt->bind_param('i', $userid);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        $stmt->bind_result($tokenid, $userid, $sharedsecret, $tokenuri, $qrcodeuri, $disabled);
        $stmt->fetch();
          return $tokenuri;
        } else {
          return false;
        }
      } else {
        return false;
      }
  }

  public function invalidateUser2FAToken($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $statement = "SELECT * FROM 2fa WHERE userid=? LIMIT 1";
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

  public function getUser2FAQrcode($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    $statement = "SELECT * FROM 2fa WHERE userid=? LIMIT 1";
    if ($stmt = $mysqli->prepare($statement)) {
      $stmt->bind_param('i', $userid);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows == 1) {
        $stmt->bind_result($tokenid, $userid, $sharedsecret, $tokenuri, $qrcodeuri, $disabled);
        $stmt->fetch();
          return $qrcodeuri;
        } else {
          return false;
        }
      } else {
        return false;
      }
  }

  public function activateUser2FA($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    if (getUser2FAEnabled($mysqli, $userid) == false) {
      invalidateUser2FAToken($mysqli, $userid);
      createUser2FASecret($mysqli, $userid);
      return true;
    } else {
      return false;
    }
  }

  public function deactivateUser2FA($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    if (getUser2FAEnabled($mysqli, $userid) == true) {
      invalidateUser2FAToken($mysqli, $userid);
      sendAccount2FADisabledMail($mysqli, $userid);
      return true;
    } else {
      return false;
    }
  }

  public function enableUser2FA($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    if (getUser2FAEnabled($mysqli, $userid) == false) {
      if ($stmt = $mysqli->prepare("UPDATE 2fa
                                    SET disabled=0
                                    WHERE userid=?")) {
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $stmt->store_result();
        sendAccount2FAEnabledMail($mysqli, $userid);
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function disableUser2FA($mysqli, $userid) {
    $userid = mysqli_real_escape_string($mysqli, $userid);
    if (getUser2FAEnabled($mysqli, $userid) == true) {
      if ($stmt = $mysqli->prepare("UPDATE 2fa
                                    SET disabled=1
                                    WHERE id=?")) {
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $stmt->store_result();
        return true;
      } else {
        return false;
      }
      return true;
    } else {
      return false;
    }
  }
}
?>
