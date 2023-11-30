<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobImageQuote extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_image_quote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_image_id',
        'quote_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote associated with the image.
     */
    public function quote() 
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the job image associated with the quote.
     */
    public function job_image() 
    {
        return $this->belongsTo('App\Models\JobImage');
    }
}
