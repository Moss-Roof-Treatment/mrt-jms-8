<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsRecipientGroup;
use App\Models\User;

class SmsRecipientGroupController extends Controller
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
        $user_groups = SmsRecipientGroup::paginate(20);
        // Return the index view.
        return view('menu.sms.recipients.index')
            ->with('user_groups', $user_groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the view.
        return view('menu.sms.recipients.create');
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
        $selected_group = SmsRecipientGroup::findOrFail($id);
        // Set The Required Variables.
        // Decode the json user array from db.
        $users_array = json_decode($selected_group->users_array, true); // may not need to be set to an associative array.
        // Find all users from the decoded array.
        $users = User::find($users_array);
        // Return the show view.
        return view('menu.sms.recipients.show')
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
        $selected_group = SmsRecipientGroup::findOrFail($id);
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
            ->route('sms-recipient-groups.show', $id)
            ->with('success', 'You have successfully removed the selected user from the sms recipient group.');
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
        $selected_group = SmsRecipientGroup::findOrFail($id);
        // Validate model relationship existance.
        // Check if there are group sms with this sms template.
        if ($selected_group->group_sms()->exists()) {
            // Return a redirect back.
            return back()
                ->with('danger', 'Cannot delete the selected sms recipient group as there are group sms that contain this sms recipient group. Please delete the sms that contain this sms recipient group before attempting to delete this selected sms recipient group.');
        }
        // Delete the selected model instance.
        $selected_group->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('sms-recipient-groups.index')
            ->with('success', 'You have successfully deleted the selected sms recipient group.');
    }
}
