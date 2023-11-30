<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteDocument extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'material_type_id',
        'task_type_id',
        'task_id',
        'title',
        'description',
        'image_path',
        'document_path',
        'is_editable',
        'is_delible',
        'is_default',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote document type associated with the quote document.
     */
    public function material_type()
    {
        return $this->belongsTo('App\Models\MaterialType');
    }

    /**
     * Get the quote document type associated with the quote document.
     */
    public function task_type()
    {
        return $this->belongsTo('App\Models\TaskType');
    }

    /**
     * Get the quote document type associated with the quote document.
     */
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
