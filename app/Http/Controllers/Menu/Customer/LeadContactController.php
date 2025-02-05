<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadContact;
use Auth;
use Carbon\Carbon;

class LeadContactController extends Controller
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
            'call_back' => 'sometimes|nullable|string',
            'call_back_date_null' => 'sometimes|nullable|required_without:call_back',
            'comment' => 'required|string|min:10|max:5000'
        ]);
        // Create the new model instance.
        $new_lead_contact = LeadContact::create([
            'lead_id' => $request->lead_id,
            'staff_id' => Auth::id(),
            'text' => ucfirst($request->comment),
            'call_back_date' => Carbon::parse($request->call_back_date_null) ?? null
        ]);
        // Return the show view.
        return redirect()
            ->route('leads.show', $new_lead_contact->lead_id)
            ->with('success', 'You have successfully created a new customer lead.');
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
        $selected_lead_contact = LeadContact::findOrFail($id);
        // Return the show view.
        return view('menu.customers.leads.contacts.show')
            ->with('selected_lead_contact', $selected_lead_contact);
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
        $selected_lead_contact = LeadContact::findOrFail($id);
        // Set The Required Variables.
        $lead_id = $selected_lead_contact->lead_id;
        // Deleted the selected model instance.
        $selected_lead_contact->delete();
        // Return a redirect to the model relationship index page.
        return redirect()
            ->route('leads.show', $lead_id)
            ->with('success', 'You have successfully deleted the selected lead contact.');
    }
}
