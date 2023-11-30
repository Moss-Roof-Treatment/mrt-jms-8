<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_logins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'referrer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user associated with the login login.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
