<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
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
        $all_products = Product::paginate(20);
        // Return the index view.
        return view('menu.settings.products.index')
            ->with('all_products', $all_products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.products.create');
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
            'name' => 'required|string|min:3|max:50',
            'details' => 'sometimes|nullable|string|min:5|max:1000',
            'description' => 'sometimes|nullable|string|min:5|max:1000',
            'cost_price' => 'required|string',
            'profit_amount' => 'sometimes|nullable|string',
            'postage_price' => 'sometimes|nullable|string',
            'dimensions' => 'sometimes|nullable|string|min:9|max:20',
            'weight' => 'sometimes|nullable|string|min:1|max:6|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Set The Required Variables.
        // Set the title.
        $formated_name = ucwords($request->name);
        // FORMAT COST PRICE
        // Strip all dollar signs, commas and periods.
        $formated_cost_price = isset($request->cost_price)
            ? preg_replace('/[$.,]/', '', $request->cost_price)
            : 0;
        // FORMAT PROFIT MARGIN
        // Strip all dollar signs, commas and periods.
        $formated_profit_amount = isset($request->profit_amount)
            ? preg_replace('/[$.,]/', '', $request->profit_amount)
            : 0;
        // FORMAT POSTAGE AMOUNT
        // Strip all dollar signs, commas and periods.
        $formated_postage_price = isset($request->postage_price)
            ? preg_replace('/[$.,]/', '', $request->postage_price)
            : 0;
        // CREATE TOTAL PRICE
        // Add the cost price, profit margin and postage price to create the total price.
        $total_price = $formated_cost_price + $formated_profit_amount + $formated_postage_price;
        // Create a new model instance.
        $new_product = Product::create([
            'name' => $formated_name,
            'slug' => Str::slug($formated_name),
            'details' => ucfirst($request->details),
            'description' => ucfirst($request->description),
            'cost_price' => $formated_cost_price,
            'profit_amount' => $formated_profit_amount,
            'postage_price' => $formated_postage_price,
            'price' => $total_price,
            'dimensions' => $request->dimensions,
            'weight' => $request->weight,
            'is_visible' => $request->is_visible,
        ]);
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
            $image->resize(1280, 720)->toJpeg(80)->save($location);
            // Create the new model instance.
            ProductImage::create([
                'product_id' => $new_product->id,
                'is_featured' => 1,
                'image_path' => $new_storage_path,
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('product-settings.show', $new_product->id)
            ->with('success', 'You have successfully created a new product.');
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
        $selected_product = Product::findOrFail($id);
        // Return the show view.
        return view('menu.settings.products.show')
            ->with('selected_product', $selected_product);
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
        $selected_product = Product::findOrFail($id);
        // Return the show view.
        return view('menu.settings.products.edit')
            ->with('selected_product', $selected_product);
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
            'name' => 'required|string|min:3|max:50|unique:products,name,'.$id,
            'details' => 'sometimes|nullable|string|min:5|max:1000',
            'description' => 'sometimes|nullable|string|min:5|max:1000',
            'cost_price' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
            'profit_amount' => 'nullable|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
            'postage_price' => 'nullable|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
            'dimensions' => 'sometimes|nullable|string|min:9|max:20',
            'weight' => 'sometimes|nullable|string|min:1|max:6|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        // Find the required model instance.
        $selected_product = Product::findOrFail($id);
        // Set The Required Variables.
        // Set the title.
        $formated_name = ucwords($request->name);
        // FORMAT COST PRICE
        // Strip all dollar signs, commas and periods.
        $formated_cost_price = isset($request->cost_price)
            ? preg_replace('/[$.,]/', '', $request->cost_price)
            : 0;
        // FORMAT PROFIT MARGIN
        // Strip all dollar signs, commas and periods.
        $formated_profit_amount = isset($request->profit_amount)
            ? preg_replace('/[$.,]/', '', $request->profit_amount)
            : 0;
        // FORMAT POSTAGE AMOUNT
        // Strip all dollar signs, commas and periods.
        $formated_postage_price = isset($request->postage_price)
            ? preg_replace('/[$.,]/', '', $request->postage_price)
            : 0;
        // CREATE TOTAL PRICE
        // Add the cost price, profit margin and postage price to create the total price.
        $total_price = $formated_cost_price + $formated_profit_amount + $formated_postage_price;
        // Update the selected model instance.
        $selected_product->update([
            'name' => $formated_name,
            'slug' => Str::slug($formated_name),
            'details' => ucfirst($request->details),
            'description' => ucfirst($request->description),
            'cost_price' => $formated_cost_price,
            'profit_amount' => $formated_profit_amount,
            'postage_price' => $formated_postage_price,
            'price' => $total_price,
            'dimensions' => $request->dimensions,
            'weight' => $request->weight,
            'is_visible' => $request->is_visible,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('product-settings.show', $selected_product->id)
            ->with('success', 'You have successfully updated the selected product.');
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
        $selected_product = Product::findOrFail($id);
        // Delete the relationship instances.
        if ($selected_product->product_images()->exists()) {
            foreach($selected_product->product_images as $image) {
                if ($image->image_path != null && file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            }
        }
        // Delete the selected model instances.
        $selected_product->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('product-settings.index')
            ->with('success', 'You have successfully deleted the selected article.');
    }
}
