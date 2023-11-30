<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id',
        'staff_id', 
        'payment_method_id',
        'payment_type_id',
        'payment_amount',
        'remaining_amount',
        'has_processing_fee',
        'payment_date',
        'void_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'payment_date',
        'void_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote associated with the quote payment.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the staff member associated with the quote payment.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the payment method associated with the quote payment.
     */
    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    /**
     * Get the payment type associated with the quote payment.
     */
    public function paymentType()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get the formatted payment amount.
     */
    public function getFormattedPaymentAmount()
    {
        return '$' . number_format(($this->payment_amount / 100), 2, '.', ',');
    }

    /**
     * Get the formatted payment tax amount.
     */
    public function getFormattedPaymentTaxAmount()
    {
        $value = $this->payment_amount / 11;

        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted payment creation date.
     */
    public function getFormattedCreationDate()
    {
        return date('d/m/y', strtotime($this->created_at));
    }
}
