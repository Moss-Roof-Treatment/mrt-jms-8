<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
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
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'priority_id',
        'text',
        'slug',
        'sender_seen_at',
        'recipient_seen_at',
        'sender_is_visible',
        'recipient_is_visible',
        'jms_seen_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the sender associated with the message.
     */
    public function sender() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the recipient associated with the message.
     */
    public function recipient() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the replies associated with the message.
     */
    public function replies() 
    {
        return $this->hasMany('App\Models\MessageReply');
    }

    /**
     * Get the priority associated with the message.
     */
    public function priority() 
    {
        return $this->belongsTo('App\Models\Priority');
    }

    /**
     * Get the priority associated with the message.
     */
    public function message_attachments() 
    {
        return $this->hasMany('App\Models\MessageAttachment');
    }
}
