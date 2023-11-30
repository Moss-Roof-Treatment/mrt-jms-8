<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountRole;
use App\Models\User;

class AccountRoleController extends Controller
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
        $all_account_roles = AccountRole::all();
        // Return the index view.
        return view('menu.settings.accountRoles.index')
            ->with('all_account_roles', $all_account_roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.accountRoles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|unique:account_roles,title',
            'description' => 'required',
        ]);
        // Create the new model instance.
        AccountRole::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return redirect to index route.
        return redirect()
            ->route('account-roles.index')
            ->with('success', 'You have successfully created a new account role.');
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
        $selected_role = AccountRole::findOrFail($id);
        // Set The Required Variables.
        $selected_users = User::where('account_role_id', $id)
            ->paginate(20);
        // Return the show view.
        return view('menu.settings.accountRoles.show')
            ->with([
                'selected_role' => $selected_role,
                'selected_users' => $selected_users
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_role = AccountRole::findOrFail($id);
        // Secondary validation.
        // Check is editable status is 0.
        if ($selected_role->is_editable == 0) {
            // Return redirect to the show view and show uneditable warning message.
            return redirect()
                ->route('account-roles.show', $selected_role->id)
                ->with('warning', 'This account role is not editable.');
        }
        // Return the edit view.
        return view('menu.settings.accountRoles.edit')
            ->with('selected_role', $selected_role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|unique:account_roles,title,'.$id,
            'description' => 'required',
        ]);
        // Find the required model instance.
        $selected_role = AccountRole::findOrFail($id);
        // Update the selected model instance.
        $selected_role->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('account-roles.show', $selected_role->id)
            ->with('success', 'You have successfully updated the selected account role.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_role = AccountRole::findOrFail($id);
        // Secondary validation.
        // Check is editable status.
        if ($selected_role->is_delible == 0) {
            // Return redirect to the show view and show uneditable warning message.
            return redirect()
                ->route('account-roles.show', $selected_role->id)
                ->with('warning', 'This account role is not editable.');
        }
        // Delete the selected model instance.
        $selected_role->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('account-roles.index')
            ->with('success', 'You have successfully deleted the selected account role.');
    }
}
