<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginStatus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'colour_id',
        'title',
        'description',
        'message',
        'can_login',
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
     * Get the user associated with the login status.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * Get the user associated with the login status.
     */
    public function colour()
    {
        return $this->belongsTo('App\Models\Colour');
    }
}
