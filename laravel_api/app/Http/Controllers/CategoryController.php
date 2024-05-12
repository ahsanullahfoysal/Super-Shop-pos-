<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::orderBy('id',)->with('product','sub_category')->get();
        return $this->sendResponse($categories,'Category list fetched successfully!');
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
            'name' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(),422);
        }
        $input = $request->all();
        $categories=Category::create($input);
        return $this->sendResponse($categories, 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories=Category::with('product','sub_category')->find($id);
        return $this->sendResponse($categories,'Category fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::find($id);
        return $this ->sendResponse($categories,'category fetched succesfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validator =Validator::make ($request->all(), [
            'name' =>'required',
         ]);
         if($validator->fails()){
            return $this ->sendError('Validation Eror.' , $validator->errors(),422);
         }
         $input = $request ->all();
         $categories = Category::find($id)->update($input);
         return $this ->sendResponse($categories , 'Category updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Category::find($id)->delete();
        return $this->sendResponse($categories,'Category deleted successfully!');
    }
}
