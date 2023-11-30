<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'staff_id',
        'description',
        'alt_tag_label',
        'image_path',
        'is_visible',
        'is_featured',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the equipment associated with the equipment inspection.
     */
    public function article() 
    {
        return $this->belongsTo('App\Models\Article');
    }

    /**
     * Get the user associated with the equipment inspection.
     */
    public function staff() 
    {
        return $this->belongsTo('App\Models\User');
    }
}
