<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use App\Models\SeoKeyword;
use App\Models\SeoTag;
use Illuminate\Http\Request;

class SeoTagController extends Controller
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
        // Find the required model instance.
        $seo_tags = SeoTag::first();
        // Get all keywords.
        $all_keywords = SeoKeyword::all();
        // Return the index view.
        return view('menu.settings.seoTags.index')
            ->with([
                'all_keywords' => $all_keywords,
                'seo_tags' => $seo_tags
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
            'description' => 'required|string|min:3|max:255',
        ]);
        // Find the required model instance.
        $selected_keyword = SeoTag::findOrFail($id);
        // Update the selected model instance.
        $selected_keyword->update([
            'description' => $request->description
        ]);
        // Return a redirect to the index view.
        return redirect()
            ->route('seo-tags-settings.index')
            ->with('success', 'You have successfully updated the SEO tags.');
    }
}
