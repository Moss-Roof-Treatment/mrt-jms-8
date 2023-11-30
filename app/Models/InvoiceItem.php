<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'invoice_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'job_id',
        'total_hours',
        'billable_hours',
        'cost',
        'cost_total',
        'description',
        'completed_date',
        'start_time',
        'end_time',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'completed_date',
        'start_time',
        'end_time',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the invoice associated with the invoice item.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    /**
     * Get the formatted invoice total.
     */
    public function getFormattedCost()
    {
        // Set the tax variable.
        return '$' . number_format(($this->cost) / 100, 2, '.', ',');
    }

    /**
     * Get the formatted invoice total.
     */
    public function getFormattedCostTotal()
    {
        // Set the tax variable.
        return '$' . number_format(($this->cost_total) / 100, 2, '.', ',');
    }
}
