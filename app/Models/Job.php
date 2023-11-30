<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'salesperson_id',
        'job_status_id',
        'job_progress_id',
        'material_type_id',
        'building_style_id',
        'building_type_id',
        'inspection_type_id',
        'follow_up_call_status_id',
        'quote_sent_status_id',
        'default_properties_to_view_id',
        'label',
        'tenant_name',
        'tenant_home_phone',
        'tenant_mobile_phone',
        'tenant_street_address',
        'tenant_suburb',
        'tenant_postcode',
        'is_visable',
        'is_editable',
        'is_delible',
        'inspection_date',
        'sold_date',
        'start_date_null',
        'start_date',
        'completion_date',
    ];

    /** 
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'inspection_date',
        'sold_date',
        'start_date',
        'completion_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quotes associated with the job.
     */
    public function event()
    {
        return $this->hasOne('App\Models\Event');
    }

    /**
     * Get the building style associated with the job.
     */
    public function building_style() 
    {
        return $this->belongsTo('App\Models\BuildingStyle');
    }

    /**
     * Get the building type associated with the job.
     */
    public function building_type() 
    {
        return $this->belongsTo('App\Models\BuildingType');
    }

    /**
     * Get the customer associated with the job.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the default properties to view associated with the job.
     */
    public function default_properties_to_view()
    {
        return $this->belongsTo('App\Models\DefaultPropertiesToView');
    }

    /**
     * Get the follow up call status associated with the job.
     */
    public function follow_up_call_status()
    {
        return $this->belongsTo('App\Models\FollowUpCallStatus');
    }

    /**
     * Get the inspection type associated with the job.
     */
    public function inspection_type() 
    {
        return $this->belongsTo('App\Models\InspectionType');
    }

    /**
     * Get the job images associated with the job.
     */
    public function job_images() 
    {
        return $this->hasMany('App\Models\JobImage');
    }

    /**
     * Get the job progress associated with the job.
     */
    public function job_progress()
    {
        return $this->belongsTo('App\Models\JobProgress');
    }

    /**
     * Get the job status associated with the job.
     */
    public function job_status()
    {
        return $this->belongsTo('App\Models\JobStatus');
    }

    /**
     * Get the job types associated with the job.
     */
    public function job_types()
    {
        return $this->belongsToMany('App\Models\JobType');
    }

    /**
     * Get the material types associated with the job.
     */
    public function material_type()
    {
        return $this->belongsTo('App\Models\MaterialType');
    }

    /**
     * Get the quotes associated with the job.
     */
    public function quotes()
    {
        return $this->hasMany('App\Models\Quote');
    }

    /**
     * Get the quotes associated with the job.
     */
    public function quote_request()
    {
        return $this->hasOne('App\Models\QuoteRequest');
    }

    /**
     * Get the quote sent status associated with the job.
     */
    public function quote_sent_status()
    {
        return $this->belongsTo('App\Models\QuoteSentStatus');
    }

    /**
     * Get the salesperson associated with the job.
     */
    public function salesperson()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions.
    |--------------------------------------------------------------------------
    */

    /**
     * Reset the quote identifiers of all required quotes.
     */
    public function resetQuoteIdentifiers()
    {
        // Create a variable equal to 1 to loop through.
        $i = 1;
        // Get all quotes related to the selected job.
        $all_selected_quotes = $this->quotes()->get();
        // Loop through each quote.
        foreach($all_selected_quotes as $quote) {
            // Update the quote identifier and then increment the variable by 1.
            $quote->update([
                'quote_identifier' => $this->id . '-' . $i++
            ]);
        }
        // Return true.
        return true;
    }

    /**
     * Get the formated completed date.
     */
    public function getFormattedCompletedDate()
    {
        if (isset($this->completion_date)) {
            return date('d/m/y', strtotime($this->completion_date));
        }
    }

    /**
     * Get the formated inspection date.
     */
    public function getFormattedInspectionDate()
    {
        if (isset($this->inspection_date)) {
            return date('Y/m/d', strtotime($this->inspection_date));
        }
    }

    /**
     * Get the formated start date.
     */
    public function getFormattedSoldDate()
    {
        if (isset($this->sold_date)) {
            return date('d/m/y', strtotime($this->sold_date));
        } else {
            return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>';
        }
    }

    /**
     * Get the formated start date.
     */
    public function getFormattedStartDate()
    {
        if (isset($this->start_date)) {
            return date('d/m/y', strtotime($this->start_date));
        } else {
            return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>';
        }
    }

    /**
     * Get first roof outline image path.
     */
    public function getFirstRoofOutlineImagePath()
    {
        if ($this->job_images()->exists()) {
            return $this->job_images()->where('job_image_type_id', 3)->first()->image_path ?? null;
        }
    }

    /**
     * Get All quote users.
     */
    public function getAllQuoteUsers()
    {
        return $this->hasManyThrough(QuoteUser::class, Quote::class);
    }
}
