<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_class_id',
        'account_role_id',
        'login_status_id',
        'referral_id',
        'state_id',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'street_address',
        'suburb',
        'state_id',
        'postcode',
        'home_phone',
        'mobile_phone',
        'user_description',
        'user_color',
        'is_subscribed_email',
        'is_subscribed_sms',
        'business_name',
        'abn',
        'business_phone',
        'business_contact_phone',
        'business_position',
        'bank_name',
        'bank_bsb',
        'bank_account_name',
        'bank_account_number',
        'business_description',
        'has_gst',
        'has_payg',
        'has_commissions',
        'super_fund_name',
        'super_member_numnber',
        'workcover_company_name',
        'image_path',
        'logo_path',
        'has_login_details',
        'kin_name',
        'kin_mobile_phone',
        'kin_address',
        'kin_relationship',
        'last_login_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_date' => 'datetime',
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
     * Get the account role associated with the user.
     */
    public function account_role()
    {
        return $this->belongsTo('App\Models\AccountRole');
    }

    /**
     * Get the login status associated with the user.
     */
    public function login_status()
    {
        return $this->belongsTo('App\Models\LoginStatus');
    }

    /**
     * Get the quotes associated with the user.
     */
    public function user_logins()
    {
        return $this->hasMany('App\Models\UserLogin');
    }

    /**
     * Get the referral associated with the user.
     */
    public function referral()
    {
        return $this->belongsTo('App\Models\Referral');
    }

    /**
     * Get the referral associated with the user.
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    /**
     * Get the jobs associated with the user.
     */
    public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'customer_id');
    }

    /**
     * Get the quotes associated with the user.
     */
    public function quotes()
    {
        return $this->hasMany('App\Models\Quote', 'customer_id');
    }

    /**
     * Get the quotes associated with the user.
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice', 'user_id');
    }

    /**
     * Get the quotes associated with the user.
     */
    public function qualifications()
    {
        return $this->hasMany('App\Models\Qualification', 'staff_id');
    }

    /**
     * Get the products associated with the order.
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * Get the salespersons associated with the job.
     */
    public function commissions()
    {
        return $this->belongsToMany('App\Models\Job', 'commission_salesperson');
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
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name) ?? null;
    }

    /**
     * Get the users full name.
     */
    public function getFullNameTitleAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name) . ' - ' . ucfirst($this->account_role->title) ?? null;
    }

    /**
     * Get the formatted last login attribute.
     */
    public function getLastLoginAttribute()
    {
        // Check if user has no logins.
        if ($this->last_login_date == null) {
            // Return note next.
            return '<i class="fas fa-circle text-danger mr-2" aria-hidden="true"></i>Never';
        } else {
            // User has a login.
            // Set 1 hour from now.
            if (now()->gt($this->last_login_date->addHour())) {
                // User login is not within the last hour.
                return '<i class="fas fa-circle text-secondary mr-2" aria-hidden="true"></i>' . date('Y/m/d', strtotime($this->last_login_date));
            } else {
                // User login is within the last hour.
                return '<i class="fas fa-circle text-success mr-2" aria-hidden="true"></i>' . date('Y/m/d', strtotime($this->last_login_date));
            }
        }
    }

    /**
     * Get the formatted last login attribute.
     */
    public function getLastLoginDateTime()
    {
        // Check if user has no logins.
        if ($this->last_login_date == null) {
            // Return note next.
            return '<i class="fas fa-circle text-danger mr-2" aria-hidden="true"></i>Never';
        } else {
            // User has a login.
            // Set 1 hour from now.
            if (now()->gt($this->last_login_date->addHour())) {
                // User login is not within the last hour.
                return '<i class="fas fa-circle text-secondary mr-2" aria-hidden="true"></i>' . date('Y/m/d - h:iA', strtotime($this->last_login_date));
            } else {
                // User login is within the last hour.
                return '<i class="fas fa-circle text-success mr-2" aria-hidden="true"></i>' . date('Y/m/d - h:iA', strtotime($this->last_login_date));
            }
        }
    }

    /**
     * Get the quotes associated with the user.
     */
    public function getOutstandingInvoiceModels()
    {
        // Get all invoices that have been confirmed in the office for group marking as paid.
        return $this->invoices()->where('paid_date', null)->with('invoice_items')->get();
    }

    /**
     * Get the quotes associated with the user.
     */
    public function getOutstandingConfirmedInvoiceModels()
    {
        // Get all invoices that have been confirmed in the office for group marking as paid.
        return $this->invoices()->where('paid_date', null)->where('confirmed_date', '!=', null)->with('invoice_items')->get();
    }
}
