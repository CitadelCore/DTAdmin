<?php
function mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname) {
  $mail = new PHPMailer;
  $mail->isSMTP();
  //$mail->SMTPDebug = 3;
  $mail->Host = "smtp.sendgrid.com";
  $mail->SMTPAuth = true;
  $mail->Username = 'towerdtadmin';
  $mail->Password = 'LmMey2xK2NjHRgLGaXKiAX3b';
  $mail->SMTPAutoTLS = false;
  $mail->Port = 587;

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

function sendAccountVerifiedMail($mysqli, $userid) {
  $userinfo = getUserFromUserID($mysqli, $userid);
  $email = $userinfo["email"];
  $firstname = $userinfo["firstname"];
  $lastname = $userinfo["lastname"];

  $subject = "Your account has been verified.";
  $htmlbody = "
  <html>
  <head>
  <link href=\"https://fonts.googleapis.com/css?family=Roboto\" rel=\"stylesheet\">
  <title>Account verified</title>
  </head>
  <body>
  <h3>Your account has been verified.</h3>
  Dear $firstname $lastname, your account has been verified.
  You should now be able to log into DTAdmin with the credentials you created at signup.
  Sincerely,
  TOWER Administration Team
  </body>
  </html>
  ";

  $nonhtmlbody = "
  Dear $firstname $lastname, your account has been verified.
  You should now be able to log into DTAdmin with the credentials you created at signup.
  Sincerely,
  TOWER Administration Team
  ";

  mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname);
}
?>
