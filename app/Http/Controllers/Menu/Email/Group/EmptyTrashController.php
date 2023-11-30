<?php

namespace App\Http\Controllers\Menu\Email\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupEmail;

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
        // Find the required model instance.
        $all_trashed_emails = GroupEmail::onlyTrashed()->get();
        // Secondary validation.
        if (!$all_trashed_emails->count()) {
            // Return a redirect back.
            return back()
                ->with('warning', 'There are no trashed group emails to be permanently deleted.');
        }
        // Delete the selected model instance.
        foreach($all_trashed_emails as $trashed_email) {
            if ($trashed_email->attachments()->exists()) {
                foreach($trashed_email->attachments as $attachment) {
                    if ($attachment->storage_path != null) {
                        if (file_exists(public_path($attachment->storage_path))) {
                            unlink(public_path($attachment->storage_path));
                        }
                    }
                    $attachment->delete();
                }
            }
            $trashed_email->forceDelete();
        }
        // Return a redirect to the index route.
        return redirect()
            ->route('group-emails-trash.index')
            ->with('success', 'You have successfully permenently deleted all trashed group email.');
    }
}
