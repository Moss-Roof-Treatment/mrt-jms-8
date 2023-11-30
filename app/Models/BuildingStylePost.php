<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingStylePost extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'building_style_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_style_post_type_id',
        'material_type_id',
        'title',
        'description',
        'roof_outline_image_path',
        'building_image_path',
        'completed_date',
    ];

    /** 
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'completed_date'
    ];

    /**
     * This model has no timestamps.
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
     * Get the material type associated with the building style post.
     */
    public function material_type()
    {
        return $this->belongsTo('App\Models\MaterialType');
    }

    /**
     * Get the building style post type associated with the building style post.
     */
    public function building_style_post_type()
    {
        return $this->belongsTo('App\Models\BuildingStylePostType');
    }
}
