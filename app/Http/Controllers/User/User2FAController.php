<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\UserController as UserController;
use App\Model\TwoFactorModel;

class User2FAController extends UserController {
  private function createUser2FASecret($userid) {
  $secure = random_bytes(256);
  $securecrypt = Base32::encode($secure);
  $email = getUserFromUserID($userid)['email'];
  $twofactor = new TwoFactorModel;

  $totp = new TOTP(
      "$email",
      NULL
  );

  $totp->setParameter('image', 'https://localhost/dtadmin/assets/logo.png');
  $totp->setIssuer('DTAdmin');
  $tokenuri = $totp->getProvisioningUri();
  $qrcodeuri = $totp->getQrCodeUri();
  $sharedsecret = $totp->getSecret();

  $twofactor->userid = $userid;
  $twofactor->sharedsecret = $sharedsecret;
  $twofactor->tokenuri = $tokenuri;
  $twofactor->qrcodeuri = $qrcodeuri;

  $twofactor->save();
  }

  public function verifyUser2FASecret($userid, $token) {
    $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        $email = getUserFromUserID($userid)['email'];
        $sharedsecret = $twofactor['sharedsecret'];
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
  }

  public function getUser2FAExists($userid) {
    $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        return true;
      } else {
        return false;
      }
  }

  public function getUser2FAEnabled($userid) {
    $twofactor = TwoFactorModel::where('userid', $userid)->where('disabled', 0)->first();
      if ($twofactor !== null) {
        return true;
      } else {
        return false;
      }
  }

  public function getUser2FAProvisioning($userid) {
    $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        return $twofactor['tokenuri'];
      } else {
        return false;
      }
  }

  public function invalidateUser2FAToken($userid) {
    $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        $twofactor->delete();
        return true;
      } else {
        return false;
      }
  }

  public function getUser2FAQrcode($userid) {
    $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        return $twofactor['qrcodeuri'];
      } else {
        return false;
      }
  }

  public function activateUser2FA($userid) {
    if (getUser2FAEnabled($userid) == false) {
      invalidateUser2FAToken($userid);
      createUser2FASecret($userid);
      return true;
    } else {
      return false;
    }
  }

  public function deactivateUser2FA($userid) {
    if (getUser2FAEnabled($userid) == true) {
      invalidateUser2FAToken($userid);
      MailController::sendAccount2FADisabled(Auth::id());
      return true;
    } else {
      return false;
    }
  }

  public function enableUser2FA($userid) {
    if (getUser2FAEnabled($userid) == false) {
      $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        $twofactor->disabled = 0;
        $twofactor->save();

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function disableUser2FA($userid) {
    if (getUser2FAEnabled($userid) == true) {
      $twofactor = TwoFactorModel::where('userid', $userid)->first();
      if ($twofactor !== null) {
        $twofactor->disabled = 1;
        $twofactor->save();

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
}
}
?>
