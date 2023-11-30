<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoofPitchMultiplyFactor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roof_pitch_multiply_factors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'min',
        'max',
        'value',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
