<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentInspectionImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment_inspection_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_inspection_id',
        'description',
        'image_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */
    
    /**
     * Get the equipment associated with the equipment inspection.
     */
    public function equipment_inspection() 
    {
        return $this->belongsTo('App\Models\EquipmentInspection');
    }
}
