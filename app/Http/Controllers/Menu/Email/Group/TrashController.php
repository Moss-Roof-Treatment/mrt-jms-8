<?php

namespace App\Http\Controllers\Menu\Email\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupEmail;

class TrashController extends Controller
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
        $trashed_emails = GroupEmail::onlyTrashed()->get();
        // Return the index view.
        return view('menu.emails.group.trashed.index')
            ->with('trashed_emails', $trashed_emails);
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
        $selected_trashed_email = GroupEmail::withTrashed()->find($id);
        // Return the show view.
        return view('menu.emails.group.trashed.show')
            ->with('selected_trashed_email', $selected_trashed_email);
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
        $selected_trashed_email = GroupEmail::withTrashed()->find($id);
        // Restore the selected model instance.
        $selected_trashed_email->restore();
        // Return a redirect to the index route.
        return redirect()
            ->route('group-emails-trash.index')
            ->with('success', 'You have successfully restored the selected trashed group email.');
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
        $selected_trashed_email = GroupEmail::withTrashed()->find($id);
        // Delete the selected model instance relationships.
            if ($selected_trashed_email->attachments()->exists()) {
                foreach($selected_trashed_email->attachments as $attachment) {
                    if ($attachment->storage_path != null) {
                        if (file_exists(public_path($attachment->storage_path))) {
                            unlink(public_path($attachment->storage_path));
                        }
                    }
                    $attachment->delete();
                }
            }
        // Delete the selected model instance.
        $selected_trashed_email->forceDelete();
        // Return a redirect to the index route.
        return redirect()
            ->route('group-emails-trash.index')
            ->with('success', 'You have successfully permenently deleted the selected trashed group email.');
    }
}
