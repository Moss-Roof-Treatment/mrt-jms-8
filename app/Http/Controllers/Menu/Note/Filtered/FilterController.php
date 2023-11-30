<?php

namespace App\Http\Controllers\Menu\Note\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountRole;

class FilterController extends Controller
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
    public function index(Request $request)
    {
        // All account roles.
        $all_account_roles = AccountRole::all('id', 'title');
        // Selected option.
        $selected_option = $request->account_role_id;
        // Put selected account role id into session.
        session(['filtered_account_role_id' => $request->account_role_id]);
        // Return the filtered view.
        return view('menu.notes.filtered.index')
            ->with([
                'all_account_roles' => $all_account_roles,
                'selected_option' => $selected_option
            ]);
    }
}
