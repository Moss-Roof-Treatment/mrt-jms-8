<?php

namespace App\Http\Controllers\Menu\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class TrashController extends Controller
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
        $trashed_messages = Message::onlyTrashed()
            ->orderBy('id', 'desc')
            ->get();
        // Return the index view.
        return view('menu.messages.trashed.index')
            ->with('trashed_messages', $trashed_messages);
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
        $selected_trashed_message = Message::withTrashed()->find($id);
        // Return the show view.
        return view('menu.messages.trashed.show')
            ->with('selected_trashed_message', $selected_trashed_message);
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
        $selected_trashed_message = Message::withTrashed()->find($id);
        // Restore the selected model instance.
        $selected_trashed_message->restore();
        // Return a redirect to the index route.
        return redirect()
            ->route('messages-trash.index')
            ->with('success', 'You have successfully restored the selected trashed message.');
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
        $selected_trashed_message = Message::withTrashed()->find($id);
        // Delete the selected model instance.
        $selected_trashed_message->forceDelete();
        // Return a redirect to the index route.
        return redirect()
            ->route('messages-trash.index')
            ->with('success', 'You have successfully permenently deleted the selected trashed message.');
    }
}
