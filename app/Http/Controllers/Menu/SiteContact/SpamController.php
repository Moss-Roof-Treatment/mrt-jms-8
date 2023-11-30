<?php

namespace App\Http\Controllers\Menu\SiteContact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpamFilter;
use App\Models\SiteContact;

class SpamController extends Controller
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
        // Set The Required Variables.
        // Find the required site contact.
        $selected_site_contact = SiteContact::find($request->site_contact_id);
        // Create new spam filter model instance.
        SpamFilter::create([
            'message' => $selected_site_contact->text,
            'user_agent' => $selected_site_contact->user_agent,
            'ip_address' => $selected_site_contact->ip_address,
            'referrer' => $selected_site_contact->referrer
        ]);
        // Update the selected site contact model instance.
        $selected_site_contact->update([
            'is_spam' => 1
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully added the senders IP address to the spam filter.');
    }
}
