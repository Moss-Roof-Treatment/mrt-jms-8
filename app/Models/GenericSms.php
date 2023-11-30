<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenericSms extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'generic_sms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipient_id',
        'sender_id',
        'job_id',
        'recipient_name',
        'mobile_phone',
        'text',
        'comment',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the recipient associated with the sms.
     */
    public function recipient()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the sender associated with the sms.
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the job associated with the sms.
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
}
