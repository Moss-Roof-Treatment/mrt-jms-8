<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentDocument extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_id',
        'title',
        'description',
        'image_path',
        'document_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the equipment associated with the equipment document.
     */
    public function equipment() 
    {
        return $this->belongsTo('App\Models\Equipment');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get equipment document image or placeholder.
     */
    public function get_document_image() 
    {
        // Check if the file exists on the server.
        if (file_exists(public_path($this->image_path))) {
            $value = $this->image_path;
        } else {
            $value = "storage/images/placeholders/document-256x256.jpg";
        }
        // Return the value.
        return $value;
    }
}
