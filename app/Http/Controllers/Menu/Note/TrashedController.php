<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;

class TrashedController extends Controller
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
        $deleted_notes = Note::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
        // Return the index view.
        return view('menu.notes.trashed.index')
            ->with('deleted_notes', $deleted_notes);
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
        $selected_trashed_note = Note::withTrashed()->find($id);
        // Return the show view.
        return view('menu.notes.trashed.show')
            ->with('selected_trashed_note', $selected_trashed_note);
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
        $selected_trashed_note = Note::withTrashed()->find($id);
        // Update the selected model instance.
        $selected_trashed_note->restore();
        // Return a redirect to the index route.
        return redirect()
            ->route('notes-trashed.index')
            ->with('success', 'You have successfully restored the selected job note.');
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
        $selected_trashed_note = Note::withTrashed()->find($id);
        // Delete selected model instance.
        $selected_trashed_note->forceDelete();
        // Return a redirect to the index route.
        return redirect()
            ->route('notes-trashed.index')
            ->with('success', 'You have successfully deleted the selected job note.');
    }
}
