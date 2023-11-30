<?php

namespace App\Http\Controllers\Menu\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountClass;
use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\MaterialType;
use Carbon\Carbon;

class PropertySearchController extends Controller
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
        // Set The Required Variables.
        // All account classes.
        $all_account_classes = AccountClass::whereNotBetween('id', [1, 2]) // Only non staff account classes.
            ->select('id', 'title')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // All building styles.
        $all_building_styles = BuildingStyle::orderBy('id', 'asc')
            ->select('id', 'title')
            ->get();
        // All building types.
        $all_building_types = BuildingType::all('id', 'title');
        // All job statuses.
        $all_job_statuses = JobStatus::all('id', 'title');
        // All material types.
        $all_material_types = MaterialType::all('id', 'title');
        // Return the index view.
        return view('menu.search.properties.index')
            ->with([
                'all_account_classes' => $all_account_classes,
                'all_building_styles' => $all_building_styles,
                'all_building_types' => $all_building_types,
                'all_job_statuses' => $all_job_statuses,
                'all_material_types' => $all_material_types
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Confirm request data exists.
        if ($request->street_address == null && $request->suburb == null && $request->postcode == null && $request->material_type_id == null && $request->building_style_id == null && $request->building_type_id == null && $request->account_class_id == null && $request->start_date == null && $request->end_date == null && $request->job_status_id == null) {
            // Return back.
            return back()
                ->with('warning', 'You must enter at least one field to search for a property.');
        }

        // Validate The Request Data.
        $request->validate([
            'street_address' => 'sometimes|nullable|string|min:8|max:100',
            'suburb' => 'sometimes|nullable|string|min:3|max:60',
            'postcode' => 'sometimes|nullable|numeric|min:1000|max:9999',
            'state' => 'sometimes|nullable|string',
            'start_date' => 'sometimes|nullable|string|required_with:end_date',
            'end_date' => 'sometimes|nullable|string|required_unless:start_date,null',
        ]);

        // Find selected model instances.
        $properties = Job::where(function($q) use ($request) {
            // Street Address.
            if (isset($request->street_address)) {
                $q->where('tenant_street_address','LIKE','%'.$request->street_address.'%');
            }   
            // Suburb.
            if (isset($request->suburb)) {
                $q->where('tenant_suburb','LIKE','%'.$request->suburb.'%');
            }
            // Postcode.
            if (isset($request->postcode)) {
                $q->where('tenant_postcode','LIKE','%'.$request->postcode.'%');
            }
            // Material Type.
            if (isset($request->material_type_id)) {
                $q->where('material_type_id', $request->material_type_id);
            }
            // Building Style.
            if (isset($request->building_style_id)) {
                $q->where('building_style_id', $request->building_style_id);
            }
            // Building Type.
            if (isset($request->building_type_id)) {
                $q->where('building_type_id', $request->building_type_id);
            }
            // Account Class.
            if (isset($request->account_class_id)) {
                $q->whereHas('customer', function ($q) use ($request) {
                    $q->where('account_class_id', $request->account_class_id);
                });
            }
            // Dates.
            if (isset($request->start_date)) {
                // Set the start date.
                $start_date = Carbon::parse($request->start_date);
                // Set the end date.
                $end_date = isset($request->end_date)
                    ? Carbon::parse($request->end_date)->endOfDay()
                    : Carbon::parse($request->start_date)->endOfDay();
                $q->whereBetween('completion_date', [$start_date, $end_date]);
            }
            // Account Class.
            if (isset($request->job_status_id)) {
                $q->where('job_status_id', $request->job_status_id);
            }
        })
        ->with('customer')
        ->with('job_status')
        ->get();
        // Set The Required Variables.
        $data = [
            'account_class_id' => $request->account_class_id,
            'building_style_id' => $request->building_style_id,
            'material_type_id' => $request->material_type_id,
            'building_type_id' => $request->building_type_id,
            'job_status_id' => $request->job_status_id,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'postcode' => $request->postcode,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        // All account classes.
        $all_account_classes = AccountClass::whereNotBetween('id', [1, 2]) // Only non staff account classes.
            ->select('id', 'title')
            ->withCount('users') // This needs the count to order by it below.
            ->orderBy('users_count', 'desc') // Count is used here.
            ->get();
        // All building styles.
        $all_building_styles = BuildingStyle::orderBy('id', 'asc')
            ->select('id', 'title')
            ->get();
        // All building types.
        $all_building_types = BuildingType::all('id', 'title');
        // All job statuses.
        $all_job_statuses = JobStatus::all('id', 'title');
        // All material types.
        $all_material_types = MaterialType::all('id', 'title');
        // Return the show view.
        return view('menu.search.properties.show')
            ->with([
                'all_account_classes' => $all_account_classes,
                'all_building_styles' => $all_building_styles,
                'all_building_types' => $all_building_types,
                'all_job_statuses' => $all_job_statuses,
                'all_material_types' => $all_material_types,
                'data' => $data,
                'properties' => $properties
            ]);
    }
}
