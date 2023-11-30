<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteTaxInvoiceItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_tax_invoice_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'quote_id',
        'title',
        'quantity',
        'individual_price',
        'total_price',
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
     * Get the quote associated with the quote task.
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
     * Get the total price of all quote tasks.
     */
    public function getIndividualPriceAttribute()
    {
        return '$' . number_format(($this->attributes['individual_price'] / 100), 2, '.', ',');
    }

    /**
     * Get the total price of all quote tasks.
     */
    public function getTotalPriceAttribute()
    {
        return '$' . number_format(($this->attributes['total_price'] / 100), 2, '.', ',');
    }
}
