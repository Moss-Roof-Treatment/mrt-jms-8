<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'staff_id',
        'article_category_id',
        'type',
        'title',
        'slug',
        'subtitle',
        'text',
        'location',
        'is_visible',
        'completed_date',
        'published_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'completed_date',
        'published_date',
        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user associated with the article.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the category associated with the article.
     */
    public function article_category()
    {
        return $this->belongsTo('App\Models\ArticleCategory');
    }

    /**
     * Get the tags associated with the article.
     */
    public function article_tags()
    {
        return $this->belongsToMany('App\Models\ArticleTag');
    }

    /**
     * Get the inspection images associated with the equipment inspection.
     */
    public function article_images()
    {
        return $this->hasMany('App\Models\ArticleImage');
    }
}
