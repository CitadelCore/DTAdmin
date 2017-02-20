<?php

namespace App\Http\Controllers\Mail;

// Meta Classes
use App\Http\Controllers\Controller;

// User Controllers
use App\Http\Controllers\User\UserController;

// Facades
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {
  static public function sendAccountVerifiedMail($userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/verified', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Account verified", "titledetail"=>"Your account has been verified.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Account verified');
    });
  }

  static public function sendAccountDisabledMail($userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/disabled', ["firstname" => $firstname, "lastname" => $lastname, "title" => "Account disabled", "titledetail" => "Your account has been disabled.", "ident" => MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Account disabled');
    });
  }

  static public function sendAccountEnabledMail($userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/enabled', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Account enabled", "titledetail"=>"Your account has been enabled.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Account enabled');
    });
  }

  static public function sendAccountLockedMail($userid, $lockedip) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/locked', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Account locked", "titledetail"=>"Your account has been locked.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Account locked');
    });
  }

    static public function sendAccountUnlockedMail($userid) {
      $user = new UserController;
      $userinfo = $user->getUserFromUserID($userid);
      $email = $userinfo["email"];
      $firstname = $userinfo["firstname"];
      $lastname = $userinfo["lastname"];
      Mail::send('layouts/mail/unlocked', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Account unlocked", "titledetail"=>"Your account has been unlocked.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
        $message->to("$email", "$firstname $lastname")->subject('Account unlocked');
      });
  }

  static public function sendAccountDeletedMail($userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/deleted', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Account deleted", "titledetail"=>"Your account has been deleted.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Account deleted');
    });
  }

  static public function sendAccountWaitMail($email, $firstname, $lastname, $passwordhash) {
    $user = new UserController;
    $passstring = $email . $firstname . $lastname . $passwordhash;
    $ident = hash('crc32', $passstring);
    $subject = "Account pending verification";
    Mail::send('layouts/mail/verified', ["title"=>"Account pending verification", "titledetail"=>"Your account is being verified.", "ident"=>hash('crc32', $passstring)], function($message) {
      $message->to("$email", "$firstname $lastname")->subject('Account pending verification');
    });
  }

  static public function sendAccountAutoconfirmMail($mysqli, $email, $firstname, $lastname, $passwordhash) {
    $user = new UserController;
    $passstring = $email . $firstname . $lastname . $passwordhash;
    $ident = hash('crc32', $passstring);
    $subject = "Account created";
    Mail::send('layouts/mail/autoconfirm', ["title"=>"Account created", "titledetail"=>"Your account has been created.", "ident"=>hash('crc32', $passstring)], function($message) {
      $message->to("$email", "$firstname $lastname")->subject('Account created');
    });
  }

  static public function sendAccount2FAEnabledMail($mysqli, $userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/deleted', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Multi-Factor Enabled", "titledetail"=>"Multi-factor authentication has been enabled.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Multi-Factor Enabled');
    });
  }

  static public function sendAccount2FADisabledMail($mysqli, $userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    Mail::send('layouts/mail/deleted', ["firstname"=>$firstname, "lastname"=>$lastname, "title"=>"Multi-Factor Disabled", "titledetail"=>"Multi-factor authentication has been disabled.", "ident"=>MailController::hashMailIdent($userid)], function($message) use ($email, $firstname, $lastname) {
      $message->to("$email", "$firstname $lastname")->subject('Multi-Factor Disabled');
    });
  }

  static public function hashMailIdent($userid) {
    $user = new UserController;
    $userinfo = $user->getUserFromUserID($userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    $password = $userinfo["password"];
    //$time = date(DATE_ATOM);
    $passstring = $email . $firstname . $lastname . $password;
    $passkey = hash('crc32', $passstring);
    return $passkey;
  }
}
?>
