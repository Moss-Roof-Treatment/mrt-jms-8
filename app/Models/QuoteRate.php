<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'quote_id',
        'rate_id',
        'staff_id',
        'quantity',
        'description',
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

    /**
     * Get the job task associated with the quote task.
     */
    public function rate()
    {
        return $this->belongsTo('App\Models\Rate');
    }

    /**
     * Get the job task associated with the quote task.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }
}
