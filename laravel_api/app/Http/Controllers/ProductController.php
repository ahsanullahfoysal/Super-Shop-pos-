<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->with('category', 'sub_category','brand' ,'photo')->get();
        $category_id = Category::with('sub_category')->orderBy('id', 'desc')->get();
        $sub_category_id = SubCategory::orderBy('id', 'desc')->get();
        $tdata = ([$products, $category_id, $sub_category_id]);
        return $this->sendResponse($tdata, 'Product list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'sub_category_id' => 'required',
            'brand_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $input['category_id'] = $request->category_id;
        $input['name'] = $request->name;
        $input['brand_id'] = $request->brand_id;
        $input['sub_category_id'] = $request->sub_category_id;

        $path['path'] = $request->path;
        $file = $request->path;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $request->path->move(public_path('photos/products'), $filename);
        $products = Product::create($input);
        $products->photo()->create(['path' => $filename]);
        return $this->sendResponse($products, 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::with('category', 'sub_category','photo')->find($id);
        return $this->sendResponse($products, 'Product list fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = Product::with('category', 'sub_category','photo')->find($id);
        return $this->sendResponse($products, 'Product fetched successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'brand_id' => 'required',
            'sub_category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $product = Product::findOrFail($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        $input = $request->all();
        if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
            $oldFilename = $product->photo->path;
            File::delete('photos/products/' . $oldFilename);
            $file = $request->photo;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('photos/products'), $filename);
            // Update the product's photo path
             $product->photo()->update(['path' => $filename]);
        }
        $product->update($input);
        return $this->sendResponse($product, 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);
        if (is_null($products)) {
            return $this->sendError('Product not found.');
        }
        $oldFilename = $products->photo->path;
        File::delete('photos/products/' . $oldFilename);
        $products->photo->delete();
        $products->delete();
        return $this->sendResponse($oldFilename, 'Product deleted successfully!');
    }
}
