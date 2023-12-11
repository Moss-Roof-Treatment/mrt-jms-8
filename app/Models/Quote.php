<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'customer_id',
        'job_type_id',
        'quote_status_id',
        'expected_payment_method_id',
        'quote_identifier',
        'profit_margin',
        'discount',
        'contracted_total',
        'mpa_coverage',
        'additional_comments',
        'tax_invoice_discount',
        'tax_invoice_note',
        'customer_view_count',
        'description',
        'is_editable',
        'is_delible',
        'is_sendable',
        'deposit_emailed',
        'deposit_posted',
        'tax_invoice_emailed',
        'tax_invoice_posted',
        'final_receipt_emailed',
        'final_receipt_posted',
        'finalised_date',
        'original_finalised_date',
        'deposit_accepted_date',
        'remaining_balance_accepted_date',
        'tax_invoice_date',
        'final_receipt_date',
        'completion_date',
        'allow_early_receipt',
        'allow_accept_card_payment',
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
        'deposit_accepted_date',
        'remaining_balance_accepted_date',
        'tax_invoice_date',
        'final_receipt_date',
        'completion_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get the job associated with the quote.
     */
    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    /**
     * Get the job type associated with the quote.
     */
    public function job_type()
    {
        return $this->belongsTo('App\Models\JobType');
    }

    /**
     * Get the quote status associated with the quote.
     */
    public function customer() 
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function job_status()
    {
        return $this->belongsTo('App\Models\JobStatus');
    }

    /**
     * Get the job image quote associated with the quote.
     */
    public function job_image_quotes()
    {
        return $this->belongsToMany('App\Models\JobImageQuote', 'job_image_quote', 'quote_id', 'job_image_id');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function quote_status()
    {
        return $this->belongsTo('App\Models\QuoteStatus');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function expected_payment_method()
    {
        return $this->belongsTo('App\Models\ExpectedPaymentMethod');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function quote_tasks()
    {
        return $this->hasMany('App\Models\QuoteTask');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function quote_rates()
    {
        return $this->hasMany('App\Models\QuoteRate');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function quote_products()
    {
        return $this->hasMany('App\Models\QuoteProduct');
    }

    /**
     * Get the payments associated with the quote.
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * Get the tradespersons associated with the quote.
     */
    public function quote_users()
    {
        return $this->hasMany('App\Models\QuoteUser');
    }

    /**
     * Get the invoices associated with the quote.
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    /**
     * Get the quote documents associated with the quote.
     */
    public function quote_documents()
    {
        return $this->belongsToMany('App\Models\QuoteDocument');
    }

    /**
     * Get the survey associated with the quote.
     */
    public function survey()
    {
        return $this->hasOne('App\Models\Survey');
    }

    /**
     * Get the quote task associated with the quote.
     */
    public function quote_tax_invoice_items()
    {
        return $this->hasMany('App\Models\QuoteTaxInvoiceItem');
    }

    /**
     * Get the payments associated with the quote.
     */
    public function scheduled_payments()
    {
        return $this->hasMany('App\Models\ScheduledPayment');
    }

    /**
     * Get the sent quote reminder associated with the quote.
     */
    public function sent_quote_reminders()
    {
        return $this->hasMany('App\Models\SentQuoteReminder');
    }

    /**
     * Get the sent quote reminder associated with the quote.
     */
    public function quote_reminder_response()
    {
        return $this->hasOne('App\Models\QuoteReminderResponse');
    }

    /**
     * Get the salespersons associated with the job.
     */
    public function commissions()
    {
        return $this->hasMany('App\Models\QuoteCommission');
    }

    /**
     * Get the salespersons associated with the job.
     */
    public function event()
    {
        return $this->hasOne('App\Models\Event');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Functions
    |--------------------------------------------------------------------------
    */

    // QUOTE PAGE

    /**
     * Calculate quote task totals.
     */
    public function getFormattedTotalTasksCost()
    {
        // Sum the value of all quote tasks or set to 0.
        $value = round($this->quote_tasks()?->sum('total_price')) ?? 0;
        // Number format the value and add the dollar sign.
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Calculate quote rate totals.
     */
    public function getFormattedTotalRatesCost()
    {
        // Sum the value of all quote rates or set to 0.
        $value = round($this->quote_rates()?->sum('total_price')) ?? 0;
        // Sum the total of all quote tasks.
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Calculate quote products totals.
     */
    public function getFormattedTotalProductsCost()
    {
        // Sum the value of all quote products or set to 0.
        $value = round($this->quote_products()?->sum('total_price')) ?? 0;
        // Sum the total of all quote tasks.
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted profit margin.
     */
    public function getFormattedProfitMargin()
    {
        // Return the formatted profit margin.
        return '$' . number_format(($this->profit_margin / 100), 2, '.', ',');
    }

    /**
     * Get the formatted tax invoice discount.
     */
    public function getFormattedDiscount()
    {
        // Return the formatted profit margin.
        return '$' . number_format(($this->discount / 100), 2, '.', ',');
    }

    /**
     * Get the tax invoice items total.
     */
    public function getTaxInvoiceItemsTotal()
    {
        return $this->quote_tax_invoice_items()?->sum('total_price') ?? 0;
    }

    /**
     * Get the quote subtotal without gst.
     */
    public function getSubtotalWithoutGst()
    {
        // Sum the value of all quote tasks or set to 0.
        $task_value = $this->quote_tasks()?->sum('total_price') ?? 0;
        // Sum the value of all quote rates or set to 0.
        $rate_value = $this->quote_rates()?->sum('total_price') ?? 0;
        // Sum the value of all quote products or set to 0.
        $product_value = $this->quote_products()?->sum('total_price') ?? 0;
        // Round the total of all required items.
        return round($task_value + $rate_value + $product_value + $this->profit_margin - $this->discount);
    }

    /**
     * Get the quote subtotal without gst.
     */
    public function getFormattedSubtotalWithoutGst()
    {
        // Sum the value of all quote tasks or set to 0.
        $task_value = $this->quote_tasks()?->sum('total_price') ?? 0;
        // Sum the value of all quote rates or set to 0.
        $rate_value = $this->quote_rates()?->sum('total_price') ?? 0;
        // Sum the value of all quote products or set to 0.
        $product_value = $this->quote_products()?->sum('total_price') ?? 0;
        // Round the total of all required items.
        $value = round($task_value + $rate_value + $product_value + $this->profit_margin - $this->discount);
        // Return the formatted value.
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the gst of the subtotal.
     */
    public function getSubtotalGst()
    {
        return round($this->getsubtotalWithoutGst() * \App\Models\System::first()->getDefaultTaxValue());
    }

    /**
     * Get the gst of the subtotal.
     */
    public function getFormattedSubtotalGst()
    {
        return '$' . number_format(($this->getSubtotalGst() / 100), 2, '.', ',');
    }

    /**
     * Get the quote total including gst.
     */
    public function getQuoteTotal()
    {
        return round($this->getSubtotalWithoutGst() + $this->getSubtotalGst());
    }

    /**
     * Get the formatted quote total including gst.
     */
    public function getFormattedQuoteTotal()
    {
        return '$' . number_format(($this->getQuoteTotal() / 100), 2, '.', ',');
    }

    /**
     * Get the formatted opening balance.
     */
    public function getFormattedOpeningBalance()
    {
        $value = $this->getSubtotalWithoutGst() + $this->getSubtotalGst();
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the deposit total including gst.
     */
    public function getDepositTotal()
    {
        return $this->getQuoteTotal() * 0.25;
    }

    /**
     * Get the formatted deposit total including gst.
     */
    public function getFormattedDepositTotal()
    {
        $value = $this->getQuoteTotal() * 0.25;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted remaining balance on completion after paid deposit.
     */
    public function getDepositBalanceOnCompletion()
    {
        return $this->getQuoteTotal() * 0.75;
    }

    /**
     * Get the formatted remaining balance on completion after paid deposit.
     */
    public function getFormattedDepositBalanceOnCompletion()
    {
        $value = $this->getQuoteTotal() * 0.75;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted payments total.
     */
    public function getFormattedPaymentsTotal()
    {
        $value = $this->payments()?->where('void_date', null)->sum('payment_amount') ?? 0;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted remaining balance.
     */
    public function getFormattedRemainingBalance()
    {
        $payments_value = $this->payments()?->where('void_date', null)->sum('payment_amount') ?? 0;
        $value = $this->getQuoteTotal() - $payments_value - $this->tax_invoice_discount + $this->getTaxInvoiceItemsTotal();
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted remaining balance.
     */
    public function getTaxInvoiceOpeningBalance()
    {
        $deposit_paid_value = $this->payments()?->where('void_date', null)->where('payment_type_id', 1)->sum('payment_amount') ?? 0;
        $value = $this->getQuoteTotal() - $deposit_paid_value - $this->tax_invoice_discount + $this->getTaxInvoiceItemsTotal();
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    // DEPOSIT RECEIPT

    /**
     * Get the formatted deposit amount paid at deposit receipt stage.
     */
    public function getFormattedDepositPaidTotal()
    {
        $value = $this->payments()?->where('void_date', null)->where('payment_type_id', 1)->sum('payment_amount') ?? 0;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted remaining balance at deposit receipt stage.
     */
    public function getFormattedRemainingBalanceDeposit()
    {
        $deposit_paid_value = $this->payments()?->where('void_date', null)->where('payment_type_id', 1)->sum('payment_amount') ?? 0;
        $value = $this->getQuoteTotal() - $deposit_paid_value;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted deposit amount paid gst.
     */
    public function getFormattedDepositPaidGst()
    {
        $deposit_value = $this->payments()?->where('void_date', null)->where('payment_type_id', 1)->sum('payment_amount') ?? 0;
        $value = $deposit_value / 11;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    // TAX INVOICE

    /**
     * Get the formatted remaining balance at tax invoice stage.
     */
    public function getFormattedRemainingBalanceTaxInvoice()
    {
        $deposit_paid_value = $this->payments()?->where('void_date', null)->where('payment_type_id', 1)->sum('payment_amount') ?? 0;
        $value = $this->getQuoteTotal() - $deposit_paid_value - $this->tax_invoice_discount + $this->getTaxInvoiceItemsTotal();
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the formatted remaing balance gst at the time of the tax invoice GST amount.
     */
    public function getFormattedRemainingBalanceTaxInvoiceGst()
    {
        $deposit_paid_value = $this->payments()?->where('void_date', null)->where('payment_type_id', 1)->sum('payment_amount') ?? 0;
        $total_value = $this->getQuoteTotal() - $deposit_paid_value - $this->tax_invoice_discount + $this->getTaxInvoiceItemsTotal();
        $value = $total_value / 11;
        return '$' . number_format(($value / 100), 2, '.', ',');
    }

    // FINAL RECEIPT

    /**
     * Get the formatted remaing balance gst at the time of the tax invoice GST amount.
     */
    public function getFormattedPaymentsCreditsFinalReceipt()
    {
        $deposit_paid_value = $this->payments()?->where('void_date', null)->sum('payment_amount') ?? 0;
        $value = $deposit_paid_value + $this->tax_invoice_discount + $this->getTaxInvoiceItemsTotal();
        return '- $' . number_format(($value / 100), 2, '.', ',');
    }

    /**
     * Get the current remaining balance.
     */
    public function getRemainingBalance()
    {
        $payments_value = $this->payments()?->where('void_date', null)->sum('payment_amount') ?? 0;
        $value = $this->getQuoteTotal() - $payments_value - $this->tax_invoice_discount + $this->getTaxInvoiceItemsTotal();
        return $value;
    }

    // OTHER FUNCTIONS

    /**
     * Get the deposit payment surcharges.
     */
    public function getQuoteDepositPaymentsSurcharge()
    {
        // Get all deposit payment type model instances regardless of void status. 
        $all_deposit_payments = $this->payments()
            ?->where('payment_type_id', 1) // Deposit.
            ->where('has_processing_fee', 1) // Does have a processing fee.
            ->where('void_date', null) // Not voided.
            ->get();
        // Multiply the amount of deposit payments by 30 cents. 
        $count_of_fixed_surcharges = $all_deposit_payments->count() * 0.30;
        // Multiply the sum of all deposit payments by 1.75%.
        $value = $all_deposit_payments->sum('payment_amount') * 0.0175;
        // Check if the value is 0.
        if ($value == 0) {
            // Return 0.
            return 0;
        } else {
            // Return the number format.
            return '$' . number_format(($value / 100 + $count_of_fixed_surcharges), 2, '.', ',');
        }
    }

    /**
     * Get all deposit payment type model instances.
     */
    public function getQuoteDepositPaymentsModels()
    {
        // Get all deposit payment type model instances regardless of void status. 
        return $this->payments()?->where('payment_type_id', 1)->get();
    }

    /**
     * Get the deposit payment surcharges.
     */
    public function getQuotePaymentsSurcharge()
    {
        // Get all deposit payment type model instances regardless of void status. 
        $all_quote_payments = $this->payments()
            ?->where('has_processing_fee', 1) // Does have a processing fee.
            ->where('void_date', null) // Not voided.
            ->get();
        // Multiply the amount of deposit payments by 30 cents. 
        $count_of_fixed_surcharges = $all_quote_payments->count() * 0.30;
        // Multiply the sum of all deposit payments by 1.75%.
        $value = $all_quote_payments->sum('payment_amount') * 0.0175;
        // Check if the value is 0.
        if ($value == 0) {
            // Return 0.
            return 0;
        } else {
            // Return the number format.
            return '$' . number_format(($value / 100 + $count_of_fixed_surcharges), 2, '.', ',');
        }
    }

    /**
     * Get all normal payment type model instances.
     */
    public function getQuotePaymentsModels()
    {
        // Get all normal payment type model instances regardless of void status. 
        return $this->payments()?->where('payment_type_id', 2)->get();
    }

    // 
    // FORMATTED QUOTE SPECIFIC FUNCTIONS
    //

    /**
     * Get the formatted tax invoice discount.
     */
    public function getTaxInvoiceDiscount()
    {
        return number_format(($this->tax_invoice_discount / 100), 2, '.', ',');
    }

    // 
    // PRODUCT QUANTITIES FUNCTIONS
    //

    /**
     * Get the formatted quote total.
     */
    public function getTotalProductArea()
    {
        return round($this->quote_tasks()->whereRelation('task', 'uses_product', 1)
        ->sum('total_quantity')) . "&#13217;";
    }

    /**
     * Get the formatted quote total.
     */
    public function getTotalMixedProduct()
    {
        return round($this->quote_tasks()->whereRelation('task', 'uses_product', 1)
        ->sum('total_quantity') * $this->mpa_coverage) . "L";
    }

    /**
     * Get the formatted quote total.
     */
    public function getTotalRequiredProduct()
    {
        return number_format(($this->quote_tasks()->whereRelation('task', 'uses_product', 1)
        ->sum('total_quantity') * $this->mpa_coverage / 15), 1, '.', ',') . "L";
    }

    /**
     * Get the formatted quote total.
     */
    public function getTotalRequiredBottles()
    {
        return number_format(($this->quote_tasks()->whereRelation('task', 'uses_product', 1)
        ->sum('total_quantity') * $this->mpa_coverage / 15 / 15), 1, '.', ',') . " x 15L Bottles";
    }

    /**
     * Get the formatted quote total.
     */
    public function updateQuoteProductTradespersonMaterials()
    {
        // Check if the default Moss Treatment Fluid Quote Product Exists, if not create it.
        // Find quote product.
        $selected_quote_product = $this->quote_products->where('product_id', 5)->first();
        // Check if no quote product was found.
        if ($selected_quote_product == null) {
            // Create the new quote product.
            $selected_quote_product = $this->quote_products()->create([
                'quote_id' => $this->id,
                'product_id' => 5,
            ]);
        }
        // Set the quantity of bottles required
        $required_quantity = number_format(($this->quote_tasks()->whereRelation('task', 'uses_product', 1)
        ->sum('total_quantity') * $this->mpa_coverage / 15 / 15), 1, '.', ',');
        // Set the individual price.
        $product_price = $selected_quote_product->product->price;
        // Update the selected quote product.
        $selected_quote_product->update([
            'quantity' => $required_quantity,
            'individual_price' => $product_price,
            'total_price' => $required_quantity * $product_price,
        ]);
        // Return true.
        return true;
    }

    /**
     * Create the initial commission item.
     */
    public function createQuoteCommission()
    {
        // Check if the job salesperson has commissions turned on.
        if ($this->job->salesperson->has_commissions == 1) {
            // create a new commission object for the salesperson else do nothing.
            $this->commissions()->create([
                'quote_id' => $this->id,
                'salesperson_id' => $this->job->salesperson_id,
            ]);
        }
        // Return true.
        return true;
    }

    /**
     * Create the initial commission item.
     */
    public function updateAllQuoteCommissions()
    {
        // Get the count of all quote commissions.
        $count = $this->commissions()->count();
        // Validation.
        if ($count == 0) {
            return true;
        }
        // Get the current system percent.
        $current_commission_percentage = \App\Models\System::first()->getDefaultCommissionValue();
        // Get the quote total.
        $quote_total = $this->getQuoteTotal();
        // Total commission.
        $total_commission = $quote_total * $current_commission_percentage;
        // Individual commission.
        $individual_commission = $total_commission / $count;
        // Individual commission percent.
        $individual_commission_percent = $current_commission_percentage / $count;
        // Get all of the quote commissions.
        $all_commissions = $this->commissions()->get();
        // Update all of the commissions.
        foreach($all_commissions as $commission) {
            $commission->update([
                'quote_total' => $quote_total,
                'total_percent' => $current_commission_percentage,
                'individual_percent_value' => $individual_commission_percent,
            ]);
        }
        // Return true.
        return true;
    }

    // 
    // Garbage Collection.
    //

    /**
     * Delete all of the redundant items from database.
     */
    public function garbageCollection()
    {
        // Check if there are any sent quote reminder email relationships to delete.
        if ($this->sent_quote_reminders()->count()) {
            // Delete all of the required sent quote reminders.
            $this->sent_quote_reminders()->delete();
        }
        // Check if there are any quote reminder response relationships to delete.
        if ($this->quote_reminder_response()->count()) {
            // Delete all of the required quote reminder responses.
            $this->quote_reminder_response()->delete();
        }
        // Return true.
        return true;
    }
}
