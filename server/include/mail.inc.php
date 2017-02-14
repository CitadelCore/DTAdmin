<?php
function mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname) {

  $mail = new PHPMailer;
  $mail->isSMTP();
  //$mail->SMTPDebug = 3;
  $mail->Host = getMailVars($mysqli)["hostname"];
  $mail->SMTPAuth = (bool)getMailVars($mysqli)["authenticated"];
  $mail->Username = getMailVars($mysqli)["username"];
  $mail->Password = getMailVars($mysqli)["password"];
  $mail->SMTPAutoTLS = (bool)getMailVars($mysqli)["autossl"];
  $mail->Port = getMailVars($mysqli)["port"];

  $mail->setFrom("command@towerdevs.xyz", "DTAdmin");
  //$mail->addAddress($email, "$firstname $lastname");
  $mail->addAddress("$email", "$firstname $lastname");
  $mail->isHTML = true;

  $mail->Subject = $subject;
  $mail->Body = $htmlbody;
  $mail->AltBody = $nonhtmlbody;

  if(!$mail->send()) {
    return false;
  } else {
    return true;
  }
}

function getMailVars($mysqli) {
  $statement = "SELECT serverid, hostname, sslenabled, autossl, port, authenticated, username, password FROM mailserver WHERE serverid=? LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
    $true = 1;
    $stmt->bind_param('i', $true);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($serverid, $hostname, $sslenabled, $autossl, $port, $authenticated, $username, $password);
      $stmt->fetch();
      return array("serverid"=>$serverid, "hostname"=>$hostname, "sslenabled"=>$sslenabled, "autossl"=>$autossl, "port"=>$port, "authenticated"=>$authenticated, "username"=>$username, "password"=>$password);
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function sendAccountVerifiedMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Your account has been verified.";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account verified</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account has been verified.</h3>
  Dear $firstname $lastname, your account has been verified.
  You should now be able to log into DTAdmin with the credentials you created at signup.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been verified.
  You should now be able to log into DTAdmin with the credentials you created at signup.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccountDisabledMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Your account has been disabled.";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account disabled</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account has been disabled.</h3>
  Dear $firstname $lastname, your account has been disabled.
  An administrator has disabled your account. Please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been disabled.
  An administrator has disabled your account. Please contact support@towerdevs.xyz for more information.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccountEnabledMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Your account has been enabled.";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account enabled</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account has been enabled.</h3>
  Dear $firstname $lastname, your account has been enabled.
  An administrator has re-enabled your account. However, some functionality might still be disabled for security reasons.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been enabled.
  An administrator has re-enabled your account. However, some functionality might still be disabled for security reasons.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccountLockedMail($mysqli, $userid, $lockedip) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Your account has been locked.";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account locked</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account has been locked.</h3>
  Dear $firstname $lastname, your account has been locked.
  Your account has been locked due to too many incorrect login attempts from the IP address $lockedip. Please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been locked.
  Your account has been locked due to too many incorrect login attempts from the IP address $lockedip. Please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

  function sendAccountUnlockedMail($mysqli, $userid) {
    $userinfo = getUserFromUserID($mysqli, $userid);
    $email = $userinfo["email"];
    $firstname = $userinfo["firstname"];
    $lastname = $userinfo["lastname"];
    $ident = hashMailIdent($mysqli, $userid);
    $subject = "Your account has been unlocked.";
    $htmlbody = "
    <html>
    <head>
    <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
    <title>Account unlocked</title>
    </head>
    <body>
    <div style=\"font-family: 'Roboto', sans-serif;\">
    <h3>Your account has been unlocked.</h3>
    Dear $firstname $lastname, your account has been unlocked.
    An administrator has unlocked your account, you may now sign in again.
    Sincerely,
    TOWER Administration Team
    <br>
    Message Ident: $ident
    </div>
    </body>
    </html>
    ";


  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been unlocked.
  An administrator has unlocked your account, you may now sign in again.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccountDeletedMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Your account has been deleted.";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account deleted</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account has been deleted.</h3>
  Dear $firstname $lastname, your account has been deleted.
  Somebody, either you or an administrator, has deleted your account. If you deleted your account, there's nothing else you need to do.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been locked.
  Your account has been locked due to too many incorrect login attempts. Please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccountWaitMail($mysqli, $email, $firstname, $lastname, $passwordhash) {
  $passstring = $email . $firstname . $lastname . $passwordhash;
  $ident = hash('crc32', $passstring);
  $subject = "Account pending verification";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account pending verification</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account is pending verification.</h3>
  Dear $firstname $lastname, your account has been created.
  However, your account must be verified by an administrator before you can log in. If this process takes more than 7 days, please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been created.
  However, your account must be verified by an administrator before you can log in. If this process takes more than 7 days, please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccountAutoconfirmMail($mysqli, $email, $firstname, $lastname, $passwordhash) {
  $passstring = $email . $firstname . $lastname . $passwordhash;
  $ident = hash('crc32', $passstring);
  $subject = "Account created";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account created</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Your account has been created.</h3>
  Dear $firstname $lastname, your account has been created.
  Since you provided a Invite Key at signup, your account has been auto-confirmed. You may now log in with your username and password.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been created.
  However, your account must be verified by an administrator before you can log in. If this process takes more than 7 days, please contact <a href=\"mailto:support@towerdevs.xyz\">support@towerdevs.xyz</a> for more information.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccount2FAEnabledMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Multi-Factor Enabled";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Multi-Factor Enabled</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Multi-Factor Enabled</h3>
  Dear $firstname $lastname, multi-factor authentication has been enabled.
  Somebody, either you or an administrator, has enabled multi-factor authentication on your account. If you performed this action, there's nothing more you need to do.
  If you did not perform this action, please contact support@towerdevs.xyz immediately as your account may be compromised.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, multi-factor authentication has been enabled.
  Somebody, either you or an administrator, has enabled multi-factor authentication on your account. If you performed this action, there's nothing more you need to do.
  If you did not perform this action, please contact support@towerdevs.xyz immediately as your account may be compromised.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function sendAccount2FADisabledMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $ident = hashMailIdent($mysqli, $userid);
  $subject = "Multi-Factor Disabled";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Multi-Factor Disabled</title>
  </head>
  <body>
  <div style=\"font-family: 'Roboto', sans-serif;\">
  <h3>Multi-Factor Disabled</h3>
  Dear $firstname $lastname, multi-factor authentication has been disabled.
  Somebody, either you or an administrator, has disabled multi-factor authentication on your account. If you performed this action, there's nothing more you need to do.
  If you did not perform this action, please contact support@towerdevs.xyz immediately as your account may be compromised.
  Sincerely,
  TOWER Administration Team
  <br>
  Message Ident: $ident
  </div>
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, multi-factor authentication has been disabled.
  Somebody, either you or an administrator, has disabled multi-factor authentication on your account. If you performed this action, there's nothing more you need to do.
  If you did not perform this action, please contact support@towerdevs.xyz immediately as your account may be compromised.
  Sincerely,
  TOWER Administration Team

  Message Ident: $ident
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}

function hashMailIdent($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];
  $password = $userinfo["password"];
  //$time = date(DATE_ATOM);
  $passstring = $email . $firstname . $lastname . $password;
  $passkey = hash('crc32', $passstring);
  return $passkey;
}
?>
