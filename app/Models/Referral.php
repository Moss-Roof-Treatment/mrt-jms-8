<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'referrals';

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
     * Get the users associated with the referral.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get the users associated with the referral.
     */
    public function usersCount()
    {
        return $this->users()->count();
    }
}
