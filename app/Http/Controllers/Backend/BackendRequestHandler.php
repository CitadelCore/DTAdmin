<?php
namespace App\Http\Controllers\Backend;

// Meta Classes
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BackendController;

// Facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

// Backend Controllers
use App\Http\Controllers\Mail\MailController;

// Mail Controllers
use App\Http\Controllers\Backend\BackendUserController;

// User Controllers
use App\Http\Controllers\User\User2FAController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserSecretController;
use App\Http\Controllers\User\UserProfileController;

// Session Controllers
use App\Http\Controllers\Session\SessionController;

class BackendRequestHandler extends Controller {
  static function HandleRequest($request) {
    if ($request->is('server/backend.php')) {
      if ($request->isMethod('post')) {
        if ($request->input('command') == "ISREADY") {
          echo "410A";
        } elseif ($request->input('command') == "CREDPAYLOAD") {
          if ($request->has('userid') && $request->has('password') && $request->has('token')) {
            BackendUserController::authUser2FA($request->input('userid'), $request->input('password'), $request->input('token'));
          } elseif ($request->has('userid') && $request->has('password')) {
            BackendUserController::authUser($request->input('userid'), $request->input('password'));
          } else {
            echo "300A";
          }
        } elseif ($request->input('command') == "QUERYLOGIN") {
          if ($request->has('authkey') && $request->has('queryid') && $request->has('queryuser') && $request->has('queryhash') && $request->has('querybrowser')) {
            if (UserSecretController::QueryUserSecret($request->input('authkey')) == "accepted") {
              if (BackendUserController::RemoteLoginCheck($request->input('queryid'), $request->input('authkey'), $request->input('queryuser'), $request->input('queryhash'), $request->input('querybrowser')) == true) {
                echo "510A";
              } else {
                echo "550B";
              }
            } else {
              echo "1030A";
            }
          } else {
            echo "300A";
          }
        } elseif ($request->input('command') == "PERMTEST") {
          echo "230E";
        } elseif ($request->input('command') == "CHECKCOMMAND") {
          echo "230E";
        } elseif ($request->input('command') == "QUERYSERVERDB") {
          if ($request->has('authkey') && $request->has('serverid')) {
            if (UserSecretController::QueryUserSecret($request->input('authkey')) == "accepted") {
              $serverquery = BackendDataController::GetServerData($request->input('serverid'));
              if ($serverquery !== false) {
                echo json_encode($serverquery);
              } else {
                echo "220E";
              }
            } else {
              echo "1030A";
            }
          } else {
            echo "300A";
          }
        } elseif ($request->input('command') == "DELETESECRETKEY") {
          if ($request->has('secretid')) {
            if (Auth::check()) {
              if (Gate::allows('managekey')) {
                if (UserSecretController::DeleteSecretKey($request->input('secretid'), Auth::id()) == true) {
                  echo "210A";
                } else {
                  echo "220E";
                }
              } else {
                echo "620A";
              }
            } else {
              echo "570A";
            }
          } else {
            echo "720A";
          }
        } elseif ($request->input('command') == "CREATESECRETKEY") {
          if ($request->has('keynote')) {
            if (Auth::check()) {
              if (Gate::allows('managekey')) {
                if (UserSecretController::CreateSecretKey(Auth::id(), $request->input('keynote')) == true) {
                  echo "210A";
                } else {
                  echo "220E";
                }
              } else {
                echo "620A";
              }
            } else {
              echo "570A";
            }
          } else {
            echo "720A";
          }
        } elseif ($request->input('command') == "UPDATEUSERPROFILE") {
          if (Auth::check()) {
            if ($request->has('passconfirm')) {
              if (Hash::check($request->input('passconfirm'), Auth::user()['password'])) {
                if ($request->has('email')) { $email = $request->input('email'); UserProfileController::UpdateUserProfile(Auth::id(), array("email"=>$email)); }
                if ($request->has('firstname')) { $firstname = $request->input('firstname'); UserProfileController::UpdateUserProfile(Auth::id(), array("firstname"=>$firstname)); }
                if ($request->has('lastname')) { $lastname = $request->input('lastname'); UserProfileController::UpdateUserProfile(Auth::id(), array("lastname"=>$lastname)); }
                if ($request->has('passwordhash')) { $passwordhash = $request->input('passwordhash'); UserProfileController::UpdateUserProfile(Auth::id(), array("passwordhash"=>password_hash($passwordhash, PASSWORD_BCRYPT))); }
                if ($request->has('username')) { if (PermissionController::checkUserHasPermission(Auth::id(), "canmodifyusers") == true) {$username = $request->input('username'); BackendUserController::UpdateUserProfile(Auth::id(), array("username"=>$username));} }
                echo "210A";
              } else {
                echo "580A";
              }
            } else {
              echo "720A";
            }
          } else {
            echo "570A";
          }
        } elseif ($request->input('command') == "UPDATEUSERPROFILEADMIN") {
          if (Auth::check()) {
            if (Gate::allows('modifyuser')) {
              if ($request->has('userid')) {
                if ($request->input('userid') !== Auth::id()) {
                  if (PermissionController::canUserModifyGroup(Auth::id(), BackendUserController::getUserFromUserID($request->input('userid'))['permissionlevel'] == true)) {
                    if ($request->has('permissionlevel')) {
                      if (PermissionController::canUserModifyGroup(Auth::id(), $request->input('permissionlevel')) == true) {
                        UserProfileController::updateUserProfile($request->input('userid'), array("permissionlevel"=>$request->input('permissionlevel')));
                        if ($request->has('email')) { $email = $request->input('email'); UserProfileController::UpdateUserProfile($request->input('userid'), array("email"=>$email)); }
                        if ($request->has('firstname')) { $firstname = $request->input('firstname'); UserProfileController::UpdateUserProfile($request->input('userid'), array("firstname"=>$firstname)); }
                        if ($request->has('lastname')) { $lastname = $request->input('lastname'); UserProfileController::UpdateUserProfile($request->input('userid'), array("lastname"=>$lastname)); }
                        if ($request->has('passwordhash')) { $passwordhash = $request->input('passwordhash'); UserProfileController::UpdateUserProfile($request->input('userid'), array("passwordhash"=>password_hash($passwordhash, PASSWORD_BCRYPT))); }
                        if ($request->has('username')) { if (Gate::allows('modifyuser')) {$username = $request->input('username'); UserProfileController::UpdateUserProfile(Auth::id(), array("username"=>$username));} }
                        echo "210A";
                      } else {
                        echo "630A";
                      }
                    } else {
                      if ($request->has('email')) { $email = $request->input('email'); UserProfileController::UpdateUserProfile($request->input('userid'), array("email"=>$email)); }
                      if ($request->has('firstname')) { $firstname = $request->input('firstname'); UserProfileController::UpdateUserProfile($request->input('userid'), array("firstname"=>$firstname)); }
                      if ($request->has('lastname')) { $lastname = $request->input('lastname'); UserProfileController::UpdateUserProfile($request->input('userid'), array("lastname"=>$lastname)); }
                      if ($request->has('passwordhash')) { $passwordhash = $request->input('passwordhash'); UserProfileController::UpdateUserProfile($request->input('userid'), array("passwordhash"=>password_hash($passwordhash, PASSWORD_BCRYPT))); }
                      if ($request->has('username')) { if (Gate::allows('modifyuser')) {$username = $request->input('username'); UserProfileController::UpdateUserProfile(Auth::id(), array("username"=>$username));} }
                      echo "210A";
                    }
                  } else {
                    echo "630A";
                  }
                } else {
                  echo "640A";
                }
              } else {
                echo "720A";
              }
              if (Hash::check(Auth::user()['password'], $request->input('passconfirm'))) {
                if ($request->has('email')) { $email = $request->input('email'); BackendUserController::UpdateUserProfile(Auth::id(), array("email"=>$email)); }
                if ($request->has('firstname')) { $firstname = $request->input('firstname'); BackendUserController::UpdateUserProfile(Auth::id(), array("firstname"=>$firstname)); }
                if ($request->has('lastname')) { $lastname = $request->input('lastname'); BackendUserController::UpdateUserProfile(Auth::id(), array("lastname"=>$lastname)); }
                if ($request->has('passwordhash')) { $passwordhash = $request->input('passwordhash'); BackendUserController::UpdateUserProfile(Auth::id(), array("passwordhash"=>password_hash($passwordhash, PASSWORD_BCRYPT))); }
                if ($request->has('username')) { if (Gate::allows('modifyuser')) {$username = $request->input('username'); BackendUserController::UpdateUserProfile(Auth::id(), array("username"=>$username));} }
                echo "210A";
              } else {
                echo "580A";
              }
            } else {
              echo "620A";
            }
          } else {
            echo "570A";
          }
        } elseif ($request->input('command') == "CREATEUSERPROFILE") {
          if (SessionController::ip_check_banned() !== true) {
            if ($request->has('email') && $request->has('firstname') && $request->has('lastname') && $request->has('passwordhash') && $request->has('username')) {
              if ($request->has('invitecode')) {
                if (BackendUserController::checkInviteValid($request->input('invitecode')) == "valid") {

                } else {
                  echo "830A";
                }
              } else {
                if (UserProfileController::createUserProfile()) {
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
        } elseif ($request->input('command') == "DELETEUSERPROFILE") {
        } elseif ($request->input('command') == "DISABLEUSERPROFILE") {
        } elseif ($request->input('command') == "ENABLEUSERPROFILE") {
        } elseif ($request->input('command') == "LOCKUSERPROFILE") {
        } elseif ($request->input('command') == "UNLOCKUSERPROFILE") {
        } elseif ($request->input('command') == "DISABLEUSER2FAADMIN") {
        } elseif ($request->input('command') == "ENABLEUSER2FAADMIN") {
        } elseif ($request->input('command') == "ENABLEUSER2FA") {
        } elseif ($request->input('command') == "CONFIRMUSER2FA") {
        } elseif ($request->input('command') == "REMOVEUSER2FA") {
        } elseif ($request->input('command') == "CHECK2FASTATUS") {
        } elseif ($request->input('command') == "GET2FAQRCODE") {
        } elseif ($request->input('command') == "REMOVEPENDINGTOKEN") {
        } elseif ($request->input('command') == "UPDATESERVERDATA") {
        } else {
          echo "300A";
        }
      } else {
        echo "300A";
      }
    } else {
      echo "200E";
    }
  }
}
?>
