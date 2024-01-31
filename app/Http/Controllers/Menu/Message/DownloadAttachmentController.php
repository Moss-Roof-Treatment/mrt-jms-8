<?php

namespace App\Http\Controllers\Menu\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MessageAttachment;

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
        $this->middleware('isAnyStaffMember');
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
        $selected_attachment = MessageAttachment::findOrFail($id);
        // Validate storage item exists.
        if ($selected_attachment->storage_path != null) {
            // Check thta the file exists on the server.
            if (!file_exists(public_path($selected_attachment->storage_path))) {
                // File does not exist so perform redirect back.
                return back()
                    ->with('danger', 'The selected document does not exist on the server. It may have been deleted from the server manually.');
            }
        } elseif ($selected_attachment->storage_path == null) {
            // The storage path is null.
            // Return a redirect back.
            return back()
                ->with('danger', 'The selected document does not exist on the server.');
        }
        // Return the asset from storage.
        return Storage::download(str_replace('storage', 'public', $selected_attachment->storage_path), $selected_attachment->title);
    }
}
