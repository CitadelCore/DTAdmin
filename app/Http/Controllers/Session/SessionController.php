<?php
namespace App\Http\Controllers\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\SyslogModel;
use App\Model\BannedIpsModel;
use App\Model\LoginAttemptsModel;
use App\Model\MembersModel;

class SessionController extends Controller {

  /**public function secure_session_start() {
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
  }**/

  private function logClientIP() {
    syslogInsert(0, "NOUSER", "Login page accessed");
  }

  static function ip_check_banned() {
    $syslog = new SyslogModel;
    $bannedips = new BannedIpsModel;
    $loginattempts = new LoginAttemptsModel;
    $members = new MembersModel;
    $clientip = $_SERVER['REMOTE_ADDR'];
    $count = BannedIpsModel::where('ipaddress', $clientip)->take(1)->get();
        if ($count->contains($clientip) == true) {
          return true;
        } else {
          return false;
        }
  }

  public function syslogInsert($user_id, $username, $reason) {
    $syslog = new SyslogModel;
    $bannedips = new BannedIpsModel;
    $loginattempts = new LoginAttemptsModel;
    $members = new MembersModel;
    $clientip = $_SERVER['REMOTE_ADDR'];
    $now = time();
    $syslog->user_id = $user_id;
    //$syslog->username = $username;
    $syslog->time = $now;
    $syslog->reason = $reason;
    $syslog->clientip = $clientip;

    $syslog->save();
  }

  public function attemptInsert($user_id) {
    $syslog = new SyslogModel;
    $bannedips = new BannedIpsModel;
    $loginattempts = new LoginAttemptsModel;
    $members = new MembersModel;
    $clientip = $_SERVER['REMOTE_ADDR'];
    $now = time();
    $loginattempts->user_id = $user_id;
    $loginattempts->time = $now;
    $loginattempts->clientip = $clientip;

    $loginattempts->save();
  }

  /**private function finish_login($userid, $password) {
    $userinfo = MembersModel::where('userid', $userid)->take(1)->get();
    if ($userinfo->contains($userid) == true) {
        $user_id = $userinfo->all()[1]["user_id"];
        $username = $userinfo->all()[1]["username"];
        $db_password = $userinfo->all()[1]["passwordhash"];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
        session(['user_id' => $user_id], ['username' => $username], ['login_string' => $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser)]);
        $errorreason = "correctuser";
        syslogInsert($user_id, $username, '<i class=\"fa fa-user\"></i> User logged in');
        $attempts = LoginAttemptsModel::where('user_id', $user_id)->take(1)->get();
        $attempts->delete();
        return true;
     } else {
       return false;
     }
  }

  public function login($userid, $password) {
      if (ip_check_banned($mysqli) == false) {
        $userinfo = MembersModel::where('userid', $userid)->take(1)->get();
            if ($userinfo->contains($userid) == true) {
              if (getUserFromUserID($mysqli, $user_id)['disabled'] == 0) {
                if (checkbrute($user_id, $mysqli) == true) {
                    lockUser($mysqli, $user_id, $clientip);
                    return "lockedout";
                } else {
                    if (password_verify($password, $db_password)) {
                         //correct pass
                        return "correctuser";
                    } else {
                        $now = time();
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                                    "",
                                                                    $username);
                        $mysqli->query("INSERT INTO login_attempts(user_id, time, clientip)
                                        VALUES ('$user_id', '$now', '$clientip')");
                        $errorreason = "incorrectpass";
                        $now = time();
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                                    "",
                                                                    $username);
                        $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                        VALUES (NULL, '$user_id', '$username', '$now', 'Incorrect password attempt', '$clientip')");
                        return "incorrectpass";
                    }
                }
              } else {
                $now = time();
                $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                            "",
                                                            $username);
                $errorreason = "lockedout";
                $now = time();
                $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                            "",
                                                            $username);
                $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                VALUES (NULL, '$user_id', '$username', '$now', 'Login attempt while disabled', '$clientip')");
                return "lockedout";
              }
            } else {
                // No user exists.
                $errorreason = "usernotexist";
                $now = time();
                $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                VALUES (NULL, 0, '$userid', '$now', 'Incorrect username attempt', '$clientip')");
                return "usernotexist";
            }
      } else {
        $now = time();
        $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                        VALUES (NULL, 'NONE', 'NONE', '$now', 'Login attempt from banned IP', '$clientip')");
        return "ipbanned";
      }
  }**/

  public function checklocked($user_id) {
    $clientip = $_SERVER['REMOTE_ADDR'];
      $now = time();
      $valid_attempts = $now - (2 * 60 * 60);
      $attempt = LoginAttemptsModel::where('user_id', $user_id)->get()->count();
      if ($attempt > 5) {
          return true;
      } else {
          return false;
      }
  }

