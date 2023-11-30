<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteContactResponse extends Model
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
    protected $table = 'site_contact_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'site_contact_id',
        'staff_id',
        'text',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the staff member associated with the site contact response.
     */
    public function site_contact()
    {
        return $this->belongsTo('App\Models\SiteContact');
    }

    /**
     * Get the staff member associated with the site contact response.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User');
    }
}
