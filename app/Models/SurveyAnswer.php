<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'survey_answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'survey_id',
        'survey_question_id',
        'answer',
    ];

    /**
     * This model has no timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Model Relationships
     */

    public function survey_question()
    {
        return $this->belongsTo('App\Models\SurveyQuestion');
    }

    public function survey()
    {
        return $this->belongsTo('App\Models\Survey');
    }
}
