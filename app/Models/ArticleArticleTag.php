<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleArticleTag extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_article_tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'article_id',
        'article_tag_id',
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
     * Get the article associated with the article article tag.
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    /**
     * Get the article tag associated with the article article tag.
     */
    public function article_tag()
    {
        return $this->belongsTo('App\Models\ArticleTag');
    }
}
