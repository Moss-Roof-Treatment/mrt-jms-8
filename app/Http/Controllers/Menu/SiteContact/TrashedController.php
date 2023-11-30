<?php

namespace App\Http\Controllers\Menu\SiteContact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteContact;

class TrashedController extends Controller
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
        $trashed_site_contacts = SiteContact::onlyTrashed()->get();
        // Return the index view.
        return view('menu.siteContacts.trashed.index')
            ->with('trashed_site_contacts', $trashed_site_contacts);
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
        $trashed_site_contact = SiteContact::withTrashed()->find($id);
        // Return the show view.
        return view('menu.siteContacts.trashed.show')
            ->with('trashed_site_contact', $trashed_site_contact);
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
        $trashed_site_contact = SiteContact::withTrashed()->find($id);
        // update the required model instance.
        $trashed_site_contact->restore();
        // Return a redirect to the index view.
        return redirect()
            ->route('site-contacts-trashed.index')
            ->with('success', 'You have successfully restored the selected job note.');
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
        $selected_site_contact = SiteContact::withTrashed()->find($id);
        // Delete the required model relationships.
        if ($selected_site_contact->responses()->count()) {
            $selected_site_contact->responses()->forceDelete();
        }
        // Delete the selected model instance.
        $selected_site_contact->forceDelete();
        // Return a redirect to the index route.
        return redirect()
            ->route('site-contacts-trashed.index')
            ->with('status', 'You have successfully deleted the selected site contact message.');
    }
}
