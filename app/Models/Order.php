<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'staff_id',
        'order_name',
        'order_address',
        'order_suburb',
        'order_postcode',
        'order_email',
        'order_home_phone',
        'order_mobile_phone',
        'receipt_identifier',
        'order_name_on_card',
        'order_discount',
        'order_discount_code',
        'order_subtotal',
        'order_tax',
        'order_total',
        'payment_gateway',
        'has_processing_fee',
        'error',
        'courier_company_name',
        'postage_confirmation_number',
        'confirmation_date',
        'postage_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'confirmation_date',
        'postage_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user associated with the order.
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the staff member associated with the order.
     */
    public function staff() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the products associated with the order.
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity');
    }
}
