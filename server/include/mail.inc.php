<?php
function mailToUser($mysqli, $email, $htmlbody, $nonhtmlbody, $subject, $firstname, $lastname) {

  $mail = new PHPMailer;
  //$mail->isSMTP();
  $mail->SMTPDebug = 3;
  $mail->Host = getMailVars($mysqli)["hostname"];
  $mail->SMTPAuth = (bool)getMailVars($mysqli)["authenticated"];
  $mail->Username = getMailVars($mysqli)["username"];
  $mail->Password = getMailVars($mysqli)["password"];
  $mail->SMTPAutoTLS = var_dump((bool) getMailVars($mysqli)["autossl"]);
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
