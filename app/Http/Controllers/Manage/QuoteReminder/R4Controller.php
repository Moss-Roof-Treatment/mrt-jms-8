<?php

namespace App\Http\Controllers\Manage\QuoteReminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class R4Controller extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set the url.
        $url = 'https://mossrooftreatment.com.au/emails/quote-reminder-emails-r4' . $id;
        // Return the redirect away.
        return redirect()->away($url);
    }
}
