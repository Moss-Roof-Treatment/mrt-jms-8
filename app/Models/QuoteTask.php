<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteTask extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'quote_id',
        'task_id',
        'quantity',
        'pitch',
        'description',
        'individual_price',
        'total_quantity',
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
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
