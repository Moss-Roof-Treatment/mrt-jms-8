<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\JobStatus;
use App\Models\JobType;
use App\Models\MaterialType;

class SmsRecipientGroupResultsController extends Controller
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
    public function index(Request $request)
    {
        // Confirm the request data.
        if ($request->material_type == null && $request->building_style == null && $request->building_type == null && $request->job_type == null && $request->job_status == null && $request->street_address == null && $request->suburb == null && $request->postcode == null) {
            // Return a redirect back.
            return back()
                ->with('warning', 'You must enter at least one field to search for a customers.');
        }
        // Validate The Request Data.
        $request->validate([
            'street_address' => 'sometimes|nullable|string|min:8|max:100',
            'suburb' => 'sometimes|nullable|string|min:3|max:60',
            'postcode' => 'sometimes|nullable|numeric|min:1000|max:9999',
        ]);
        // Find the required model instance.
        // JOB SEARCH.
        $results = Job::where(function($q) use ($request) {
            // Material type.
            if ($request->material_type != null) {
                $q->where('material_type_id', $request->material_type);
            }
            // Building style.
            if ($request->building_style != null) {
                $q->where('building_style_id', $request->building_style);
            }
            // Building type.
            if ($request->building_type != null) {
                $q->where('building_type_id', $request->building_type);
            }
            // Job status.
            if ($request->job_status != null) {
                $q->where('job_status_id', $request->job_status);
            }
            // Job type.
            if ($request->job_type != null) {
                $q->whereHas('job_types', function($q) use ($request) {
                    $q->where('job_type_id', $request->job_type);
                })->get();
            }
            // Street address.
            if ($request->street_address != null) {
                $q->where('tenant_street_address','LIKE','%'.$request->street_address.'%');
            }
            // Suburb.
            if ($request->suburb != null) {
                $q->where('tenant_suburb','LIKE','%'.$request->suburb.'%');
            }
            // Postcode.
            if ($request->postcode != null) {
                $q->where('tenant_postcode','LIKE','%'.$request->postcode.'%');
            }
        })        
        ->whereHas('customer', function ($q) {
            return $q->where('email', '!=', null); // Is visible on quote.
        })
        ->with('customer')
        ->with('follow_up_call_status')
        ->with('follow_up_call_status.colour')
        ->get();

        $data = [
            'selected_material_type' => $request->material_type,
            'selected_building_style' => $request->building_style,
            'selected_building_type' => $request->building_type,
            'selected_job_status' => $request->job_status,
            'selected_job_type' => $request->job_type,
            'selected_street_address' => $request->street_address,
            'selected_suburb' => $request->suburb,
            'selected_postcode' => $request->postcode,
        ];

        // Set the required data for the select dropdowns.
        $building_styles = BuildingStyle::all('id', 'title');
        $building_types = BuildingType::all('id', 'title');
        $material_types = MaterialType::all('id', 'title');
        $job_types = JobType::all('id', 'title');
        $job_statuses = JobStatus::all('id', 'title')
            ->sortBy('id');
        // Return the view.
        return view('menu.sms.recipients.search.create')
            ->with([
                'results' => $results,
                'data' => $data,
                'building_styles' => $building_styles,
                'building_types' => $building_types,
                'material_types' => $material_types,
                'job_types' => $job_types,
                'job_statuses' => $job_statuses
            ]);
    }
}
