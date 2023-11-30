<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GenericSms;
use App\Models\System;
use Auth;
use Nexmo\Laravel\Facade\Nexmo;

class GenericSmsController extends Controller
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
        // Return the index view.
        return view('menu.sms.generic.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the index view.
        return view('menu.sms.generic.create');
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
            'recipient_name' => 'sometimes|nullable|string|min:3|max:50',
            'mobile_phone' => 'required|regex:/^[\s\d]+$/',
            'message' => 'required|string|min:15|max:1000',
            'comment' => 'sometimes|nullable|string|min:15|max:500'
        ]);

        // Set The Required Variables.
        // Find the current system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.

        // Create a new model instance.
        $new_sms = GenericSms::create([
            'sender_id' => Auth::id(),
            'recipient_name' => $request->recipient_name,
            'mobile_phone' => $request->mobile_phone,
            'text' => $request->message,
            'comment' => $request->comment
        ]);

        // Send the sms.
        Nexmo::message()->send([
            'to'   => '61' . substr($request->mobile_phone, 1), // Remove the leading 0 and add country code of '61',
            'from' => '61' . substr($selected_system->default_sms_phone, 1), // Remove the leading 0 and add country code of '61',
            'text' => 'Hello ' . $request->recipient_name . ', ' . $request->message . ' ' . $selected_system->contact_name . ' ' . $selected_system->short_title
        ]);

        // Return a redirect to the show route.
        return redirect()
            ->route('generic-sms.show', $new_sms->id)
            ->with('success', 'You have successfully sent the generic sms to ' . $new_sms->recipient_sms . '.');
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
        $selected_sms = GenericSms::findOrFail($id);
        // Return the show view.
        return view('menu.sms.generic.show')
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
        $selected_sms = GenericSms::findOrFail($id);
        // Delete the selected model instance.
        $selected_sms->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('generic-sms.index')
            ->with('success', 'You have successfully deleted the selected sms.');
    }
}
