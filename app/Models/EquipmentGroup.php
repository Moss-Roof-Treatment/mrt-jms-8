<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentGroup extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'is_editable',
        'is_delible',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get image or placeholder.
     */
    public function get_image() 
    {
        // Check if the file exists on the server.
        if ($this->image_path != null && file_exists(public_path($this->image_path))) {
            $value = $this->image_path;
        } else {
            $value = "storage/images/placeholders/tools-256x256.jpg";
        }
        // Return the value.
        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the equipment associated with the equipment category.
     */
    public function equipments() 
    {
        return $this->hasMany('App\Models\Equipment');
    }
}
