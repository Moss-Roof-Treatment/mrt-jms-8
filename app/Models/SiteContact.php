<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteContact extends Model
{
    use HasFactory;

    /**
     * Use soft deletes.
     */
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'name',
        'email',
        'contact_phone',
        'street_address',
        'suburb',
        'postcode',
        'text',
        'user_agent',
        'ip_address',
        'referrer',
        'is_spam',
        'seen_at',
        'acknowledged_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the contact response associated with the site contact.
     */
    public function responses()
    {
        return $this->hasMany('App\Models\SiteContactResponse');
    }
}
