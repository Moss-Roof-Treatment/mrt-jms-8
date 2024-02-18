<?php

namespace App\Http\Controllers\Menu\Email\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate;
use App\Models\EmailUserGroup;
use App\Models\GroupEmail;
use App\Models\GroupEmailAttachment;
use App\Models\SentGroupEmail;
use App\Models\System;
use App\Models\User;
use Auth;

class GroupEmailController extends Controller
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
        $emails = GroupEmail::orderBy('id', 'desc')
            ->get();
        // Return the index view.
        return view('menu.emails.group.index')
            ->with('emails', $emails);
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
        $templates = EmailTemplate::where('is_groupable', 1) // Is groupable.
            ->get();
        // Find all user groups.
        $user_groups = EmailUserGroup::all();
        // Subject
        $subject = null;
        // Message
        $text = null;
        // Return the create view.
        return view('menu.emails.group.create')
            ->with([
                'subject' => $subject,
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
            'subject' => 'sometimes|nullable|string|min:5|max:100',
            'text' => 'sometimes|nullable|string|min:5|max:2500',
            'email_template' => 'required|integer',
            'recipient_group' => 'required|integer',
        ]);
        // Select the required action.
        switch ($request->action) {
            // Find users from the slected recipient group.
            case 'search':
                // Set The Required Variables.
                // Find all templates.
                $email_templates = EmailTemplate::where('is_groupable', 1) // Is groupable.
                    ->get();
                // Set selected email template.
                $selected_email_template = EmailTemplate::find($request->email_template);
                // All email groups.
                $email_groups = EmailUserGroup::all();
                // Set recipient group.
                $selected_email_group = EmailUserGroup::find($request->recipient_group);
                // Decode the json user array from db.
                $users_array = json_decode($selected_email_group->users_array, true); // may not need to be set to an associative array.
                // Find all users from the decoded array.
                $selected_users = User::find($users_array);
                // If a subject has not been entered use the template text.
                $subject = isset($request->subject) ? $request->subject : $selected_email_template->subject;
                // If a message has not been entered use the template text.
                $text = isset($request->text) ? $request->text : $selected_email_template->text;
                // Return the create view.
                return view('menu.emails.group.recipients.create')
                    ->with([
                        'subject' => $subject,
                        'text' => $text,
                        'selected_users' => $selected_users,
                        'email_templates' => $email_templates,
                        'selected_email_template' => $selected_email_template,
                        'email_groups' => $email_groups,
                        'selected_email_group' => $selected_email_group
                    ]);
            break;
            // Create the required emails.
            case 'create':
                // Set The Required Variables.
                // Find the current system.
                $selected_system = System::firstOrFail(); // Moss Roof Treatment.
                // Find selected email template.
                $selected_email_template = EmailTemplate::find($request->email_template);
                // If a subject is not supplied use the template version.
                $subject = isset($request->subject) ? $request->subject : $selected_email_template->subject;
                // If a message is not supplied use the template version.
                $text = isset($request->text) ? $request->text : $selected_email_template->text;
                // Find email template class name.
                $template_class_name = $selected_email_template->class_name;
                // Set recipient group.
                $selected_email_group = EmailUserGroup::find($request->recipient_group);
                // Json encode the selected user array from form checkboxes.
                $selected_users = User::find($request->users);
                // Create a new model instance.
                $new_group_email = GroupEmail::create([
                    'staff_id' => Auth::id(),
                    'email_user_group_id' => $selected_email_group->id,
                    'email_template_id' => $selected_email_template->id,
                    'subject' => $subject,
                    'text' => $text
                ]);
                // Upload the image.
                // Check for uploaded document.
                if ($request->hasFile('documents')) {
                    // Number for attachment title.
                    $i = 1;
                    // Loop through each uploaded document.
                    foreach($request->file('documents') as $document){
                        // Set the filename - use pathinfo to remove the extention from the original name.
                        $filename = $i++ . '-' . pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $document->extension();
                        // Store document.
                        $document->storeAs('public/documents/emails', $filename);
                        // Create the attachment model instance.
                        GroupEmailAttachment::create([
                        'group_email_id' => $new_group_email->id,
                        'title' => $filename,
                        'storage_path' => 'storage/documents/emails/' . $filename
                        ]);
                    }
                }
                // Create the required emails.
                // Loop through each selected user.
                foreach($selected_users as $user) {
                    // Create data variable for populating email.
                    $data = [
                        'email_id' => $new_group_email->id,
                        'recipient_name' => $user->getFullNameAttribute(),
                        'recipient_email' => $user->email,
                        'subject' => $request->subject,
                        'message' => $request->text,
                        'sender_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                        'sender_email' => Auth::user()->email,
                    ];
                    // Create the new email.
                    Mail::to($data['recipient_email'])
                        ->send(new $template_class_name($data));
                    // Create model instance.
                    SentGroupEmail::create([
                        'group_email_id' => $new_group_email->id,
                        'customer_id' => $user->id,
                        'job_id' => $user->jobs()->count() ? $user->jobs()->latest()->first()->id : null,
                        'name' => $user->getFullNameAttribute(),
                        'recipient' => $user->email
                    ]);
                }
                // Return redirect to the index page.
                return redirect()
                    ->route('group-emails.index')
                    ->with('success', 'You have successfully sent a group email to the selected recipients.');
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
        $selected_email = GroupEmail::findOrFail($id);
        // Return the show view.
        return view('menu.emails.group.show')
            ->with('selected_email', $selected_email);
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
        $selected_email = GroupEmail::findOrFail($id);
        // Delete the selected model instance.
        $selected_email->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('group-emails.index')
            ->with('success', 'You have successfully trashed the selected group email.');
    }
}
