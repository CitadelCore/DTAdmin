<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\UserController as UserController;
use App\Model\UserSecretsModel;

class UserSecretController extends UserController {

  static function getUserSecretTable($userid) {
    $table = null;
      foreach (UserSecretsModel::where('userid', $userid)->get() as $secret) {
        if ($table == null) {
          $secretid = htmlspecialchars($secret['secretid']);
          $secretkey = htmlspecialchars($secret['secretkey']);
          $note = htmlspecialchars($secret['note']);
          $timecreated = htmlspecialchars($secret['timecreated']);
          $table = "<tr>
                    <td><a href='#' onclick='deleteSecretKeyConfirm($secretid)'><button type='button' class='btn btn-danger'><i class='fa fa-trash fa-fw'></i>Delete</button></a></td>
                    <td>$secretkey</td>
                    <td>$note</td>
                    <td>$timecreated</td>
                    </tr>
                    <br>";
        } else {
          $secretid = htmlspecialchars($secret['secretid']);
          $secretkey = htmlspecialchars($secret['secretkey']);
          $note = htmlspecialchars($secret['note']);
          $timecreated = htmlspecialchars($secret['timecreated']);
          $table = $table . "<tr>
                    <td><a href='#' onclick='deleteSecretKeyConfirm($secretid)'><button type='button' class='btn btn-danger'><i class='fa fa-trash fa-fw'></i>Delete</button></a></td>
                    <td>$secretkey</td>
                    <td>$note</td>
                    <td>$timecreated</td>
                    </tr>
                    <br>";
        }
      }
      if ($table !== null) {
        return $table;
      } else {
        return "";
      }
  }

  static function createSecretKey($userid, $keynote) {
    $date = date('Y-m-d h:i:s');
    $randkey = bin2hex(openssl_random_pseudo_bytes(15));
    $model = new UserSecretsModel;
    $model->userid = $userid;
    $model->secretkey = $randkey;
    $model->note = $keynote;
    $model->timecreated = $date;
    $model->save();
    return true;
  }

  static function deleteSecretKey($secretid, $userid) {
    $model = UserSecretsModel::where('secretid', $secretid)->where('userid', $userid)->delete();
    return true;
  }

  static function deleteAllUserSecrets($userid) {
    $model = UserSecretsModel::where('userid', $userid)->delete();
    return true;
  }

  static function queryUserSecret($secret) {
    $model = UserSecretsModel::where('secretkey', $secret)->get()->first();
    if ($model !== null) {
      if (UserController::CheckUserDisabled($model['userid'] == false)) {
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
