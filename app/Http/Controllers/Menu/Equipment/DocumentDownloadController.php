<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipmentDocument;

class DocumentDownloadController extends Controller
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
        $selected_document = EquipmentDocument::findOrFail($id);
        // Check if the document path is null.
        if ($selected_document->document_path == null) {
            // Catch for dummy data.
            return back()
                ->with('danger', 'The selected document does not exist on the server.');
        }
        // Check if the document path is not null.
        if ($selected_document->document_path != null) {
            // Check if the document exists on the server.
            if (!file_exists(public_path($selected_document->document_path))) {
                // File does not exist so perform redirect back.
                return back()
                    ->with('danger', 'The selected document does not exist on the server. It may have been deleted from the server manually.');
            }
        }
        // Return the asset from storage.
        return response()->download($selected_document->document_path);
    }
}
