<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoKeyword;

class SeoKeywordController extends Controller
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
        $all_keywords = SeoKeyword::all();
        // Return the index view.
        return view('menu.settings.seoKeywords.index')
            ->with('all_keywords', $all_keywords);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the index view.
        return view('menu.settings.seoKeywords.create');
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
            'keyword' => 'required|string|min:3|max:50|unique:seo_keywords',
        ]);
        // Create the new model instance.
        SeoKeyword::create([
            'keyword' => $request->keyword
        ]);
        // Return a redirect to the index view.
        return redirect()
            ->route('seo-keywords-settings.index')
            ->with('success', 'You have successfully created a new SEO keyword.');
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
        $selected_keyword = SeoKeyword::findOrFail($id);
        // Return the index view.
        return view('menu.settings.seoKeywords.edit')
            ->with('selected_keyword', $selected_keyword);
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
            'keyword' => 'required|string|min:3|max:50|unique:seo_keywords',
        ]);
        // Find the required model instance.
        $selected_keyword = SeoKeyword::findOrFail($id);
        // Update the selected model instance.
        $selected_keyword->update([
            'keyword' => $request->keyword
        ]);
        // Return a redirect to the index view.
        return redirect()
            ->route('seo-keywords-settings.index')
            ->with('success', 'You have successfully updated the selected SEO keyword.');
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
        $selected_keyword = SeoKeyword::findOrFail($id);
        // Delete the selected model instance.
        $selected_keyword->delete();
        // Return a redirect to the index view.
        return redirect()
            ->route('seo-keywords-settings.index')
            ->with('success', 'You have successfully deleted the selected SEO keyword.');
    }
}
