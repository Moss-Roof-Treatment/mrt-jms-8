<?php

namespace App\Http\Controllers\Menu\SiteContact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteContact;

class EmptyTrashController extends Controller
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
        // Set variables and continue if not null or redirect back if null.
        $deleted_site_contacts = SiteContact::onlyTrashed()->get();
        // Secondary validation.
        if (!$deleted_site_contacts->count()) {
            // Return a redirect back.
            return back()
                ->with('warning', 'There are no trashed notes to be permanently deleted.');
        }
        // Delete job notes and responses if not null.
        if ($deleted_site_contacts != null) {
            foreach($deleted_site_contacts as $deleted_site_contact) {
                $deleted_site_contact->responses()->forceDelete();
                $deleted_site_contact->forceDelete();
            }
        }
        // Return a redirect to the trashed notes index page.
        return redirect()
            ->route('site-contacts-trashed.index')
            ->with('success', 'You have successfully permanently deleted all trashed site contacts.');
    }
}
