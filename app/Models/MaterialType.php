<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'material_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'mpa_coverage',
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
