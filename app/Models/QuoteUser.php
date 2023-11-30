<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */  
    protected $fillable = [
        'quote_id',
        'tradesperson_id',
        'optional_message',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote associated with the quote task.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the job task associated with the quote task.
     */
    public function tradesperson()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions.
    |--------------------------------------------------------------------------
    */

    /**
     * Get the job task associated with the quote task.
     */
    public function getFormattedCreationDate()
    {
        if ($this->created_at == null) {
            // The date is null so return a message.
            return 'Not Applicable';
        } else {
            // Return the date.
            return date('d/m/y', strtotime($this->created_at));
        }
    }
}
