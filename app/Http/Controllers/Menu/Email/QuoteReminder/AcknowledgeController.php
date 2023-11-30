<?php

namespace App\Http\Controllers\Menu\Email\QuoteReminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteReminderResponse;

class AcknowledgeController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the required quote reminder response.
        $response = QuoteReminderResponse::where('quote_id', $id)
            ->firstOrFail();
        $response->update([
            'is_acknowledged' => 1
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully acknowledged the selected quote reminder email response.');
    }
}
