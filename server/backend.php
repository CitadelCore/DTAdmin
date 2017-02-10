<?php
include_once "config.php";
include_once "functions.php";

sec_session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
$postdata = $_POST['command'];
if ($postdata == "ISREADY") {
  logClientIP($mysqli);
  echo "410A";
  //echo "420A"; //For testing
} elseif ($postdata == "CREDPAYLOAD"){
  if (isset($_POST['userid'], $_POST['password'])) {
      $userid = $_POST['userid'];
      $password = $_POST['password'];
      if (test_data($userid) == true) {
        if (test_data($password) == true) {
          $loginresult = login($userid, $password, $mysqli);
          if (getUser2FAEnabled($mysqli, getUserIDFromUsername($mysqli, $_POST['userid']) == true)) {
            if (isset($_POST['token'])) {
              if (test_data($_POST['token']) ==  true) {
                if ($loginresult == "correctuser") {
                  if (verifyUser2FASecret($mysqli, getUserIDFromUsername($mysqli, $_POST['userid']), $_POST['token']) == true) {
                    // Successful login
                      finish_login($userid, $password, $mysqli);
                      echo "510A";
                  } elseif (getUser2FAEnabled($mysqli, getUserIDFromUsername($mysqli, $_POST['userid']) == true)) {
                    // Wrong code
                      echo "550A";
                  } else {
                    // No secret exists
                      echo "560A";
                  }

                } elseif ($loginresult == "incorrectpass") {
                    // Incorrect password
                    echo "520A";
                } elseif ($loginresult == "usernotexist") {
                    // User dosen't exist
                    echo "530A";
                } elseif ($loginresult == "lockedout") {
                    // Account locked out
                    echo "540A";
                } elseif ($loginresult == "ipbanned") {
                      // IP address banned
                      echo "540A";
                } else {
                    // Other internal exception
                    echo "200E";
                }

              } else {
                echo "590A";
              }
            } else {
              // Tried to login while token enforced
              echo "590A";
            }
          } else {
            if ($loginresult == "correctuser") {
              // Successful login
                finish_login($userid, $password, $mysqli);
                echo "510A";
            } elseif ($loginresult == "incorrectpass") {
                // Incorrect password
                echo "520A";
            } elseif ($loginresult == "usernotexist") {
                // User dosen't exist
                echo "530A";
            } elseif ($loginresult == "lockedout") {
                // Account locked out
                echo "540A";
            } elseif ($loginresult == "ipbanned") {
                  // IP address banned
                  echo "540A";
            } else {
                // Other internal exception
                echo "200E";
            }
          }
     } else {
       // Special chars in password
       echo "560A";
     }
    } else {
      // Special chars in username
      echo "560B";
    }
  } else {
      // Param error
      echo "200E";
  }

} elseif ($postdata == "QUERYLOGIN"){
  if(isset($_POST['queryid'], $_POST['authkey'], $_POST['queryuserid'], $_POST['queryuser'], $_POST['queryhash'], $_POST['querybrowser'])) {
    $userquery = queryUserSecret($mysqli, $_POST['authkey']);
    if ($userquery == "accepted") {
     if (remote_login_check($mysqli, $_POST['queryuserid'], $_POST['queryuser'], $_POST['queryhash'], $_POST['querybrowser']) == true ) {
      echo "510A"; // Correct login
    } else {
      echo "550B"; // Incorrect login
    }
  } else {
    // Incorrect key or account unauthorized
    echo "560B";
    //echo $userquery;
  }
  } else {
    // Param error
    echo "200E";
  }

} elseif ($postdata == "PERMTEST") {
  if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'], $_SERVER['HTTP_USER_AGENT'])) {
    $url = "https://localhost:43105/dtquery/query.php";
    $data = array('command' => "PERMTEST", 'user_id' => $_SESSION['user_id'], 'username' => $_SESSION['username'], 'login_string' => $_SESSION['login_string'], 'useragent' => $_SERVER['HTTP_USER_AGENT']);

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    echo $result;
  } else {
    // Param error
    echo "200E";
  }
} elseif ($postdata == "CHECKCOMMAND") {
  if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'], $_SERVER['HTTP_USER_AGENT'], $_SESSION['login_string'], $_POST['serverid'], $_POST['servercommand'])) {
    $url = "https://localhost:43105/dtquery/query.php";
    $data = array('command' => "SOURCESERVERRCONCOMMAND", 'user_id' => $_SESSION['user_id'], 'username' => $_SESSION['username'], 'login_string' => $_SESSION['login_string'], 'useragent' => $_SERVER['HTTP_USER_AGENT'], 'serverid' => $_POST['serverid'], 'servercommand' => $_POST['servercommand']);
    //$data = array('command' => "", 'user_id' => $_SESSION['user_id'], 'username' => $_SESSION['username'], 'login_string' => $_SESSION['login_string'], 'useragent' => $_SERVER['HTTP_USER_AGENT'], 'serverid' => $_POST['serverid'], 'servercommand' => $_POST['servercommand']);

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    echo $result;
  } else {
    // Param error
    echo "200E";
  }
} elseif ($postdata == "QUERYSERVERDB") {
  if(isset($_POST['queryid'], $_POST['authkey'], $_POST['serverid'])) {
    $userquery = queryUserSecret($mysqli, $_POST['authkey']);
    if ($userquery == "accepted") {
      $queryreturn = queryServerDB($mysqli, $_POST['serverid']);
     if ($queryreturn == true ) {
      $queryreturn = json_encode($queryreturn);
      echo $queryreturn; // Everything OK
    } else {
      echo "220E"; // General error
    }
  } else {
    echo "220E"; // General error
  }
  } else {
    // Param error
    echo "200E";
  }

// Secret key operations

  } elseif ($postdata == "DELETESECRETKEY") {
   if(isset($_POST['secretid'], $_POST['userid'])) {
     $secretid = $_POST['secretid'];
     $userid = $_POST['userid'];
    if (login_check($mysqli) == true) {
      if (checkUserHasPermission($mysqli, $_SESSION['user_id'], "canmanagedtquerykey") == true) {
        deleteUserSecret($mysqli, $secretid, $userid);
        echo "210A"; // Success
      } else {
        echo "620A"; // No permission
      }
    } else {
      echo "570A"; // Not logged in
   }
   } else {
  // Param error
  echo "200E";
  }

 } elseif ($postdata == "CREATESECRETKEY") {
   $keynote = $_POST['keynote'];
  if (login_check($mysqli) == true) {
    if (checkUserHasPermission($mysqli, $_SESSION['user_id'], "canmanagedtquerykey") == true) {
      createUserSecret($mysqli, $keynote, $_SESSION['user_id']);
      echo "210A"; // Success
    } else {
      echo "620A"; // No permission
    }
  } else {
    echo "570A"; // Not logged in
 }

 } elseif ($postdata == "UPDATEUSERPROFILE") {
   if (login_check($mysqli) == true) {
    if (password_verify($_POST['passconfirm'], getUserFromUserID($mysqli, $_SESSION['user_id'])['password']) == true) {
     if(isset($_POST['email'])) { $email = $_POST['email']; updateUserProfile($mysqli, $_SESSION['user_id'], array("email"=>$email)); }
     if(isset($_POST['firstname'])) { $firstname = $_POST['firstname']; updateUserProfile($mysqli, $_SESSION['user_id'], array("firstname"=>$firstname)); }
     if(isset($_POST['lastname'])) { $lastname = $_POST['lastname']; updateUserProfile($mysqli, $_SESSION['user_id'], array("lastname"=>$lastname)); }
     if(isset($_POST['passwordhash'])) { $passwordhash = $_POST['passwordhash']; updateUserProfile($mysqli, $_SESSION['user_id'], array("passwordhash"=>password_hash($passwordhash, PASSWORD_BCRYPT))); }
     if(isset($_POST['username'])) { if (checkUserHasPermission($mysqli, $userid, "canmodifyusers") == true) { $username = $_POST['username']; updateUserProfile($mysqli, $_SESSION['user_id'], array("username"=>$username)); }}
     echo "210A"; // Success
   } else {
     echo "580A"; // Password dosen't match
  }
} else {
  echo "570A"; // Not logged in
}

} elseif ($postdata == "CREATEUSERPROFILE") {
  if (ip_check_banned($mysqli) == false) {
    if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['passwordhash']) && isset($_POST['username'])) {
      if (isset($_POST['invitecode'])) {
        if (checkInviteValid($mysqli, $_POST['invitecode']) == "valid") {
          if (createUserProfile($mysqli, array("passwordhash"=>password_hash($_POST['passwordhash'], PASSWORD_BCRYPT), "username"=>$_POST['username'], "email"=>$_POST['email'], "firstname"=>$_POST['firstname'], "lastname"=>$_POST['lastname'], "disabled"=>0)) == true) {
           sendAccountAutoconfirmMail($mysqli, $_POST['email'], $_POST['firstname'], $_POST['lastname'], password_hash($_POST['passwordhash']));
           echo "210A";
          } else {
           echo "830A";
          }
        } elseif (checkInviteValid($mysqli, $_POST['invitecode']) == "expired") {
          echo "810A";
        } else {
          echo "820A";
        }
      } else {
        if (createUserProfile($mysqli, array("passwordhash"=>password_hash($_POST['passwordhash'], PASSWORD_BCRYPT), "username"=>$_POST['username'], "email"=>$_POST['email'], "firstname"=>$_POST['firstname'], "lastname"=>$_POST['lastname'], "disabled"=>1)) == true) {
         sendAccountWaitMail($mysqli, $_POST['email'], $_POST['firstname'], $_POST['lastname'], password_hash($_POST['passwordhash'], PASSWORD_BCRYPT));
         echo "210A";
        } else {
         echo "830A";
        }
      }
    } else {
      echo "720A";
    }
  } else {
    echo "540A";
  }

} elseif ($postdata == "DELETEUSERPROFILE") {
  if (login_check($mysqli) == true) {
  if ($_POST['deleteusername'] == getUserFromUserID($mysqli, $_SESSION['user_id'])['userid']) {
   if (password_verify($_POST['deletepassword'], getUserFromUserID($mysqli, $_SESSION['user_id'])['password']) == true) {
    deleteUserProfile($mysqli, $_SESSION['user_id']);
    echo "210A"; // Success
  } else {
    echo "580A"; // Password dosen't match
 }
 } else {
   echo "710A"; // Incorrect username
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "DISABLEUSERPROFILE") {
  if (login_check($mysqli) == true) {
  if (checkUserHasPermission($mysqli, $_SESSION['user_id'], "canmodifyusers") == true) {
   if ($_POST['userid'] != $_SESSION['user_id']) {
    disableUser($mysqli, $_POST['userid']);
    echo "210A"; // Success
  } else {
    echo "910A"; // Can't disable own profile!
 }
 } else {
   echo "620A"; // Not authorized
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "ENABLEUSERPROFILE") {
  if (login_check($mysqli) == true) {
  if (checkUserHasPermission($mysqli, $_SESSION['user_id'], "canmodifyusers") == true) {
   if ($_POST['userid'] != $_SESSION['user_id']) {
    enableUser($mysqli, $_POST['userid']);
    echo "210A"; // Success
  } else {
    echo "920A"; // Can't enable own profile!
 }
 } else {
   echo "620A"; // Not authorized
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "LOCKUSERPROFILE") {
  if (login_check($mysqli) == true) {
  if (checkUserHasPermission($mysqli, $_SESSION['user_id'], "canmodifyusers") == true) {
   if ($_POST['userid'] != $_SESSION['user_id']) {
    //lockUser($mysqli, $_POST['userid']);
    //echo "210A"; // Success
    echo "620A";
  } else {
    echo "930A"; // Can't lock own profile!
 }
 } else {
   echo "620A"; // Not authorized
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "UNLOCKUSERPROFILE") {
  if (login_check($mysqli) == true) {
  if (checkUserHasPermission($mysqli, $_SESSION['user_id'], "canmodifyusers") == true) {
   if ($_POST['userid'] != $_SESSION['user_id']) {
    unlockUser($mysqli, $_POST['userid']);
    echo "210A"; // Success
  } else {
    echo "940A"; // Can't enable own profile!
 }
 } else {
   echo "620A"; // Not authorized
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "ENABLEUSER2FA") {
  if (login_check($mysqli) == true) {
  if (getUser2FAExists($mysqli, $_SESSION['user_id']) == false) {
    activateUser2FA($mysqli, $_SESSION['user_id']);
    echo "210A"; // Success
 } else {
   echo "840A"; // 2FA already enabled
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "CONFIRMUSER2FA") {
  if (login_check($mysqli) == true) {
  if (getUser2FAEnabled($mysqli, $_SESSION['user_id']) == false) {
    if (isset($_POST['token'])) {
      if (verifyUser2FASecret($mysqli, $_SESSION['user_id'], $_POST['token']) == true) {
        if (enableUser2FA($mysqli, $_SESSION['user_id']) == true) {
          echo "210A"; // Success
        } else {
          echo "200E"; // Internal error
        }
      } else {
        echo "870A"; // Incorrect confirm code
      }
    } else {
      echo "720A"; // Not enough parameters
    }
 } else {
   echo "860A"; // 2FA already confirmed
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "REMOVEUSER2FA") {
  if (login_check($mysqli) == true) {
  if (getUser2FAEnabled($mysqli, $_SESSION['user_id']) == true) {
    if (isset($_POST['token']) && isset($_POST['password'])) {
      if (password_verify($_POST['password'], getUserFromUserID($mysqli, $_SESSION['user_id'])['password']) == true) {
        if (verifyUser2FASecret($mysqli, $_SESSION['user_id'], $_POST['token']) == true) {
          deactivateUser2FA($mysqli, $_SESSION['user_id']);
          echo "210A"; // Success
        } else {
          echo "870A"; // Incorrect confirm code
        }
      } else {
        echo "580A"; // Incorrect password
      }
    } else {
      echo "720A"; // Not enough parameters
    }
 } else {
   echo "890A"; // 2FA not enabled
 }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "CHECK2FASTATUS") {
  if (login_check($mysqli) == true) {
  if (getUser2FAEnabled($mysqli, $_SESSION['user_id']) == true) {
    echo "880A"; // 2FA is enabled
  } elseif (getUser2FAExists($mysqli, $_SESSION['user_id']) == true) {
    echo "890B"; // 2FA is pending
  } else {
    echo "890A"; // 2FA is disabled
  }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "GET2FAQRCODE") {
  if (login_check($mysqli) == true) {
  if (getUser2FAEnabled($mysqli, $_SESSION['user_id']) == true) {
    echo "880A"; // 2FA is enabled
  } elseif (getUser2FAExists($mysqli, $_SESSION['user_id']) == true) {
    echo getUser2FAQrcode($mysqli, $_SESSION['user_id']);
  } else {
    echo "890A"; // 2FA is disabled
  }
} else {
 echo "570A"; // Not logged in
}

} elseif ($postdata == "REMOVEPENDINGTOKEN") {
  if (login_check($mysqli) == true) {
  if (getUser2FAEnabled($mysqli, $_SESSION['user_id']) == true) {
    echo "880A"; // 2FA is enabled
  } elseif (getUser2FAExists($mysqli, $_SESSION['user_id']) == true) {
    invalidateUser2FAToken($mysqli, $_SESSION['user_id']);
    echo "210A";
  } else {
    echo "890A"; // 2FA is disabled
  }
} else {
 echo "570A"; // Not logged in
}

} else {
  echo "300A";
}

} else {
  http_response_code(405);
  echo "<h2>Method Not Allowed</h2>";
}


?>
