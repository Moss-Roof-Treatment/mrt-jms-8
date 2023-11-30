<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledPayment extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'scheduled_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id',
        'payment_amount',
        'payment_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'payment_date',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the job associated with the quote.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get all deposit payment type model instances.
     */
    public function getFormattedPaymentAmount()
    {
        // Get all deposit payment type model instances regardless of void status. 
        return '$' . number_format(($this->payment_amount / 100), 2, '.', ',');
    }

    /**
     * Get all deposit payment type model instances.
     */
    public function getFormattedDate()
    {
        // Get all deposit payment type model instances regardless of void status. 
        return date('d/m/Y', strtotime($this->payment_date));
    }
}
