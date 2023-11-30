<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RateUser;
use App\Models\Quote;
use App\Models\QuoteRate;
use Auth;
use PDF;

class ViewRateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::find($_GET['selected_quote_id']);
        // Selected user.
        $selected_user = Auth::user();
        // Find the quote rate that belongs to the user.
        $selected_quote_rate_ids = QuoteRate::where('quote_id', $selected_quote->id)
            ->where('staff_id', Auth::id())
            ->pluck('rate_id');
        // Find the corresponding rate users for the quote rates.
        $selected_rate_users = RateUser::where('user_id', Auth::id())
            ->whereIn('rate_id', $selected_quote_rate_ids)
            ->get();
        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';
        // Generate PDF.
        $pdf = PDF::loadView('profile.invoices.rates.create', compact('selected_rate_users', 'selected_quote', 'selected_user'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);
        // Set pdf title
        $pdf_title = $selected_quote->quote_identifier . '-rates.pdf';
        // Download as pdf.
        return $pdf->download($pdf_title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        // Find the quote rate that belongs to the user.
        $selected_quote_rate_ids = QuoteRate::where('quote_id', $id)
            ->where('staff_id', Auth::id())
            ->pluck('rate_id');
        $selected_rate_users = RateUser::where('user_id', Auth::id())
            ->whereIn('rate_id', $selected_quote_rate_ids)
            ->get();
        // Set The Required Variables.
        $selected_quote_id = $_GET['selected_quote_id'];
        // Return the show view.
        return view('profile.invoices.rates.show')
            ->with([
                'selected_rate_users' => $selected_rate_users,
                'selected_quote_id' => $selected_quote_id
            ]);
    }
}
