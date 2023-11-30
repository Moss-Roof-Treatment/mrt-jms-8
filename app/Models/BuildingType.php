<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingType extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'building_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
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
}
