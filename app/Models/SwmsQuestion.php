<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwmsQuestion extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'swms_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */   
    protected $fillable = [
        'swms_question_category_id',
        'question',
        'is_editable',
        'is_delible',
        'is_selectable',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote associated with the SWMS.
     */
    public function swms_question_category()
    {
        return $this->belongsTo('App\Models\SwmsQuestionCategory');
    }
}
