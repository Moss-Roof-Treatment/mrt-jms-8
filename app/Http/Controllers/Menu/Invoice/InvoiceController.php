<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountRole;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Auth;
use Carbon\Carbon;

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
        $all_invoices = Invoice::where('paid_date', null) // Outstanding.
            ->select('id', 'identifier', 'submission_date', 'quote_id', 'user_id')
            ->with(['quote' => fn ($q) => $q->select('id')])
            ->with(['quote.customer' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->with(['user' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->get();
        // Return the index view.
        return view('menu.invoices.outstanding.index')
            ->with('all_invoices', $all_invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Set the authenticated user.
        $selected_user = User::findOrFail(Auth::id());
        // Set auth user invoice count.
        $previous_invoice_count = Invoice::where('user_id', $selected_user->id)
            ->count();
        // Set the required variables for generating the invoice identifier.
        // Uppercase of first letter of first name.
        $first_name_letter = strtoupper(substr($selected_user->first_name, 0, 1));
        // Uppercase of first letter of first name.
        $last_name_letter = strtoupper(substr($selected_user->last_name, 0, 1));
        // First letter of the account role type.
        $account_role_letter = strtoupper(substr($selected_user->account_role->title, 0, 1));
        // Create new invoice.
        $new_invoice = Invoice::create([
            'user_id' => $selected_user->id,
            'identifier' => $first_name_letter . $last_name_letter . $account_role_letter . ++$previous_invoice_count
        ]);
        // Create new first invoice item.
        $new_invoice_item = InvoiceItem::create([
            'invoice_id' => $new_invoice->id
        ]);
        // Return the index view.
        return redirect()
            ->route('invoices-outstanding.show', $new_invoice->id)
            ->with('success', 'You have successfully created a new invoice.');
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
        $selected_invoice = Invoice::findOrFail($id);
        // Secondary validation.
        if (Auth::user()->account_role_id == 2 && $selected_invoice->user_id != Auth::id()) { // Check if the account staff and the user belonging to the invoice.
            // The auth user is a staff memeber and invoice does not belong to them.
            // Return a redirect back.
            return back()
                ->with('danger', 'You do not have the correct permissions to access this invoice.');
        }
        // ALL INVOICES.
        // Find all pending invoices that belong to the selected invoice user.
        $all_pending_invoices = Invoice::where('user_id', $selected_invoice->user_id)
            ->where('submission_date', '!=', null)
            ->where('paid_date', null)
            ->get();
        // All account roles.
        $all_account_roles = AccountRole::all();
        // Return the index view.
        return view('menu.invoices.outstanding.show')
            ->with([
                'all_pending_invoices' => $all_pending_invoices,
                'selected_invoice' => $selected_invoice,
                'all_account_roles' => $all_account_roles
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // *********** I think this is wrong and needs to be deleted??????
        dd('InvoiceController Edit Route');

        // Find the required model instance.
        $selected_invoice = Invoice::findOrFail($id);
        // Update the selected model instance.
        $selected_invoice->update([
            'finalised_date' => $selected_invoice->finalised_date != null ? null : now()
        ]);
        // Update the selected model instance.
        return back()
            ->with('succes', 'You have successfully updated the editing status of the selected invoice.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the required model instance.
        $selected_invoice = Invoice::findOrFail($id);
        // Update the selected model instance.
        $selected_invoice->update([
            'finalised_date' => $selected_invoice->finalised_date != null ? null : Carbon::now()
        ]);
        // Return the redirect back.
        return back()
            ->with('succes', 'You have successfully updated the editing status of the selected invoice.');
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
        // Delete the required relationship model instances.
        foreach($selected_invoice->invoice_items as $item) {
            $item->delete();
        }
        // Delete the selected model instance.
        $selected_invoice->delete();
        // Return a redirect to the index view.
        return redirect()
            ->route('invoices-outstanding.index')
            ->with('success', 'You have successfully deleted the selected invoice.');
    }
}
