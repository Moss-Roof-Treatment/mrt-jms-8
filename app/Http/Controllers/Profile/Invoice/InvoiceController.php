<?php

namespace App\Http\Controllers\Profile\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Auth;

class InvoiceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Remove the required session variables.
        // Pull old session variable.
        if (session()->has('selected_invoice_id')) {
            session()->pull('selected_invoice_id');
        }
        // Return the index view.
        return view('profile.invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Authenticated user.
        $selected_tradesperson = User::find(Auth::id());
        // Previous invoice count.
        $previous_invoice_count = Invoice::where('user_id', $selected_tradesperson->id)
            ->count();
        // Create the new model instance.
        // Set the required variables for generating the invoice identifier.
        // Uppercase of first letter of first name.
        $first_name_letter = strtoupper(substr($selected_tradesperson->first_name, 0, 1));
        // Uppercase of first letter of first name.
        $last_name_letter = strtoupper(substr($selected_tradesperson->last_name, 0, 1));
        // First letter of the account role type.
        $account_role_letter = strtoupper(substr($selected_tradesperson->account_role->title, 0, 1));
        // Create new invoice.
        $new_invoice = Invoice::create([
            'user_id' => $selected_tradesperson->id,
            'identifier' => $first_name_letter . $last_name_letter . $account_role_letter . ++$previous_invoice_count
        ]);
        // Create new first invoice item.
        InvoiceItem::create([
            'invoice_id' => $new_invoice->id
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('profile-invoices.show', $new_invoice->id);
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
        $selected_outstanding_invoice = Invoice::findOrFail($id);
        // Update the required session variables.
        // Pull old session variable.
        if (session()->has('selected_invoice_id')) {
            session()->pull('selected_invoice_id');
        }
        // Set new session variable.
        session([
            'selected_invoice_id' => $id,
        ]);
        // Return the show view.
        return view('profile.invoices.show')
            ->with('selected_outstanding_invoice', $selected_outstanding_invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_invoice = Invoice::findOrFail($id);
        // Soft delete the selected model instance.
        $selected_invoice->invoice_items()->delete();
        $selected_invoice->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('profile-invoices.index')
            ->with('success', 'You have successfully deleted the selected invoice.');
    }
}
