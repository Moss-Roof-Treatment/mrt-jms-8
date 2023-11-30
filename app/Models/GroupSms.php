<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSms extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_sms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'sms_recipient_group_id',
        'sms_template_id',
        'text',
        'is_delible',
        'is_delible',
        'is_delible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the staff member associated with the sms.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the template associated with the sms.
     */
    public function sms_template()
    {
        return $this->belongsTo('App\Models\SmsTemplate');
    }

    /**
     * Get the recipient group associated with the sms.
     */
    public function sms_recipient_group()
    {
        return $this->belongsTo('App\Models\SmsRecipientGroup');
    }

    /**
     * Get the staff member associated with the sms.
     */
    public function sent_group_sms()
    {
        return $this->hasMany('App\Models\SentGroupSms', 'group_sms_id');
    }
}
