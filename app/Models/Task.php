<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_type_id',
        'building_style_id',
        'building_type_id',
        'dimension_id',
        'material_type_id',
        'title',
        'procedure',
        'description',
        'price',
        'image_path',
        'uses_product',
        'is_quote_visible',
        'is_selectable',
        'is_editable',
        'is_delible',
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
     * Get the task type associated with the task.
     */
    public function task_type()
    {
        return $this->belongsTo('App\Models\TaskType');
    }

    /**
     * Get the dimension associated with the task.
     */
    public function dimension()
    {
        return $this->belongsTo('App\Models\Dimension');
    }

    /**
     * Get the material type associated with the task.
     */
    public function material_type()
    {
        return $this->belongsTo('App\Models\MaterialType');
    }

    /**
     * Get the building style associated with the task.
     */
    public function building_style()
    {
        return $this->belongsTo('App\Models\BuildingStyle');
    }

    /**
     * Get the building type associated with the task.
     */
    public function building_type()
    {
        return $this->belongsTo('App\Models\BuildingType');
    }

    /**
     * Get the quote tasks associated with the task.
     */
    public function quote_tasks()
    {
        return $this->hasMany('App\Models\QuoteTask');
    }
}
