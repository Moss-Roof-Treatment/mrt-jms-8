<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsTemplate;
use App\Models\SmsRecipientGroup;
use App\Models\GroupSms;
use App\Models\SentGroupSms;
use App\Models\System;
use App\Models\User;
use Auth;
use Nexmo\Laravel\Facade\Nexmo;

class GroupSmsController extends Controller
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
        $all_sms = GroupSms::orderBy('id', 'desc')
            ->get();
        // Return the index view.
        return view('menu.sms.group.index')
            ->with('all_sms', $all_sms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find all templates.
        $templates = SmsTemplate::where('is_groupable', 1) // Is groupable.
            ->get();
        // Find all user groups.
        $user_groups = SmsRecipientGroup::all();
        // Message
        $text = null;
        // Return the create view.
        return view('menu.sms.group.create')
            ->with([
                'text' => $text,
                'templates' => $templates,
                'user_groups' => $user_groups
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
            'text' => 'sometimes|nullable|string|min:5|max:500',
            'sms_template' => 'required|integer',
            'recipient_group' => 'required|integer',
        ]);
        // Select the required action.
        switch ($request->action) {
            // Find users from the slected recipient group.
            case 'search':
                // Set The Required Variables.
                // Find all templates.
                $sms_templates = SmsTemplate::where('is_groupable', 1) // Is groupable.
                    ->get();
                // Set selected sms template.
                $selected_sms_template = SmsTemplate::find($request->sms_template);
                // All sms groups.
                $sms_groups = SmsRecipientGroup::all();
                // Set recipient group.
                $selected_sms_group = SmsRecipientGroup::find($request->recipient_group);
                // Decode the json user array from db.
                $users_array = json_decode($selected_sms_group->users_array, true); // may not need to be set to an associative array.
                // Find all users from the decoded array.
                $selected_users = User::find($users_array);
                // If a message has not been entered use the template text.
                $text = isset($request->text) ? $request->text : $selected_sms_template->text;
                // Return the create view.
                return view('menu.sms.group.recipients.create')
                    ->with([
                        'text' => $text,
                        'selected_users' => $selected_users,
                        'sms_templates' => $sms_templates,
                        'selected_sms_template' => $selected_sms_template,
                        'sms_groups' => $sms_groups,
                        'selected_sms_group' => $selected_sms_group
                    ]);
            break;
            // Create the required sms.
            case 'create':
                // Set The Required Variables.
                // Find the current system.
                $selected_system = System::firstOrFail(); // Moss Roof Treatment.
                // Find selected sms template.
                $selected_sms_template = SmsTemplate::find($request->sms_template);
                // Concatinate the template text to the entered text.
                $text = isset($request->text) ? $request->text . ' ' . $selected_sms_template->text : $selected_sms_template->text;
                // Set recipient group.
                $selected_sms_group = SmsRecipientGroup::find($request->recipient_group);
                // Find the required users to send message to.
                $selected_users = User::find($request->users);
                // Create the new Group SMS model instance
                $new_group_sms = GroupSms::create([
                    'staff_id' => Auth::id(),
                    'sms_recipient_group_id' => $selected_sms_group->id,
                    'sms_template_id' => $selected_sms_template->id,
                    'text' => $text
                ]);
                // Loop through each selected user.
                foreach($selected_users as $user) {
                    // Check if the user has a phone number.
                    if ($user->mobile_phone != null) {
                        // Send the sms.
                        Nexmo::message()->send([
                            'to'   => '61' . substr($request->mobile_phone, 1), // Remove the leading 0 and add country code of '61',
                            'from' => '61' . substr($selected_system->default_sms_phone, 1), // Remove the leading 0 and add country code of '61',
                            'text' => 'Hello ' . $user->first_name . ', ' . $selected_sms_template->text . ' ' . $selected_system->contact_name . ' ' . $selected_system->short_title 
                        ]);

                        // Create model instance.
                        SentGroupSms::create([
                            'group_sms_id' => $new_group_sms->id,
                            'customer_id' => $user->id,
                            'name' => $user->getFullNameAttribute(),
                            'recipient' => $user->mobile_phone
                        ]);
                    }
                }
                // Return redirect to the index page.
                return redirect()
                    ->route('group-sms.index')
                    ->with('success', 'You have successfully sent a group sms to the selected recipients.');
            break;
        }
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
        $selected_sms = GroupSms::findOrFail($id);
        // Return the show view.
        return view('menu.sms.group.show')
            ->with('selected_sms', $selected_sms);
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
        $selected_sms = GroupSms::findOrFail($id);
        // Delete the selected model instance.
        $selected_sms->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('group-sms.index')
            ->with('success', 'You have successfully trashed the selected group sms.');
    }
}
