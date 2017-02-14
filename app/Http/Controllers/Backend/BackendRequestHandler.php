<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\BackendUserController;

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
