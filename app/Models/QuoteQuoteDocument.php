<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteQuoteDocument extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quote_quote_document';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id',
        'quote_document_id',
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
     * Get the quote document type associated with the quote document.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the quote document type associated with the quote document.
     */
    public function quote_document()
    {
        return $this->belongsTo('App\Models\QuoteDocument');
    }
}
