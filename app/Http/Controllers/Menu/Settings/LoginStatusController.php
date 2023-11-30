<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginStatus;
use App\Models\User;

class LoginStatusController extends Controller
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
        $all_login_statuses = LoginStatus::withCount('users')
        ->paginate(20);
        // Return the index view.
        return view('menu.settings.loginStatuses.index')
            ->with('all_login_statuses', $all_login_statuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.loginStatuses.create');
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
            'title' => 'required|min:5|max:50|unique:account_classes,title',
            'description' => 'required|min:15|max:500',
            'message' => 'required|min:15|max:500',
        ]);
        // Create the new model instance.
        LoginStatus::create([
            'title' => ucwords($request->title),
            'description' => $request->description,
            'message' => $request->message
        ]);
        // Return redirect to index route.
        return redirect()
            ->route('login-statuses-settings.index')
            ->with('success', 'You have successfully created a new login status.');
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
        $selected_login_status = LoginStatus::findOrFail($id);
        // Set The Required Variables.
        $selected_users = User::where('login_status_id', $id)
            ->paginate(20);
        // Return the show view.
        return view('menu.settings.loginStatuses.show')
            ->with([
                'selected_login_status' => $selected_login_status,
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
        $selected_login_status = LoginStatus::findOrFail($id);
        // Validate editing status.
        // Check is editable status.
        if ($selected_login_status->is_editable == 0) {
            // Return redirect to the show view and show uneditable warning message.
            return redirect()
                ->route('login-statuses-settings.show', $selected_login_status->id)
                ->with('warning', 'This account class is not editable.');
        }
        // Return the edit view.
        return view('menu.settings.loginStatuses.edit')
            ->with('selected_login_status', $selected_login_status);
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
            'title' => 'required|min:5|max:50|unique:account_classes,title,'.$id,
            'description' => 'required|min:15|max:500',
            'message' => 'required|min:15|max:500',
        ]);
        // Find the required model instance.
        $selected_login_status = LoginStatus::findOrFail($id);
        // Update the selected model instance.
        $selected_login_status->update([
            'title' => ucwords($request->title),
            'description' => $request->description,
            'message' => $request->message
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('login-statuses-settings.show', $selected_login_status->id)
            ->with('success', 'You have successfully updated the selected login status.');
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
        $selected_login_status = LoginStatus::findOrFail($id);
        // Validate delible status.
        // Check is editable status.
        if ($selected_login_status->is_delible == 0) {
            // Return redirect to the show view and show uneditable warning message.
            return redirect()
                ->route('login-statuses-settings.show', $selected_login_status->id)
                ->with('warning', 'This account class is not editable.');
        }
        // Delete the selected model instance.
        $selected_login_status->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('login-statuses-settings.index')
            ->with('success', 'You have successfully deleted the selected login status.');
    }
}
