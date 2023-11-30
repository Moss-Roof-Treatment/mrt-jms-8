<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'details',
        'description',
        'cost_price',
        'profit_amount',
        'postage_price',
        'price',
        'document_path',
        'is_visible',
        'is_selectable',
        'is_editable',
        'is_delible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote task associated with the quote.
     */
    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote task associated with the quote.
     */
    public function getFeaturedImage()
    {
        return $this->product_images()->where('is_featured', 1)->first();
    }
}
