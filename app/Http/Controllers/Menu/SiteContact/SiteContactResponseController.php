<?php

namespace App\Http\Controllers\Menu\SiteContact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SiteContact\ContactFormReply;
use App\Models\SiteContact;
use App\Models\SiteContactResponse;
use App\Models\System;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SiteContactResponseController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'message' => 'required|string|min:15|max:2000',
        ]);
        // Set The Required Variables.
        // Get the system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Get the required site contact.
        $selected_site_contact = SiteContact::find($request->message_id);
        // Create the data array to populate the email with and then send the email.
        $data = [
            'recipient_email' => $selected_site_contact->email,
            'message' => $request->message,
            'sender_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'sender_email' => Auth::user()->email,
        ];
        // If the name is included in the site contact add it to the data array.
        if (isset($selected_site_contact->name)) {
            $data['recipient_name'] = $selected_site_contact->name;
        }
        Mail::to($data['recipient_email'])
            ->send(new ContactFormReply($data));
        // Save the response to the site contact in the database.
        SiteContactResponse::create([
            'site_contact_id' => $selected_site_contact->id,
            'staff_id' => Auth::id(),
            'text' => $request->message
        ]);
        // Mark the site contact as responded to by setting it to acknowledged.
        // Set read status.
        if ($selected_site_contact->seen_at == null) {
            // Update the selected model instance.
            $selected_site_contact->update([
                'seen_at' => Carbon::now()
            ]);
        }
        // Update the selected model instance.
        $selected_site_contact->update([
            'acknowledged_at' => Carbon::now()
        ]);
        // Return a redirect to the site contacts index form.
        return redirect()
            ->route('site-contacts.show', $selected_site_contact->id)
            ->with('success', 'You have successfully responded to the selected message from the site contact form.');
    }
}
