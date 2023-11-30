<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteProduct extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'quote_id',
        'product_id',
        'quantity',
        'description',
        'individual_price',
        'total_price',
        'price_per_litre',
        'usage_per_100_kms',
    ];

    /**
     * This model has no timestamps.
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
     * Get the product associated with the quote product.
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * Get the product associated with the quote product.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }
}
