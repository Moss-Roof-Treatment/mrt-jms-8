<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'title',
        'storage_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the message associated with the message attachment.
     */
    public function message()
    {
        return $this->belongsTo('App\Models\Message');
    }
}
