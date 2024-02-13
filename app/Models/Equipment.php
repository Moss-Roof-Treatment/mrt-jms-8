<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'equipment_category_id',
        'equipment_group_id',
        'title',
        'brand',
        'description',
        'serial_number',
        'image_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the owner associated with the equipment.
     */
    public function owner() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the category associated with the equipment.
     */
    public function equipment_category() 
    {
        return $this->belongsTo('App\Models\EquipmentCategory');
    }

    /**
     * Get the category associated with the equipment.
     */
    public function equipment_group() 
    {
        return $this->belongsTo('App\Models\EquipmentGroup');
    }

    /**
     * Get the inspections associated with the equipment.
     */
    public function equipment_inspections()
    {
        return $this->hasMany('App\Models\EquipmentInspection');
    }

    /**
     * Get the notes associated with the equipment.
     */
    public function notes() 
    {
        return $this->hasMany('App\Models\Note');
    }

    /**
     * Get the decuments associated with the equipment.
     */
    public function equipment_documents() 
    {
        return $this->hasMany('App\Models\EquipmentDocument');
    }
    
    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get equipment image or placeholder.
     */
    public function get_equipment_image() 
    {
        return $this->image_path != null
        ? $this->image_path
        : "storage/images/placeholders/tools-256x256.jpg";
    }

    /**
     * Get equipment latest inspection.
     */
    public function get_latest_inspection() 
    {
        return $this->equipment_inspections->count() >= 1
        ? date('d/m/Y', strtotime($this->equipment_inspections->last()->inspection_date))
        : '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
    }
}
