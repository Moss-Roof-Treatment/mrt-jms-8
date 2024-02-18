<?php

namespace App\Http\Controllers\Menu\Email\Generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\EmailAttachment;
use App\Mail\Generic\CreateGenericEmail;
use Illuminate\Support\Facades\Mail;
use Auth;

class EmailController extends Controller
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
        // Return the index view.
        return view('menu.emails.generic.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.emails.generic.create');
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
            'recipient_email' => 'required|email',
            'recipient_name' => 'sometimes|nullable|string|min:3|max:50',
            'subject' => 'required|string|min:10|max:255',
            'message' => 'required|string|min:15|max:2500',
            'comment' => 'sometimes|nullable|string|min:15|max:500'
        ]);

        // Create a new model instance.
        $new_email = Email::create([
            'recipient_name' => $request->recipient_name,
            'recipient_email' => $request->recipient_email,
            'subject' => $request->subject,
            'text' => $request->message,
            'comment' => $request->comment,
            'staff_id' => Auth::id()
        ]);

        // Upload the image.
        // Check for uploaded document.
        if ($request->hasFile('documents')) {
            // Number for attachment title.
            $i = 1;
            // Loop through each uploaded document.
            foreach($request->file('documents') as $document){
                // Set the filename - use pathinfo to remove the extention from the original name.
                $filename = $i++ . '-' . pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $document->extension();
                // Store document.
                $document->storeAs('public/documents/emails', $filename);
                // Create the attachment model instance.
                EmailAttachment::create([
                    'email_id' => $new_email->id,
                    'title' => $filename,
                    'storage_path' => 'storage/documents/emails/' . $filename
                ]);
            }
        }

        // Create the data arrray from the request data.
        $data = [
            'email_id' => $new_email->id,
            'recipient_name' => $request->recipient_name,
            'recipient_email' => $request->recipient_email,
            'subject' => $request->subject,
            'message' => $request->message,
            'sender_name' => ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name),
            'sender_email' => Auth::user()->email,
        ];

        // Send the email.
        Mail::to($data['recipient_email'])
            ->send(new CreateGenericEmail($data));

        // Return a redirect to the show route.
        return redirect()
            ->route('generic-emails.show', $new_email->id)
            ->with('success', 'You have successfully sent the generic email to ' . $new_email->recipient_email . '.');
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
        $selected_email = Email::findOrFail($id);
        // Return the show view.
        return view('menu.emails.generic.show')
            ->with('selected_email', $selected_email);
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
        $selected_email = Email::findOrFail($id);
        // Validate storage item exists.
        if ($selected_email->attachments()->exists()) {
            foreach($selected_email->attachments as $attachment) {
                if ($attachment->storage_path != null) {
                    if (file_exists(public_path($attachment->storage_path))) {
                        unlink(public_path($attachment->storage_path));
                    }
                }
                $attachment->delete();
            }
        }
        // Delete the selected model instance.
        $selected_email->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('generic-emails.index')
            ->with('success', 'You have successfully trashed the selected email.');
    }
}
