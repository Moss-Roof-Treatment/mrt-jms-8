<?php

namespace App\Http\Controllers\Menu\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SystemController extends Controller
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
        // Find the required model instance.
        $selected_system = System::findOrFail($id); // Moss Roof Treatment.
        // Return the show view.
        return view("menu.system.show")
            ->with('selected_system', $selected_system);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_system = System::findOrFail($id); // Moss Roof Treatment.
        // Return the show view.
        return view("menu.system.edit")
            ->with('selected_system', $selected_system);
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
        // Validate the request data
        $request->validate([
            'title' => 'required|string|min:3|max:80|unique:systems,title,'.$id,
            'contact_name' => 'required|string',
            'contact_address' => 'required|string',
            'contact_phone' => 'required|regex:/^[\s\d]+$/',
            'contact_email' => 'required|string',
            'website_url' => 'required|string',
            'description' => 'sometimes|nullable|string|min:10|max:1000',
            'acronym' => 'required|string|min:2|max:8|unique:systems,acronym,'.$id,
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_bsb_number' => 'required|string',
            'default_tax_value' => 'required|string',
            'default_superannuation_value' => 'required|string',
            'default_total_commission' => 'required|string',

            'default_petrol_price' => 'required|numeric',
            'default_petrol_usage' => 'required|numeric',

            'letterhead' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'logo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find the required model instance.
        $selected_system = System::findOrFail($id); // Moss Roof Treatment.

        // Update the selected model instance.
        $selected_system->update([
            'title' => ucfirst($request->title),
            'contact_name' => $request->contact_name,
            'contact_address' => $request->contact_address,
            'contact_phone' => str_replace(' ', '', $request->contact_phone) ?? null,
            'contact_email' => $request->contact_email,
            'website_url' => $request->website_url,
            'description' => $request->description,
            'acronym' => strtoupper($request->acronym),
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => str_replace(' ', '', $request->bank_account_number) ?? null,
            'bank_bsb_number' => $request->bank_bsb_number,
            'default_tax_value' => $request->default_tax_value,
            'default_superannuation_value' => $request->default_superannuation_value,
            'default_total_commission' => $request->default_total_commission,
            'default_petrol_price' => intval(preg_replace("/[^0-9.]/", "", $request->default_petrol_price) * 100),
            'default_petrol_usage' => $request->default_petrol_usage,
        ]);

        // Update image if required.
        if (isset($request->letterhead)){
            if ($selected_system->letterhead != null) {
                if (file_exists(public_path($selected_system->letterhead))) {
                    unlink(public_path($selected_system->letterhead));
                }
            }
            $letterhead = $request->file('letterhead');
            $filename = Str::slug($selected_system->title) . '_letterhead' . '.' . $letterhead->getClientOriginalExtension();
            $location = public_path('storage/images/letterheads/' . $filename);
            Image::make($letterhead)->orientate()->save($location);
            // Update the selected model instance.
            $selected_system->update([
                'letterhead_path' => 'storage/images/letterheads/' . $filename
            ]);
        }

        // Update logo if required.
        if (isset($request->logo)){
            if ($selected_system->logo != null) {
                if (file_exists(public_path($selected_system->logo))) {
                    unlink(public_path($selected_system->logo));
                }
            }
            $logo = $request->file('logo');
            $filename = Str::slug($selected_system->title) . '-logo' . '.' . $logo->getClientOriginalExtension();
            $location = public_path('storage/images/logos/' . $filename);
            Image::make($logo)->orientate()->save($location);
            // Update the selected model instance.
            $selected_system->update([
                'logo_path' => 'storage/images/logos/' . $filename
            ]);
        }

        // Return a redirect to the show route
        return redirect()
            ->route('systems.show', $id)
            ->with('success', 'You have successfully updated the selected system.');
    }
}
