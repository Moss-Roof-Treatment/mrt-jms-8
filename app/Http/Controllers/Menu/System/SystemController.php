<?php

namespace App\Http\Controllers\Menu\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        // Check the request data for the required file.
        if ($request->hasFile('letterhead')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_system->letterhead_path != null && file_exists(public_path($selected_system->letterhead_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_system->letterhead_path));
            }
            // Set the uploaded file.
            $image = $request->file('letterhead');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $letterhead_storage_location = 'storage/images/letterheads/' . $filename;
            // Set the new file location.
            $location = public_path($letterhead_storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
        }
        // Find the required model instance.
        $selected_system = System::findOrFail($id); // Moss Roof Treatment.
        // Check the request data for the required file.
        if ($request->hasFile('logo')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_system->logo_path != null && file_exists(public_path($selected_system->logo_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_system->logo_path));
            }
            // Set the uploaded file.
            $image = $request->file('logo');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $logo_storage_location = 'storage/images/logos/' . $filename;
            // Set the new file location.
            $location = public_path($logo_storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
        }
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
            'letterhead_path' => $letterhead_storage_location ?? $selected_system->letterhead_path,
            'logo_path' => $logo_storage_location ?? $selected_system->logo_path,
        ]);
        // Return a redirect to the show route
        return redirect()
            ->route('systems.show', $id)
            ->with('success', 'You have successfully updated the selected system.');
    }
}
