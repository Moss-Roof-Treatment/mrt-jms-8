<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'order_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user associated with the order.
     */
    public function order() 
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * Get the staff member associated with the order.
     */
    public function product() 
    {
        return $this->belongsTo('App\Models\Product');
    }
}
