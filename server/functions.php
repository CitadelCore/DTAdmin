<?php
include_once "config.php";

function sec_session_start() {
    $session_name = 'dtadmin_session';
    session_name($session_name);

    $secure = true;
    $httponly = true;
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?code=500X");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly);

    session_start();            // Start the PHP session
    session_regenerate_id(true);    // regenerated the session, delete the old one.
}

function login($userid, $password, $mysqli) {
    $clientip = $_SERVER['REMOTE_ADDR'];
    if ($stmt = $mysqli->prepare("SELECT id, userid, password
        FROM members
       WHERE userid = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $userid);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($user_id, $username, $db_password);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {

            if (checkbrute($user_id, $mysqli) == true) {
                $errorreason = "lockedout";
                return "lockedout"; // custom ajax action here
            } else {
                if (password_verify($password, $db_password)) {
                     //correct pass
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                                "",
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                              $db_password . $user_browser);
                    $errorreason = "correctuser";
                    $now = time();
                    $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                                    VALUES ('$user_id', '$now', 'Administrator logged in', '$clientip')");
                    return "correctuser";
                } else {
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time, clientip)
                                    VALUES ('$user_id', '$now', '$clientip')");
                    $errorreason = "incorrectpass";
                    $now = time();
                    $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                                    VALUES ('$user_id', '$now', 'Incorrect password attempt', '$clientip')");
                    return "incorrectpass";
                }
            }
        } else {
            // No user exists.
            $errorreason = "usernotexist";
            $now = time();
            $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                            VALUES ('$user_id', '$now', 'Incorrect username attempt', '$clientip')");
            return "usernotexist";
        }
    }
}

function checkbrute($user_id, $mysqli) {
  $clientip = $_SERVER['REMOTE_ADDR'];
    $now = time();
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time
                             FROM login_attempts
                             WHERE user_id = ?
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
  $clientip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SESSION['user_id'],
              $_SESSION['username'],
              $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password
                                      FROM members
                                      WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
                if (hash_equals($login_check, $login_string) ){
                    //loggedin
                    return true;
                } else {
                    //notloggedin
                    $now = time();
                    $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                                    VALUES ('$user_id', '$now', 'Password hash match error', '$clientip')");
                    return false;
                }
            } else {
                //notloggedin
                $now = time();
                $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                                VALUES ('$user_id', '$now', 'Password hash match error', '$clientip')");
                return false;
            }
        } else {
            //notloggedin
            $now = time();
            $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                            VALUES ('$user_id', '$now', 'User match error', '$clientip')");
            return false;
        }
    } else {
        //notloggedin
        $now = time();
        $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                        VALUES ('NOUSER', '$now', 'Session variables not set', '$clientip')");
        return false;
    }
}

function remote_login_check($mysqli, $uid, $uname, $lstring, $ubrowser) {
  $clientip = $_SERVER['REMOTE_ADDR'];
    if (isset($uid,
              $uname,
              $lstring,
              $ubrowser)) {
        if ($stmt = $mysqli->prepare("SELECT password
                                      FROM members
                                      WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $uid);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $ubrowser);
                if (hash_equals($login_check, $lstring) ){
                    //loggedin
                    return true;
                } else {
                    //notloggedin
                    $now = time();
                    $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                                    VALUES ('$uid', '$now', 'Password hash match error', '$clientip')");
                    return false;
                }
            } else {
                //notloggedin
                $now = time();
                $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                                VALUES ('$uid', '$now', 'Password hash match error', '$clientip')");
                return false;
            }
        } else {
            //notloggedin
            $now = time();
            $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                            VALUES ('$uid', '$now', 'User match error', '$clientip')");
            return false;
        }
    } else {
        //notloggedin
        $now = time();
        $mysqli->query("INSERT INTO syslog(user_id, time, reason, clientip)
                        VALUES ('NOUSER', '$now', 'Session variables not set', '$clientip')");
        return false;
    }
}

function getRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function test_data($data) {
  $originaldata = $data;
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  if ($data !== $originaldata) {
    return false;
  } else {
    return true;
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

function fetchRows($statement) {
          echo $statement->num_rows;
          while($row = $statement->fetch())
        {
          echo $statement->num_rows; //incrementing by one each time
        }
          echo $statement->num_rows; // Finally the total count
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

function createUserSecret($mysqli, $keynote, $userid) {
  $date = date('Y-m-d h:i:s');
  $randkey = getRandomString(50);
  $statement = "INSERT INTO usersecrets VALUES(NULL, $userid, '$randkey', '$keynote ', '$date')";
  if ($stmt = $mysqli->prepare($statement)) {
    $stmt->execute();
    $stmt->store_result();
  }
}

function ifEchoSql($col, $var) {
  if(isset($var)) {
    echo "$col='$var' ";
  } else {
    echo "";
  }
}

function queryServerDB($mysqli, $serverid) {
  $statement = "SELECT serverid, servername, currentstatus, currentplayercount, timesincelastsd, gamemode, operator, maxraminmb, freeraminmb, cpuusagepercent, ipaddress, hostname, queryportdefault, queryportdtadmin, rconpassword, dtqueryseckey FROM servers WHERE serverid=? LIMIT 1";
  if ($stmt = $mysqli->prepare($statement)) {
  $stmt->bind_param('i', $serverid);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows == 1) {
    $stmt->bind_result($serverid, $servername, $currentstatus, $currentplayercount, $timesincelastsd, $gamemode, $operator, $maxraminmb, $freeraminmb, $cpuusagepercent, $ipaddress, $hostname, $queryportdefault, $queryportdtadmin, $rconpassword, $dtqueryseckey);
    $stmt->fetch();
    return array("serverid"=>$serverid, "servername"=>$servername, "currentstatus"=>$currentstatus, "currentplayercount"=>$currentplayercount, "timesincelastsd"=>$timesincelastsd, "gamemode"=>$gamemode, "operator"=>$operator, "maxraminmb"=>$maxraminmb, "freeraminmb"=>$freeraminmb, "cpuusagepercent"=>$cpuusagepercent, "ipaddress"=>$ipaddress, "hostname"=>$hostname, "queryportdefault"=>$queryportdefault, "queryportdtadmin"=>$queryportdtadmin, "rconpassword"=>$rconpassword, "dtqueryseckey"=>$dtqueryseckey);
  } else {
    return false;
  }
}}

function updateUserProfile($mysqli, $userid, $updatedata) {
if (isset($updatedata["passwordhash"])) { $passwordhash = htmlspecialchars($updatedata["passwordhash"]); }
if (isset($updatedata["firstname"])) { $firstname = htmlspecialchars($updatedata["firstname"]); }
if (isset($updatedata["lastname"])) { $lastname = htmlspecialchars($updatedata["lastname"]);
if (isset($updatedata["email"])) { $email = htmlspecialchars($updatedata["email"]); }
$hasht = ifEchoSql($passwordhash, "passwordhash");
$firstt = ifEchoSql($firstname, "firstname");
$lastt = ifEchoSql($lastname, "lastname");
$emailt = ifEchoSql($email, "email");
$varsets = "$hasht" . "$firstt" . "$lastt" . "$emailt";
if ($stmt = $mysqli->prepare("UPDATE members
                              SET $varsets
                              WHERE id=?")) {
  $stmt->bind_param('i', $userid);
  $stmt->execute();
  $stmt->store_result();
  return true;
} else {
  return false;
}}}
