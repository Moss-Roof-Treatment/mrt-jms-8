<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'surveys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id',
        'user_id',
        'tradesperson_id',
        'jms_is_acknowledged',
        'tradesperson_is_acknowledged',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote associated with the survey.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the user associated with the survey.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the tradesperson associated with the survey.
     */
    public function tradesperson()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the answers associated with the survey.
     */
    public function survey_answers()
    {
        return $this->hasMany('App\Models\SurveyAnswer');
    }

    /**
     * Get the answers associated with the survey.
     */
    public function survey_testimonial()
    {
        return $this->hasOne('App\Models\SurveyTestimonial');
    }
}
