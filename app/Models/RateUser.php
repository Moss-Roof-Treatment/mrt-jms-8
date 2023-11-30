<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rate_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate_id',
        'user_id',
        'price',
    ];

    /**
     * Indicates if the model should be timestamped.
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
     * Get the user associated with the rate.
     */
    public function rate()
    {
        return $this->belongsTo('App\Models\Rate');
    }

    /**
     * Get the user associated with the rate.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
