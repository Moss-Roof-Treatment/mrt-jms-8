<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentGroupEmail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sent_group_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_email_id',
        'customer_id',
        'job_id',
        'name',
        'recipient',
        'response',
        'response_text',
        'internal_comment',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */
    
    /**
     * Get the customer associated with the sent group email.
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the job associated with the sent group email.
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
}
