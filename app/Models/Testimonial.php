<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'testimonials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */   
    protected $fillable = [
        'user_id',
        'text',
        'is_visible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user associated with the testimonial.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
