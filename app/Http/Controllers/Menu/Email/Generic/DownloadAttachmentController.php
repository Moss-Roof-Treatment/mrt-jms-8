<?php

namespace App\Http\Controllers\Menu\Email\Generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailAttachment;

class DownloadAttachmentController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_attachment = EmailAttachment::findOrFail($id);
        // Check if the storage path is not null.
        if ($selected_attachment->storage_path != null) {
            // Check if the file exist in storage.
            if (!file_exists(public_path($selected_attachment->storage_path))) {
                // The file does not exist in storage.
                // Return a redirect back.
                return back()
                    ->with('danger', 'The selected attachment does not exist on the server. It may have been deleted from the server manually.');
            }
        }
        // Download the selected model instance item from storage.
        return response()->download($selected_attachment->storage_path);
    }
}
