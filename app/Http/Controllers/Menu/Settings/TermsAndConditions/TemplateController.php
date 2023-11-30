<?php

namespace App\Http\Controllers\Menu\Settings\TermsAndConditions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsHeading;
use App\Models\TermsSubHeading;
use App\Models\TermsItem;
use App\Models\TermsSubItem;
use PDF;

class TemplateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isStaff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set The Required Variables.
        // Get all terms and conditions headings.
        $all_headings = TermsHeading::all();
        // Get all terms and conditions sub headings.
        $all_sub_headings = TermsSubHeading::all();
        // Get all terms and conditions items.
        $all_items = TermsItem::all();
        // Get all terms and conditions sub items.
        $all_sub_items = TermsSubItem::all();

        // Return the index view.
        return view('menu.settings.termsAndConditions.template.index')
            ->with([
                'all_headings' => $all_headings,
                'all_sub_headings' => $all_sub_headings,
                'all_items' => $all_items,
                'all_sub_items' => $all_sub_items,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Get all terms and conditions headings.
        $all_headings = TermsHeading::all();
        // Get all terms and conditions sub headings.
        $all_sub_headings = TermsSubHeading::all();
        // Get all terms and conditions items.
        $all_items = TermsItem::all();
        // Get all terms and conditions sub items.
        $all_sub_items = TermsSubItem::all();
        // Generate PDF.
        $pdf = PDF::loadView('menu.settings.termsAndConditions.template.create', compact('all_headings', 'all_sub_headings', 'all_items', 'all_sub_items'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait');
        // Make title variable.
        $pdf_title = 'MRT-Terms-and-Conditions';
        // Download as pdf.
        return $pdf->download($pdf_title);
    }
}
