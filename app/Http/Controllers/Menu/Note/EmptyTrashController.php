<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;

class EmptyTrashController extends Controller
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
        // Set variables and continue if not null or redirect back if null.
        $deleted_job_notes = Note::onlyTrashed()->get();
        // Check if there are any notes to delete.
        if (!$deleted_job_notes->count()) {
            // Thre are no notes to delete.
            // Return a redirect back.
            return back()
                ->with('warning', 'There are no trashed notes to be permanently deleted.');
        }
        // Delete job notes.
        // Loop through each selected note.
        foreach($deleted_job_notes as $deleted_job_note) {
            // Force delete the selected note.
            $deleted_job_note->forceDelete();
        }
        // Return a redirect to the trashed notes index route.
        return redirect()
            ->route('notes-trashed.index')
            ->with('success', 'You have successfully permanently deleted all trashed notes.');
    }
}
