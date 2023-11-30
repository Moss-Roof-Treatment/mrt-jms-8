<?php

namespace App\Http\Controllers\Menu\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

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
        // Find the required model instances.
        $all_trashed_messages = Message::onlyTrashed()->get();
        // Secondary validation.
        if (!$all_trashed_messages->count()) {
            // Return redirect back.
            return back()
                ->with('warning', 'There are no trashed messages to be permanently deleted.');
        }
        // Delete the selected model instancs.
        // Loop through each model instance.
        foreach($all_trashed_messages as $trashed_message) {
            // Force delete the selected model instance.
            $trashed_message->forceDelete();
        }
        // Return a redirect to the index route.
        return redirect()
            ->route('messages-trash.index')
            ->with('success', 'You have successfully permenently deleted all trashed messages.');
    }
}
