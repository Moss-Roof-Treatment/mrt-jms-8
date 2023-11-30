<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteReminderResponse extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_reminder_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id',
        'reminder_response_status_id',
        'response',
        'default_response',
        'is_acknowledged',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the email associated with the email attachment.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the email associated with the email attachment.
     */
    public function reminder_response_status()
    {
        return $this->belongsTo('App\Models\ReminderResponseStatus');
    }
}
