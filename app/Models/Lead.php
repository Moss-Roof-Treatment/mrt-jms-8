<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_class_id',
        'staff_id',
        'salesperson_id',
        'referral_id',
        'lead_status_id',
        'email',
        'first_name',
        'last_name',
        'street_address',
        'suburb',
        'state',
        'postcode',
        'home_phone',
        'mobile_phone',
        'business_name',
        'abn',
        'business_phone',
        'description',
        'do_not_contact',
        'call_back_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'call_back_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the account class associated with the user.
     */
    public function account_class()
    {
        return $this->belongsTo('App\Models\AccountClass');
    }

    /**
     * Get the staff member associated with the lead generation.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the salesperson associated with the lead generation.
     */
    public function salesperson()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the referral associated with the lead generation.
     */
    public function referral()
    {
        return $this->belongsTo('App\Models\Referral');
    }

    /**
     * Get the articles associated with the tags.
     */
    public function lead_contacts()
    {
        return $this->hasMany('App\Models\LeadContact');
    }

    /**
     * Get the state associated with the lead.
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    /**
     * Get the state associated with the lead.
     */
    public function lead_status()
    {
        return $this->belongsTo('App\Models\LeadStatus');
    }
}
