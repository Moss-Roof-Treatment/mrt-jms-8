<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageReply extends Model
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
    protected $table = 'message_replies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'sender_id',
        'text',
        'is_visible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */
    
    /**
     * Get the sender associated with the message response.
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the message associated with the message response.
     */
    public function message()
    {
        return $this->belongsTo('App\Models\Message');
    }
}
