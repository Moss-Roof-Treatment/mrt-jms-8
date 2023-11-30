<?php

namespace App\Http\Controllers\Profile\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class DeleteAllController extends Controller
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // This may not need to exist ?????????????

        // Find the required model instance.
        $user = User::findOrFail($id);
        // Find all messages that belong to the selected user.
        $selected_messages = Message::where('sender_id', $id);
        // Loop through each message.
        foreach($selected_messages as $selected_message) {
            $selected_message->update([
                'sender_is_visible' => 0
            ]);
        }
        // Return a redirect to the 
        return redirect()
            ->route('profile-messages-sent.index')
            ->with('success', 'You have successfully deleted all sent messages.');
    }
}
