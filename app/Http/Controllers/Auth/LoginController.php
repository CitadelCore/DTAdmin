<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Session\SessionController;
use App\Http\Controllers\Backend\BackendUserController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
      return view('layouts/user/login');
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
      if (Auth::attempt(['user' => $userid, 'password' => $passwordhash, 'disabled' => 0])) {
        if ($user->ip_check_banned() == true && $user->checkbrute($userid) == true) {
          return true;
        } else {
          $user->attemptInsert($userid);
          return false;
        }
      }
    }
}
