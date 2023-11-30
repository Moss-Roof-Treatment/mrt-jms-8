<?php

namespace App\Http\Controllers\Menu\Settings\AccountClass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountClass;
use App\Models\User;

class AccountClassController extends Controller
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
        // Find all of the required model instances.
        $all_account_classes = AccountClass::all();
        // Return the index view.
        return view('menu.settings.accountClasses.index')
            ->with('all_account_classes', $all_account_classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.accountClasses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:60|unique:account_classes,title',
            'description' => 'required|string|min:10|max:255',
        ]);
        // Create the new model instance.
        AccountClass::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return redirect to index route.
        return redirect()
            ->route('account-classes.index')
            ->with('success', 'You have successfully created a new account class.');
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
        $selected_account_class = AccountClass::findOrFail($id);
        // Set The Required Variables.
        $selected_users = User::where('account_class_id', $id)
            ->paginate(20);
        // Return the show view.
        return view('menu.settings.accountClasses.show')
            ->with([
                'selected_account_class' => $selected_account_class,
                'selected_users' => $selected_users
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
        // Find the required model instance.
        $selected_account_class = AccountClass::findOrFail($id);
        // Validate editing status.
        // Check is editable status.
        if ($selected_account_class->is_editable == 0) {
            // Return redirect to the show view and show uneditable warning message.
            return back()
                ->with('warning', 'This account class is not editable.');
        }
        // Return the edit view.
        return view('menu.settings.accountClasses.edit')
            ->with('selected_account_class', $selected_account_class);
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
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:60|unique:account_classes,title,'.$id,
            'description' => 'required|string|min:10|max:255',
        ]);
        // Find the required model instance.
        $selected_account_class = AccountClass::findOrFail($id);
        // Update the selected model instance.
        $selected_account_class->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('account-classes.show', $selected_account_class->id)
            ->with('success', 'You have successfully updated the selected account class.');
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
        $selected_account_class = AccountClass::findOrFail($id);
        // Validate delible status.
        // Check is delible status.
        if ($selected_account_class->is_delible == 0) {

            // Return redirect back with error message.
            return back()
                ->with('warning', 'This account class is not delible.');
        }
        // Validate existance of model relationships.
        // Check for model relationship instances.
        if ($selected_account_class->users()->exists()) {
            // Return redirect back with error message.
            return back()
                ->with('warning', 'This account class is not delible as there are users with this account class.');
        }
        // Delete the selected model instance.
        $selected_account_class->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('account-classes.index')
            ->with('success', 'You have successfully deleted the selected account class.');
    }
}
