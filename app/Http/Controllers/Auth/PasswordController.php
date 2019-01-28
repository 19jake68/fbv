<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;
use Mail;
use Log; 
class PasswordController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;

  /**
   * Create a new password controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Set password form
   *
   */
  public function setPasswordPage() {
    return View('auth.passwords.setpassword');
  }

  public function setPassword(Request $request) {
    $validator = Validator::make($request->all(), [
      'password' => 'required|min:6',
			'password_confirmation' => 'required|min:6|same:password'
    ]);
		
		if ($validator->fails()) {
			return \Redirect::to(config('laraadmin.adminRoute') . '/password/set')->withErrors($validator);
		}
    
    $user = Auth::user();
    $user->password = bcrypt($request->password);
    $user->save();
    
    \Session::flash('success_message', 'Password is successfully changed');
		
		// Send mail to User his new Password
		if(env('MAIL_USERNAME') != null && env('MAIL_USERNAME') != "null" && env('MAIL_USERNAME') != "") {
			// Send mail to User his new Password
			Mail::send('emails.send_login_cred_change', ['user' => $user, 'password' => $request->password], function ($m) use ($user) {
				$m->from(LAConfigs::getByKey('default_email'), LAConfigs::getByKey('sitename'));
				$m->to($user->email, $user->name)->subject('LaraAdmin - Login Credentials chnaged');
			});
		} else {
			Log::info("User change_password: username: ".$user->email." Password: ".$request->password);
    }
    
    return redirect(config('laraadmin.adminRoute') . '/');
  }
}
