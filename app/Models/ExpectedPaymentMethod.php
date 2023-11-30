<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpectedPaymentMethod extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'expected_payment_methods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_type_id',
        'payment_method_id',
        'title',
        'description',
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
     * Get the staff member associated with the event.
     */
    public function payment_type()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }

    /**
     * Get the staff member associated with the event.
     */
    public function payment_method()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }
}
