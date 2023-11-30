<?php

namespace App\Http\Controllers\Menu\Email\UserGroup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\EmailUserGroup;
use App\Models\JobStatus;
use App\Models\JobType;
use App\Models\MaterialType;
use App\Models\User;

class UserGroupController extends Controller
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
        $user_groups = EmailUserGroup::paginate(20);
        // Return the index view.
        return view('menu.emails.recipients.index')
            ->with('user_groups', $user_groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        $building_styles = BuildingStyle::all('id', 'title');
        $building_types = BuildingType::all('id', 'title');
        $material_types = MaterialType::all('id', 'title');
        $job_statuses = JobStatus::all('id', 'title')
            ->sortBy('id');
        $job_types = JobType::all('id', 'title');
        // Return the view.
        return view('menu.emails.recipients.create')
            ->with([
                'building_styles' => $building_styles,
                'building_types' => $building_types,
                'material_types' => $material_types,
                'job_statuses' => $job_statuses,
                'job_types' => $job_types,
            ]);
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
            'title' => 'required|string|min:10|max:100|unique:email_user_groups,title',
            'description' => 'required|string|min:20|max:1000',
        ]);
        // Set The Required Variables.
        // Json encode the selected user array from form checkboxes.
        $selected_users = json_encode($request->users);
        // Create the new model instance.
        $new_user_group = EmailUserGroup::create([
            'title' => $request->title,
            'description' => $request->description,
            'users_array' => $selected_users
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('email-recipient-groups.show', $new_user_group->id)
            ->with('success', 'You have successfully created the new email user group.'); 
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
        $selected_group = EmailUserGroup::findOrFail($id);
        // Set The Required Variables.
        // Decode the json user array from db.
        $users_array = json_decode($selected_group->users_array, true); // may not need to be set to an associative array.
        // Find all users from the decoded array.
        $users = User::find($users_array);
        // Return the show view.
        return view('menu.emails.recipients.show')
            ->with([
                'selected_group' => $selected_group,
                'users' => $users
            ]);
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
            'selected_user' => 'required|integer'
        ]);
        // Find the required model instance.
        $selected_group = EmailUserGroup::findOrFail($id);
        // Set The Required Variables.
        // Json decode the users array.
        $users = json_decode($selected_group->users_array);
        // Set the required id value to delete from the request data.
        $value_to_delete = $request->selected_user;
        // Delete the selected value from the users array if it exists.
        if (($key = array_search($value_to_delete, $users)) !== false) {
            unset($users[$key]);
        }
        // Set empty array to be filled with the remaining users.
        $remaining_users = [];
        // Loop through each user and push them to the new empty remaining users array.
        foreach($users as $user) {
            array_push($remaining_users, $user);
        }
        // Update the selected model instance.
        // Save the modified users array.
        $selected_group->update([
            'users_array' => json_encode($remaining_users)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('email-recipient-groups.show', $id)
            ->with('success', 'You have successfully removed the selected user from the email user group.');
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
        $selected_group = EmailUserGroup::findOrFail($id);
        // Validate model relationship existance.
        // Check if there are group emails with this email template.
        if ($selected_group->group_emails()->exists()) {
            // Return a redirect back.
            return back()
                ->with('danger', 'Cannot delete the selected email user group as there are group emails that contain this email user group. Please delete the emails that contain this email user group before attempting to delete this selected email user group.');
        }
        // Delete the selected model instance.
        $selected_group->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('email-recipient-groups.index')
            ->with('success', 'You have successfully deleted the selected email user group.');
    }
}
