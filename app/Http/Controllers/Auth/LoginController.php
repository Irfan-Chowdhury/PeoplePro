<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    //redirect to the login page

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


     // over riding the method for custom redirecting after login
     protected function authenticated(Request $request, $user) {

    	//saving login timestamps and ip after login
			 $user->timestamps = false;
			 $user->last_login_date = Carbon::now()->toDateTimeString();
			 $user->last_login_ip = $request->ip();
			 $user->save();
			 // if admin
			 if ($user->role_users_id == 1)
			 {
				 return redirect('/admin/dashboard');
			 } // if employee
			 elseif ($user->role_users_id == 2)
			 {
				 return redirect('/employee/dashboard');
			 } //if client
			 else
			 {
				 return redirect('/client/dashboard');
			 }
		 }


	public function username()
	{
		return 'username';
	}

}