<?php

namespace App\Http\Controllers\Menu\Email\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\System;

class ViewEmailTemplateController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set The Required Variables.
        // Email Template.
        $selected_template = EmailTemplate::findOrFail($id);
        // Find the current system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Email Template Class.
        $email = $selected_template->class_name;
        // Return the mailable in the view.
        return new $email($selected_template, $selected_system);
    }
}
