<?php

namespace App\Http\Controllers\Menu\Email\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupEmailAttachment;

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
        $selected_attachment = GroupEmailAttachment::findOrFail($id);
        // Download the selected model instance item from storage.
        return response()->download($selected_attachment->storage_path);
    }
}
