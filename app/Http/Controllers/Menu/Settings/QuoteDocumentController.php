<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteDocument;
use App\Models\MaterialType;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class QuoteDocumentController extends Controller
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
        $all_quote_documents = QuoteDocument::paginate(20);
        // Return the index view.
        return view('menu.settings.quoteDocuments.index')
            ->with('all_quote_documents', $all_quote_documents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All Material Types.
        $all_material_types = MaterialType::all('id', 'title');
        // All task types.
        $all_task_types = TaskType::all('id', 'title');
        // All tasks.
        $all_tasks = Task::all('id', 'title');
        // Return the create view.
        return view('menu.settings.quoteDocuments.create')
            ->with([
                'all_material_types' => $all_material_types,
                'all_tasks' => $all_tasks,
                'all_task_types' => $all_task_types
            ]);
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
            'title' => 'required|string|min:4|max:80',
            'description' => 'required|min:10|max:255|string',
            'material_type_id' => 'sometimes|nullable',
            'task_type_id' => 'sometimes|nullable',
            'task_id' => 'sometimes|nullable',
            'document' => 'sometimes|nullable|file|mimes:pdf|max:3072', // 3MB
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Create the new model instance.
        $new_quote_document = QuoteDocument::create([
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'material_type_id' => $request->material_type_id,
            'task_type_id' => $request->task_type_id,
            'task_id' => $request->task_id,
            'is_default' => $request->is_default == 1 ? 1 : 0
        ]);
        // Create the new image.
        if (isset($request->image)) {
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '-document-image' . '.' . $image->getClientOriginalExtension();
            $new_quote_document->image_path = 'storage/documents/quoteDocuments/' . $filename;
            $location = storage_path('app/public/documents/quoteDocuments/' . $filename);
            Image::make($image)->orientate()->save($location);
        }
        // Create the new document.
        if (isset($request->quote_document)) {
            $document = $request->file('quote_document');
            $filename = Str::slug($request->title) . '-document' . '.' . $document->getClientOriginalExtension();
            $new_quote_document->document_path = 'storage/documents/quoteDocuments/' . $filename;
            $request->quote_document->move(storage_path('app/public/documents/quoteDocuments'), $filename);
        }
        // Save the updated model instance.
        $new_quote_document->save();
        // Return a redirect to the index route.
        return redirect()
            ->route('quote-document-settings.show', $new_quote_document->id)
            ->with('success', 'You have successfully created a quote document.');
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
        $selected_quote_document = QuoteDocument::findOrFail($id);
        // Return the show view.
        return view('menu.settings.quoteDocuments.show')
            ->with('selected_quote_document', $selected_quote_document);
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
        $selected_quote_document = QuoteDocument::findOrFail($id);
        // Set The Required Variables.
        // All Material Types.
        $all_material_types = MaterialType::all('id', 'title');
        // All task types.
        $all_task_types = TaskType::all('id', 'title');
        // All tasks.
        $all_tasks = Task::all('id', 'title');
        // Return the edit view.
        return view('menu.settings.quoteDocuments.edit')
            ->with([
                'selected_quote_document' => $selected_quote_document,
                'all_material_types' => $all_material_types,
                'all_tasks' => $all_tasks,
                'all_task_types' => $all_task_types
            ]);
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
            'title' => 'required|string|min:4|max:80',
            'description' => 'required|min:10|max:255|string',
            'material_type_id' => 'sometimes|nullable',
            'task_type_id' => 'sometimes|nullable',
            'task_id' => 'sometimes|nullable',
            'document' => 'sometimes|nullable|file|mimes:pdf|max:3072', // 3MB
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $selected_quote_document = QuoteDocument::findOrFail($id);
        // Update the selected model instance.
        $selected_quote_document->update([
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'material_type_id' => $request->material_type_id,
            'task_type_id' => $request->task_type_id,
            'task_id' => $request->task_id,
            'is_default' => $request->is_default == 1 ? 1 : 0
        ]);
        // Update the image.
        if (isset($request->image)) {
            if ($selected_quote_document->image_path != null) {
                // Check if image file exists.
                if (file_exists(public_path($selected_quote_document->image_path))) {
                    // Delete the file.
                    unlink(public_path($selected_quote_document->image_path));
                }
            }
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '-document-image' . '.' . $image->getClientOriginalExtension();
            $selected_quote_document->image_path = 'storage/documents/quoteDocuments/' . $filename;
            $location = storage_path('app/public/documents/quoteDocuments/' . $filename);
            Image::make($image)->orientate()->save($location);
        }
        // Update the document.
        if (isset($request->quote_document)) {
            if ($selected_quote_document->document_path != null) {
                // Check if image file exists.
                if (file_exists(public_path($selected_quote_document->document_path))) {
                    // Delete the file.
                    unlink(public_path($selected_quote_document->document_path));
                }
            }
            $document = $request->file('quote_document');
            $filename = Str::slug($request->title) . '-document' . '.' . $document->getClientOriginalExtension();
            $selected_quote_document->document_path = 'storage/documents/quoteDocuments/' . $filename;
            $request->quote_document->move(storage_path('app/public/documents/quoteDocuments'), $filename);
        }
        // Save the updated model instance.
        $selected_quote_document->save();
        // Return a redirect to the index route.
        return redirect()
            ->route('quote-document-settings.show', $id)
            ->with('success', 'You have successfully updated the selected quote document.');
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
        $selected_quote_document = QuoteDocument::findOrFail($id);
        // Check if the document path is not null.
        if ($selected_quote_document->document_path != null) {
            // Check if the file exists.
            if (file_exists(public_path($selected_quote_document->document_path))) {
                // Delete the file.
                unlink(public_path($selected_quote_document->document_path));
            }
        }
        // Check if the image path is not null.
        if ($selected_quote_document->image_path != null) {
            // Check if the file exists.
            if (file_exists(public_path($selected_quote_document->image_path))) {
                // Delete the file.
                unlink(public_path($selected_quote_document->image_path));
            }
        }
        // Delete the selected model instance.
        $selected_quote_document->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('quote-document-settings.index')
            ->with('success', 'You have successfully deleted the selected quote document.');
    }
}