  /**public function login_check($mysqli) {
    $clientip = $_SERVER['REMOTE_ADDR'];
    if (ip_check_banned($mysqli) == false) {
      if (null !== session('user_id') && null !== session('username') && null !== session('login_string')) {

          $user_id = session('user_id');
          $login_string = session('login_string');
          $username = session('username');
          $user_browser = $_SERVER['HTTP_USER_AGENT'];

          if ($stmt = $mysqli->prepare("SELECT password
                                        FROM members
                                        WHERE id = ? LIMIT 1")) {
              $stmt->bind_param('i', $user_id);
              $stmt->execute();
              $stmt->store_result();

              if ($stmt->num_rows == 1) {
                if (getUserFromUserID($mysqli, $user_id)['disabled'] == 0) {
                  $stmt->bind_result($password);
                  $stmt->fetch();
                  $login_check = hash('sha512', $password . $user_browser);
                  if (hash_equals($login_check, $login_string) ){
                      return true;
                  } else {
                      //notloggedin
                      $now = time();
                      $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                      $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                      VALUES (NULL, '$user_id', 'NONE', '$now', 'Password hash match error', '$clientip')");
                      return false;
                  }
                } else {
                  $now = time();
                  $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                  $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                  VALUES (NULL, '$user_id', 'NONE', '$now', 'Login attempt while disabled', '$clientip')");
                      return false;
                }
              } else {
                  //notloggedin
                  $now = time();
                  $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                  $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                  VALUES (NULL, '$user_id', 'NONE', '$now', 'User not found', '$clientip')");
                  return false;
              }
          } else {
              //notloggedin
              $now = time();
              $user_id = preg_replace("/[^0-9]+/", "", $user_id);
              $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                              VALUES (NULL, '$user_id', 'NONE', '$now', 'Query error', '$clientip')");
              return false;
          }
      } else {
          //notloggedin
          $now = time();
          $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                          VALUES (NULL, 0, 'NONE', '$now', 'Session variables not set', '$clientip')");
          return false;
      }
    } else {
      $now = time();
      $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                      VALUES (NULL, 'NONE', 'NONE', '$now', 'Login attempt from banned IP', '$clientip')");
      return false;
    }
  }

  public function remote_login_check($mysqli, $uid, $uname, $lstring, $ubrowser) {
    $clientip = $_SERVER['REMOTE_ADDR'];
    if (ip_check_banned($mysqli) == false) {
      if (isset($uid, $uname, $lstring, $ubrowser)) {
          if ($stmt = $mysqli->prepare("SELECT password
                                        FROM members
                                        WHERE id = ? LIMIT 1")) {
              $stmt->bind_param('i', $uid);
              $stmt->execute();
              $stmt->store_result();
              if ($stmt->num_rows == 1) {
                if (getUserFromUserID($mysqli, $uid)['disabled'] == 0) {
                  $stmt->bind_result($password);
                  $stmt->fetch();
                  $login_check = hash('sha512', $password . $ubrowser);
                  if (hash_equals($login_check, $lstring) ){
                      //loggedin
                      return true;
                  } else {
                      //notloggedin
                      $now = time();
                      $uid = preg_replace("/[^0-9]+/", "", $uid);
                      $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                      VALUES (NULL, '$uid', 'NONE', '$now', 'Password hash match error', '$clientip')");
                      return false;
                  }
                } else {
                  $now = time();
                  $user_id = preg_replace("/[^0-9]+/", "", $uid);
                  $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                                  VALUES (NULL, '$uid', 'NONE', '$now', 'Login attempt while disabled', '$clientip')");
                      return false;
                }
              } else {
                  //notloggedin
                  $now = time();
                  $uid = preg_replace("/[^0-9]+/", "", $uid);
                  $mysqli->query("INSERT INTO syslog(event, user_id, time, reason, clientip)
                                  VALUES (NULL, '$uid', 'NONE', '$now', 'User not found', '$clientip')");
                  return false;
              }
          } else {
              //notloggedin
              $now = time();
              $uid = preg_replace("/[^0-9]+/", "", $uid);
              $mysqli->query("INSERT INTO syslog(event, user_id, time, reason, clientip)
                              VALUES (NULL, '$uid', 'NONE', '$now', 'Query error', '$clientip')");
              return false;
          }
      } else {
          //notloggedin
          $now = time();
          $mysqli->query("INSERT INTO syslog(event, user_id, time, reason, clientip)
                          VALUES (NULL, 0, 'NONE', '$now', 'Session variables not set', '$clientip')");
          return false;
      }
    } else {
      $now = time();
      $mysqli->query("INSERT INTO syslog(event, user_id, username, time, reason, clientip)
                      VALUES (NULL, 'NONE', 'NONE', '$now', 'Login attempt from banned IP', '$clientip')");
      return false;
    }
  }**/
}
?>
