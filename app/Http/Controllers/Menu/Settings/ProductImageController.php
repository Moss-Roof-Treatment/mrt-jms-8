<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Session;

class ProductImageController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set The Required Variables.
        $selected_product = Product::find($request->selected_product_id);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new path variable.
            $new_storage_path = 'storage/images/products/' . $filename;
            // Set the new file location.
            $location = storage_path('app/public/images/products/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
        }
        // Create the new model instance.
        ProductImage::create([
            'product_id' => $selected_product->id,
            'is_featured' => !$selected_product->product_images->count() ? 1 : 0,
            'image_path' => $new_storage_path,
        ]);
        // Flash success message to the session.
        Session::flash('success', 'You have successfully uploaded the selected product image(s).');
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
        $selected_product_image = ProductImage::findOrFail($id);
        // Return the show view.
        return view('menu.settings.productImages.show')
            ->with('selected_product_image', $selected_product_image);
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
        $selected_product_image = ProductImage::findOrFail($id);

        // Update the selected model instance.
        $all_product_images = ProductImage::where('product_id', $selected_product_image->product_id)
            ->get();

        // Loop through each image and set all to 0 - Not featured.
        foreach($all_product_images as $image) {
            // Set to not featured.
            $image->is_featured = 0;
            $image->save();
        }

        // Set only the selected image as featured.
        $selected_product_image = ProductImage::findOrFail($id);
        $selected_product_image->is_featured = 1;
        $selected_product_image->save();

        // Return the edit view.
        return redirect()
            ->route('product-image-settings.show', $selected_product_image->id)
            ->with('success', 'You have successfully updated the selected product image.');
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
        $selected_product_image = ProductImage::findOrFail($id);

        // Set The Required Variables.
        $selected_product_id = $selected_product_image->product_id;

        // Delete the selected model instance.
        // Delete the selected Image
        if ($selected_product_image->image_path != null) {

            if (file_exists(public_path($selected_product_image->image_path))) {
                unlink(public_path($selected_product_image->image_path));
            }
        }

        // Delete the selected image.
        $selected_product_image->delete();

        // Find the featured image if it exists.
        $featured_image = ProductImage::where('product_id', $selected_product_id)
            ->where('is_featured', 1)
            ->first();

        // If there is no featured image then set the first image found to is_featured.
        if ($featured_image == null) {

            // Find the first image.
            $new_featured_image = ProductImage::where('product_id', $selected_product_id)
                ->first();

            // If there is an image to set to is_featured then set it to is_featured, else skip.
            if ($new_featured_image != null) {

                $new_featured_image->is_featured = 1;
                $new_featured_image->save();
            }
        }

        // Return the edit view.
        return redirect()
            ->route('product-settings.show', $selected_product_id)
            ->with('success', 'You have successfully deleted the selected product image.');
    }
}
