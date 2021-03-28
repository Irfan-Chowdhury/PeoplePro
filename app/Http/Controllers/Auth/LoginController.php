<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
     protected function authenticated(Request $request, $user) 
     {
        if ($user->login_type=='general') {
            return $this->gotoResponseRequest($request, $user);
        }
        else if ($user->login_type=='ip' && $user->ip_address==$request->ip()) {
            return $this->gotoResponseRequest($request, $user);
        }else {
            Auth::logout();
            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function gotoResponseRequest($request, $user)
    {
        //-----Previus Code----
        //saving login timestamps and ip after login
        $user->timestamps = false;
        $user->last_login_date = Carbon::now()->toDateTimeString();
        $user->last_login_ip = $request->ip();
        $user->save();

        if ($user->role_users_id == 1)
        {
            return redirect('/admin/dashboard');
        } // if client 
        elseif ($user->role_users_id == 3)
        {
            return redirect('/client/dashboard');
        } //if employee
        else 
        {
            return redirect('/employee/dashboard');
        }
    }


	public function username()
	{
		return 'username';
	}

}
