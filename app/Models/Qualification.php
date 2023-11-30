<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'qualifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */   
    protected $fillable = [
        'staff_id',
        'title',
        'description',
        'image_path',
        'issue_date',
        'expiry_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'issue_date',
        'expiry_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user associated with the qualification.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }
}
