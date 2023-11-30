<?php

namespace App\Http\Controllers\Menu\SiteContact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteContact;
use Carbon\Carbon;

class SiteContactController extends Controller
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
        // New site contacts.
        $new_site_contacts = SiteContact::where('seen_at', null)
            ->get();
        // Seen site contacts.
        $seen_site_contacts = SiteContact::where('seen_at', '!=', null)
            ->where('acknowledged_at', null)
            ->get();
        // Acknowledged site contacts.
        $acknowledged_site_contacts = SiteContact::where('seen_at', '!=', null)
            ->where('acknowledged_at', '!=', null)
            ->get();
        // Return a redirect to the index route.
        return view('menu.siteContacts.index')
            ->with([
                'new_site_contacts' => $new_site_contacts,
                'seen_site_contacts' => $seen_site_contacts,
                'acknowledged_site_contacts' => $acknowledged_site_contacts
            ]);
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
        $selected_site_contact = SiteContact::findOrFail($id);
        // Set read status.
        if ($selected_site_contact->seen_at == null) {
            $selected_site_contact->update([
                'seen_at' => Carbon::now()
            ]);
        }
        // Return the show view.
        return view('menu.siteContacts.show')
            ->with('selected_site_contact', $selected_site_contact);
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
        // Find the required model instance.
        $selected_site_contact = SiteContact::findOrFail($id);
        // Update the selected model instance.
        // Update the acknowledged status.
        if ($selected_site_contact->acknowledged_at != null) {
            // Unacknowledge.
            $selected_site_contact->update([
                'seen_at' => Carbon::now(),
                'acknowledged_at' => null
            ]);
        } else {
            // Acknowledge.
            $selected_site_contact->update([
                'seen_at' => Carbon::now(),
                'acknowledged_at' => Carbon::now()
            ]);
        }
        // Return a redirect to the index route.
        return redirect()
            ->route('site-contacts.index')
            ->with('success', 'You have successfull changed the acknowledgement status of the selected site contact message.');
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
        $selected_site_contact = SiteContact::findOrFail($id);
        // Delete the selected model instance.
        // Soft delete the site contact.
        $selected_site_contact->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('site-contacts.index')
            ->with('status', 'You have successfully trashed the selected site contact message.');
    }
}
