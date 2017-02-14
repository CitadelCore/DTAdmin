<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Session\SessionController;
use App\Http\Controllers\Backend\BackendUserController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/panel.php';
    protected $loginPath = '/login.php';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $user = new SessionController;
    }

    public function __destruct()
    {
      unset($user);
    }

    public function showLoginForm() {
      return view('layouts/user/login');
    }

    public function logout() {
      Auth::logout();
      return view('layouts/user/signout');
    }

    protected function validator(array $data)
    {
      return Validator::make($data, [
          'userid' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'passwordhash' => 'required|min:6|confirmed',
          'firstname' => 'required|max:255',
          'lastname' => 'required|max:255'
      ]);
    }

    public function authenticate($userid, $passwordhash)
    {
      $user = new SessionController;
      if (Auth::attempt(['user' => $userid, 'password' => $passwordhash, 'disabled' => 0], true)) {
        if ($user->ip_check_banned() == false && $user->checklocked($userid) == false) {
          return true;
        } else {
          $user->attemptInsert("0");
          $user->syslogInsert(0, $userid, "Login attempt from banned IP or account locked");
          return false;
        }
      } else {
        $user->attemptInsert("0");
        $user->syslogInsert(0, $userid, "Invalid login attempt");
        return false;
      }
    }
}
