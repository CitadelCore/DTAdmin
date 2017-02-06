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
          if ($loginresult == "correctuser") {
            // Successful login
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
          } else {
              // Other internal exception
              echo "550A";
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
 }
elseif ($postdata == "CREATESECRETKEY") {
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
     if(isset($_POST['passwordhash'])) { $passwordhash = $_POST['passwordhash']; updateUserProfile($mysqli, $_SESSION['user_id'], array("passwordhash"=>$passwordhash)); }
     if(isset($_POST['username'])) { if (checkUserHasPermission($mysqli, $userid, "canmodifyusers") == true) { $username = $_POST['username']; updateUserProfile($mysqli, $_SESSION['user_id'], array("username"=>$username)); }}
     echo "210A"; // Success
   } else {
     echo "580A"; // Password dosen't match
  }
} else {
  echo "570A"; // Not logged in
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
} else {
  echo "300A";
}
} else {
  http_response_code(405);
  echo "<h2>Method Not Allowed</h2>";
}
?>
