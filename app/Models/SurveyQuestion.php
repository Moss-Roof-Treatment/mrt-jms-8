<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'survey_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */   
    protected $fillable = [
        'question',
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

    public function answers()
    {
        return $this->hasMany('App\Models\SurveyAnswer');
    }
}
