<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'quote_id',
        'quote_request_id',
        'user_id',
        'staff_id',
        'title',
        'description',
        'color',
        'textColor',
        'image_paths',
        'is_personal',
        'start',
        'end',
        'is_tradesperson_confirmed',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'start',
        'end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the staff member associated with the event.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the user associated with the event.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the notes associated with the event.
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    /**
     * Get the notes associated with the event.
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    /**
     * Get the notes associated with the event.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the notes associated with the event.
     */
    public function quote_request()
    {
        return $this->belongsTo('App\Models\QuoteRequest');
    }
}
