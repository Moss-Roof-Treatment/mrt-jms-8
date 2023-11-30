<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\LoginStatus;
use App\Models\UserLogin;
use Carbon\Carbon;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * The username variable.
     *
     * @var string
     */
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = 'username';
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

        /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Check user status.
        if ($user->login_status_id != 1) {
            // Find the required user login status.
            $selected_login_status = LoginStatus::find($user->login_status_id);
            // Get the login status message.
            $message = $selected_login_status->message;
            // Log the user out.
            $this->logout($request);
            // Return them to the log in form.
            return back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    // This is where we are providing the error message.
                    $this->username() => $message,
                ]);
        } else {
            // Update the last_login_date value on the user model instance with carbon now.
            $user->update([
                'last_login_date' => Carbon::now()
            ]);
            // Create a new userlogin model instance.
            UserLogin::create([
                'user_id' => $user->id,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'referrer' => $_SERVER['HTTP_REFERER'],
            ]);
        }
    }
}
