<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadContact extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lead_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'staff_id',
        'text',
        'call_back_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'call_back_date',
    ];

    /**
     * Get the staff member associated with the lead contact.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }
}
