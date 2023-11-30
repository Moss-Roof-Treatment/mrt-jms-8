<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupEmailAttachment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_email_attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_email_id',
        'title',
        'storage_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */
    
    /**
     * Get the email associated with the email attachment.
     */
    public function group_email()
    {
        return $this->belongsTo('App\Models\GroupEmail');
    }
}
