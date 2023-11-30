<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentInspection extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment_inspections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipment_id',
        'staff_id',
        'inspection_company',
        'inspector_name',
        'tag_and_test_id',
        'text',
        'inspection_date',
        'next_inspection_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'inspection_date',
        'next_inspection_date'
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the equipment associated with the equipment inspection.
     */
    public function equipment() 
    {
        return $this->belongsTo('App\Models\Equipment');
    }

    /**
     * Get the inspection images associated with the equipment inspection.
     */
    public function images()
    {
        return $this->hasMany('App\Models\EquipmentInspectionImage');
    }
}
