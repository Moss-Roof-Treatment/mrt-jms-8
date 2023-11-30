<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quote_id',
        'user_id',
        'staff_id',
        'identifier',
        'has_superannuation',
        'subtotal',
        'tax',
        'payg',
        'superannuation',
        'total',
        'confirmation_number',
        'is_group_paid',
        'finalised_date',
        'submission_date',
        'confirmed_date',
        'paid_date',
    ];

    /**
     * Model timestamps.
     *
     * @var string
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'finalised_date',
        'submission_date',
        'confirmed_date',
        'paid_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the quote associated with the invoice.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\Quote');
    }

    /**
     * Get the user associated with the invoice.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the items associated with the invoice.
     */
    public function invoice_items()
    {
        return $this->hasMany('App\Models\InvoiceItem');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Get the formatted invoice total.
     */
    public function getInvoiceQuoteRates()
    {
        // Check if the quote id is null.
        if ($this->quote_id == null) {
            // There is no quote id return null.
            return null;
        } else {
            // Get all quote rates that are related to the quote that is related to the invoice.
            return $this->quote()->first()->quote_rates()->where('staff_id', $this->user_id)->get();
        }
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getInvoiceSubtotal()
    {
        // Set the sum of the items.
        $invoice_subtotal = $this->invoice_items()->sum('cost_total');
        // Return the invoice total.
        return $invoice_subtotal;
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getInvoiceTax()
    {
        // Check if the user has tax set.
        if ($this->user->has_gst == 0) {
            // GST is not required.
            // Return 0.
            return 0;  
        } else {
            // GST is required.
            // Sum of the items, then multiply 0.10, then round.
            $invoice_tax = round($this->invoice_items()->sum('cost_total') * \App\Models\System::first()->getDefaultTaxValue());
            // Return the calculated amount.
            return $invoice_tax;
        }
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getInvoiceSuperannuation()
    {
        // Check if the user has superannuation set.
        if ($this->user->super_fund_name == null) {
            // Superannuation is not required.
            // Return 0.
            return 0;  
        } else {
            // Superannuation is required.
            // Sum of the items, then multiply 0.95, then round.
            $invoice_superannuation = round($this->invoice_items()->sum('cost_total') * \App\Models\System::first()->getDefaultSuperannuationValue());
            // Return the calculated amount.
            return $invoice_superannuation;
        }
    }

    /**
     * Get the formatted invoice total.
     */
    public function getInvoiceTotal()
    {
        // Set the sum of subtotal and tax.
        $invoice_total = round($this->getInvoiceSubtotal() + $this->getInvoiceTax());
        // Return the value.
        return $invoice_total;
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getFormattedInvoiceSubtotal()
    {
        // Set the sum of the items.
        $invoice_subtotal = $this->invoice_items()->sum('cost_total');
        // Return the invoice total.
        return '$' . number_format(($invoice_subtotal) / 100, 2, '.', ',');
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getFormattedInvoiceTax()
    {
        // Check if the user has tax set.
        if ($this->user->has_gst == 0) {
            // GST is not required.
            // Return 0.
            return '$0.00';
        } else {
            // GST is required.
            // Sum of the items, then multiply 0.10, then round.
            $invoice_tax = round($this->invoice_items()->sum('cost_total') * \App\Models\System::first()->getDefaultTaxValue());
            // Return the calculated amount.
            return '$' . number_format(($invoice_tax) / 100, 2, '.', ',');
        }
    }

    /**
     * Get the formatted invoice payg.
     */
    public function getFormattedInvoicePayg()
    {
        // Get PAYG Value.
        // Check if the invoice has a confirmation number.
        if ($this->confirmation_number == null) {
            // The invoice has not been paid.
            return 'Pending';
        } else {
            // The invoice has been paid. 
            // Find the model instance that matches the confirmation number.
            $payg_value = \App\Models\PayAsYouGoTax::where('confirmation_number', $this->confirmation_number)->pluck('amount');
            // Return the formatted value.
            return '$' . number_format(($payg_value) / 100, 2, '.', ',');
        }
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getInvoicePayg()
    {
        // Check if the user has payg set.
        if ($this->user->has_payg == 0) {
            // GST is not required.
            // Return 0.
            return 0;  
        } else {
            // PAYG is required.
            // Find the model instance that matches the confirmation number.
            $payg_value = \App\Models\PayAsYouGoTax::where('confirmation_number', $this->confirmation_number)->first()->amount ?? 0;
            // Return the calculated amount.
            return $payg_value;
        }
    }

    /**
     * Get the formatted invoice subtotal.
     */
    public function getFormattedInvoiceSuperannuation()
    {
        // Check if the user has superannuation set.
        if ($this->user->super_fund_name == null) {
            // Superannuation is not required.
            // Return 0.
            return '$0.00';
        } else {
            // Superannuation is required.
            // Sum of the items, then multiply 0.95, then round.
            $invoice_superannuation = round($this->invoice_items()->sum('cost_total') * \App\Models\System::first()->getDefaultSuperannuationValue());
            // Return the calculated amount.
            return '$' . number_format(($invoice_superannuation) / 100, 2, '.', ',');
        }
    }

    /**
     * Get the formatted invoice total.
     */
    public function getFormattedInvoiceTotal()
    {
        // Set the sum of subtotal and tax.
        // $invoice_total = round($this->getInvoiceSubtotal() + $this->getInvoiceTax() - $this->getInvoicePayg());
        $invoice_total = round($this->getInvoiceSubtotal() + $this->getInvoiceTax());
        // Return the value.
        return '$' . number_format(($invoice_total) / 100, 2, '.', ',');
    }

    /**
     * Get the formatted invoice total.
     */
    public function calculateInvoiceTotals()
    {
        // Set The Required Variables.
        // Selected System.
        $selected_system = \App\Models\System::first();
        // Subtotal.
        $invoice_subtotal = $this->invoice_items()->sum('cost_total');
        // GST.
        if($this->user->has_gst == 0) {
            // No GST
            $invoice_tax = 0;
        } else {
            // Has GST.
            $invoice_tax = $this->invoice_items()->sum('cost_total') * $selected_system->getDefaultTaxValue();
        }
        // Superannuation.
        if($this->user->super_fund_name == null) {
            // No Superannuation
            $invoice_superannuation = 0;
        } else {
            // Has Superannuation.
            $invoice_superannuation = $this->invoice_items()->sum('cost_total') * $selected_system->getDefaultSuperannuationValue();
        }

        // Total.
        $invoice_total = $invoice_subtotal + $invoice_tax;
        // Update.
        $this->update([
            'subtotal' => $invoice_subtotal,
            'tax' => $invoice_tax,
            'superannuation' => $invoice_superannuation,
            'total' => $invoice_total,
        ]);
        // Return true.
        return true;
    }
}
