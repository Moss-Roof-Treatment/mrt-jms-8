<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UpdatePasswordController extends Controller
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
        // Validate The Request Data.
        $request->validate([
            'password' => 'required|string|min:8|required_with:password_confirmation|confirmed',
        ]);
        // Find the required model instance.
        $selected_user = User::findOrFail($id);
        $selected_user->password = bcrypt($request->password);
        $selected_user->save();
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected users password.');
    }
}
