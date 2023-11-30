<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLogin;

class UserLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isStaff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find all of the required model instances.
        $all_user_logins = UserLogin::with('user')
            ->with('user.account_role')
            ->get();
        // Return the index view.
        return view('menu.settings.userLogins.index')
            ->with('all_user_logins', $all_user_logins);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_user_login = UserLogin::findOrFail($id);
        // Set The Required Variables.
        $all_selected_user_logins = UserLogin::where('user_id', $selected_user_login->user_id)
            ->orderBy('id', 'desc')
            ->get();
        // Return the show view.
        return view('menu.settings.userLogins.show')
            ->with('all_selected_user_logins', $all_selected_user_logins)
            ->with('selected_user_login', $selected_user_login);
    }
}
