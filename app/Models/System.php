<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'systems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'short_title',
        'description',
        'acronym',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_bsb_number',
        'contact_name',
        'contact_address',
        'contact_phone',
        'default_sms_phone',
        'contact_email',
        'website_url',
        'abn',
        'default_tax_value',
        'default_superannuation_value',
        'default_total_commission',
        'default_petrol_price',
        'default_petrol_usage',
        'logo_path',
        'letterhead_path',
        'is_editable',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Display the formatted default tax value.
     */
    public function getDefaultTaxValue()
    {
        // Number format the value and add the dollar sign.
        return $this->default_tax_value / 100;
    }

    /**
     * Display the formatted default tax value.
     */
    public function getFormattedDefaultTaxValue()
    {
        // Number format the value and add the dollar sign.
        return $this->default_tax_value . '%';
    }

    /**
     * Display the formatted default tax value.
     */
    public function getDefaultSuperannuationValue()
    {
        // Number format the value and add the dollar sign.
        return $this->default_superannuation_value / 100;
    }

    /**
     * Display the formatted default tax value.
     */
    public function getFormattedDefaultSuperannuationValue()
    {
        // Number format the value and add the dollar sign.
        return $this->default_superannuation_value . '%';
    }

    /**
     * Display the formatted default commission value.
     */
    public function getDefaultCommissionValue()
    {
        // Number format the value and add the dollar sign.
        return $this->default_total_commission / 100;
    }

    /**
     * Display the formatted default commission value.
     */
    public function getFormattedDefaultCommissionValue()
    {
        // Number format the value and add the dollar sign.
        return $this->default_total_commission . '%';
    }

    /**
     * Display the formatted default commission value.
     */
    public function getFormattedContactNumber()
    {
        // Number format the value and add the dollar sign.
        return substr($this->contact_phone, 0, 4) . ' ' . substr($this->contact_phone, 4, 3) . ' ' . substr($this->contact_phone, 7, 3);
    }
}
