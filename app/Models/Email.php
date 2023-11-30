<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory;

    /**
     * Use soft deletes.
     */
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'recipient_name',
        'recipient_email',
        'subject',
        'text',
        'comment',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the staff member associated with the email.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the attachments associated with the email.
     */
    public function attachments()
    {
        return $this->hasMany('App\Models\EmailAttachment');
    }
}
