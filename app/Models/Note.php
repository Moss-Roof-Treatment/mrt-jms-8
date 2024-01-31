<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
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
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'quote_id',
        'event_id',
        'equipment_id',
        'sender_id',
        'recipient_id',
        'priority_id',
        'text',
        'is_internal',
        'profile_job_can_see',
        'recipient_seen_at',
        'recipient_acknowledged_at',
        'jms_seen_at',
        'jms_acknowledged_at',
        'image_path',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'recipient_seen_at',
        'recipient_acknowledged_at',
        'jms_seen_at',
        'jms_acknowledged_at',
        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the job associated with the note.
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    /**
     * Get the quote associated with the note.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the priority associated with the note.
     */
    public function priority()
    {
        return $this->belongsTo('App\Models\Priority');
    }

    /**
     * Get the sender associated with the note.
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the recipient associated with the note.
     */
    public function recipient()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the equipment associated with the note.
     */
    public function equipment()
    {
        return $this->belongsTo('App\Models\Equipment');
    }

    /**
     * Get the recipient associated with the note.
     */
    public function note_images()
    {
        return $this->hasMany('App\Models\NoteImage');
    }
}
