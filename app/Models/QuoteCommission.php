<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteCommission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_commission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'quote_id',
        'salesperson_id',
        'invoice_id',
        'quote_total',
        'total_percent',
        'individual_percent_value',
        'is_completed',
        'edited_total',
        'approval_date',
    ];

    /** 
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'approval_date',
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
     * Get the job associated with the commission salesperson.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the salesperson associated with the commission salesperson.
     */
    public function salesperson()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the salesperson associated with the commission salesperson.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
