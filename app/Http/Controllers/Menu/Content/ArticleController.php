<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Models\ArticleTag;
use Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
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
        $articles = Article::where('type', 1) // 1 = Article.
            ->get();
        // Return the index view.
        return view('menu.content.articles.index')
            ->with('articles', $articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Get all article categories.
        $all_categories = ArticleCategory::select(['id', 'title'])
            ->orderBy('title', 'asc')
            ->get();
        // Get all article tags.
        $all_tags = ArticleTag::select(['id', 'title'])
            ->orderBy('title', 'asc')
            ->get();
        // Return the create view.
        return view('menu.content.articles.create')
            ->with([
                'all_categories' => $all_categories,
                'all_tags' => $all_tags
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
            'title' => 'required|min:5|max:255|unique:articles,title',
            'subtitle' => 'required|min:5|max:255',
            'text' => 'required|min:20|max:3000',
            'category_id' => 'required',
            'tags' => 'required',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'location' => 'required|min:3|max:100',
            'completed_date' => 'required',
            'published_date' => 'required',
        ]);
        // Create the new model instance.
        $new_article = Article::create([
            'staff_id' => Auth::id(),
            'type' => 1, // Article
            'title' => ucwords($request->title),
            'slug' => Str::slug($request->title),
            'subtitle' => ucwords($request->subtitle),
            'text' => ucfirst($request->text),
            'article_category_id' => $request->category_id,
            'is_visible' => $request->is_visible,
            'location' => ucwords($request->location),
            'completed_date' => $request->completed_date,
            'published_date' => $request->published_date
        ]);
        // Create the tags relationship instances.
        $new_article->article_tags()->sync($request->tags, false);
        // Return a redirect to the show route.
        return redirect()
            ->route('articles.show', $new_article->id)
            ->with('success', 'You have successfully created a new article.');
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
        $selected_article = Article::findOrFail($id);
        // Find the featured image.
        $featured_image = ArticleImage::where('article_id', $id)
            ->where('is_featured', 1)
            ->first();
        // Return the show view.
        return view('menu.content.articles.show')
            ->with([
                'selected_article' => $selected_article,
                'featured_image' => $featured_image
            ]);
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
        $selected_article = Article::findOrFail($id);
        // Set The Required Variables.
        // Get all article categories.
        $all_categories = ArticleCategory::select(['id', 'title'])
            ->orderBy('title', 'asc')
            ->get();
        // Get all article tags.
        $all_tags = ArticleTag::select(['id', 'title'])
            ->orderBy('title', 'asc')
            ->get();
        // Return the edit view.
        return view('menu.content.articles.edit')
            ->with([
                'selected_article' => $selected_article,
                'all_categories' => $all_categories,
                'all_tags' => $all_tags
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
            'title' => 'required|min:5|max:255|unique:articles,title,'.$id,
            'subtitle' => 'required|min:5|max:255',
            'text' => 'required|min:20|max:3000',
            'location' => 'required|min:3|max:100',
            'completed_date' => 'required',
            'published_date' => 'required',
        ]);
        // Find and update the model instance.
        $selected_article = Article::findOrFail($id);
        // Update the selected model instance.
        $selected_article->update([
            'title' => ucwords($request->title),
            'slug' => Str::slug($request->title),
            'subtitle' => ucwords($request->subtitle),
            'text' => ucfirst($request->text),
            'article_category_id' => $request->category_id,
            'is_visible' => $request->is_visible,
            'location' => ucwords($request->location),
            'completed_date' => $request->completed_date,
            'published_date' => $request->published_date
        ]);
        // Update the tags relationship instances.
        isset($request->tags)
            ? $selected_article->article_tags()->sync($request->tags)
            : $selected_article->article_tags()->sync(array());
        // Return a redirect to the show route.
        return redirect()
            ->route('articles.show', $id)
            ->with('success', 'You have successfully updated the selected article.');
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
        $selected_article = Article::findOrFail($id);
        // Delete related images.
        if ($selected_article->article_images()->exists()) {
            // Loop through each related image.
            foreach($selected_article->article_images as $image) {
                // Check if the file path value is not null and file exists on the server.
                if ($image->image_path != null && file_exists(public_path($image->image_path))) {
                    // Delete the file from the server.
                    unlink(public_path($image->image_path));
                }
            }
        }
        // Delete the selected model instance.
        $selected_article->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('articles.index')
            ->with('success', 'You have successfully deleted the selected article.');
    }
}
