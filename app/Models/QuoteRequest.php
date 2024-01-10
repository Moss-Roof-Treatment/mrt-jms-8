<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'job_id',
        'quote_request_status_id',
        'staff_id',
        'building_style_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'home_phone',
        'mobile_phone',
        'street_address',
        'suburb',
        'postcode',
        'house',
        'carport',
        'veranda',
        'pergola',
        'garage',
        'garden_shed',
        'barn',
        'retirement_village',
        'industrial_shed',
        'house_unit',
        'school_buildings',
        'church',
        'shops',
        'iron',
        'slate',
        'laserlight',
        'cement',
        'terracotta',
        'paint',
        'solar_panels',
        'air_conditioner',
        'pool_heating',
        'under_aerial',
        'walls',
        'additions_laserlight',
        'outside_of_gutters',
        'concrete_paths',
        'additions_other',
        'has_water_tanks',
        'further_information',
        'is_customer_generated',
        'is_editable',
        'is_delible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the building style associated with the job.
     */
    public function job() 
    {
        return $this->belongsTo('App\Models\Job');
    }

    /**
     * Get the job task associated with the quote task.
     */
    public function quote_request_images()
    {
      return $this->hasMany('App\Models\QuoteRequestImage');
    }

    /**
     * Get the quote associated with the quote task.
     */
    public function quote_request_status()
    {
        return $this->belongsTo('App\Models\QuoteRequestStatus');
    }

    /**
     * Get the building style associated with the job.
     */
    public function building_style() 
    {
        return $this->belongsTo('App\Models\BuildingStyle');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get the users full name.
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * Get the users full name.
     */
    public function getFullPhoneNumber()
    {
        if ($this->mobile_phone || $this->home_phone) {
            $value = $this->mobile_phone;
        } else {
            $value = $this->home_phone ?? 'Not Applicable';
        }

        return $value;
    }
}
