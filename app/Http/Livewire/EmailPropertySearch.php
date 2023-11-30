<?php

namespace App\Http\Livewire;

use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\MaterialType;
use App\Models\EmailUserGroup;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class EmailPropertySearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // All The Required Variables.
    public $building_style_id = '';
    public $building_type_id = '';
    public $material_type_id = '';
    public $job_status_id = '';
    public $postcode = '';
    public $email = '';
    public $street_address = '';
    public $suburb = '';
    public $title = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $users = [];

    public function render()
    {
        // Set The Required Variables.
        // Get all building styles.
        $all_building_styles = BuildingStyle::orderBy('id')
            ->select('id', 'title')
            ->get();
        // Get all building styles.
        $all_building_types = BuildingType::all('id', 'title');
        // Get all material types.
        $all_material_types = MaterialType::all('id', 'title');
        // Get all job statuses.
        $all_job_statuss = JobStatus::orderBy('id')
            ->select('id', 'title')
            ->get();

        // Validation.
        // Check if all variables are set.
        if ($this->material_type_id == null && $this->building_style_id == null && $this->building_type_id == null && $this->job_status_id == null && $this->email == null && $this->street_address == null && $this->suburb == null && $this->postcode == null && $this->start_date == null && $this->end_date == null) {
            // Set the results variable to an empty array as all inputs are null.
            $results = null;
        } else {
            // Search for all the required users.
            $results = Job::where(function($q) {
                // Material Type.
                if ($this->material_type_id != null) {
                    $q->where('material_type_id','LIKE','%'.$this->material_type_id.'%');
                }
                // Building Style.
                if ($this->building_style_id != null) {
                    $q->where('building_style_id','LIKE','%'.$this->building_style_id.'%');
                }
                // Building Type.
                if ($this->building_type_id != null) {
                    $q->where('building_type_id','LIKE','%'.$this->building_type_id.'%');
                }
                // Job Status.
                if ($this->job_status_id != null) {
                    $q->where('job_status_id','LIKE','%'.$this->job_status_id.'%');
                }
                // Street Address.
                if ($this->email != null) {
                    $q->whereRelation('customer','email','LIKE','%'.$this->email.'%');
                }
                // Street Address.
                if ($this->street_address != null) {
                    $q->where('tenant_street_address','LIKE','%'.$this->street_address.'%');
                }
                // Suburb.
                if ($this->suburb != null) {
                    $q->where('tenant_suburb','LIKE','%'.$this->suburb.'%');
                }
                // Postcode.
                if ($this->postcode != null) {
                    $q->where('tenant_postcode','LIKE','%'.$this->postcode.'%');
                }
                // Dates.
                if ($this->start_date != null) {
                    // Set the start date.
                    $start_date = Carbon::parse($this->start_date)->startOfDay();
                    // Set the end date.
                    $end_date = $this->end_date != null
                        ? Carbon::parse($this->end_date)->endOfDay()
                        : Carbon::parse($this->start_date)->endOfDay();
                    $q->whereBetween('inspection_date', [$start_date, $end_date]);
                }
            })->whereHas('customer', fn ($q) => $q->whereNotNull('email')) // Customer with not null email.
            ->with(['customer' => fn ($q) => $q->select('id', 'first_name', 'last_name', 'email')])
            ->with(['follow_up_call_status' => fn ($q) => $q->select('id', 'colour_id', 'title')])
            ->with(['follow_up_call_status.colour' => fn ($q) => $q->select('id', 'colour')])
            ->paginate(20);
        }
        // Return the view.
        return view('livewire.email-property-search', [
            'all_building_styles' => $all_building_styles,
            'all_building_types' => $all_building_types,
            'all_material_types' => $all_material_types,
            'all_job_statuses' => $all_job_statuss,
            'results' => $results
        ]);
    }

    // Form Validation.
    protected $rules = [
        'title' => 'required|string|min:5|max:100|unique:sms_recipient_groups,title',
        'description' => 'required|string|min:10|max:1000',
    ];

    // Form Action.
    public function submit()
    {
        // Validate the data.
        $this->validate();

        // Create the new model instance.
        $new_user_group = EmailUserGroup::create([
            'title' => ucwords($this->title),
            'description' => ucfirst($this->description),
            'users_array' => json_encode(array_values($this->users)), // Json encode the selected user array from form checkboxes and strip the indexing.
        ]);

        // Return a redirect to the show route.
        return redirect()
            ->route('email-recipient-groups.show', $new_user_group->id)
            ->with('success', 'You have successfully created the new email recipient group.');
    }
}