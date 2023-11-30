<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyTestimonial extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'survey_testimonials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */   
    protected $fillable = [
        'survey_id',
        'text',
        'is_visible',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the survey associated with the testimonial.
     */
    public function survey()
    {
        return $this->belongsTo('App\Models\Survey');
    }
}
