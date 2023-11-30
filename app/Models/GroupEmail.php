<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupEmail extends Model
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
    protected $table = 'group_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'email_user_group_id',
        'email_template_id',
        'subject',
        'text',
        'internal_comment',
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
     * Get the staff member associated with the email.
     */
    public function email_template()
    {
        return $this->belongsTo('App\Models\EmailTemplate');
    }

    /**
     * Get the staff member associated with the email.
     */
    public function email_user_group()
    {
        return $this->belongsTo('App\Models\EmailUserGroup');
    }

    /**
     * Get the staff member associated with the email.
     */
    public function sent_group_emails()
    {
        return $this->hasMany('App\Models\SentGroupEmail');
    }

    /**
     * Get the attachments associated with the email.
     */
    public function attachments()
    {
        return $this->hasMany('App\Models\GroupEmailAttachment');
    }
}
