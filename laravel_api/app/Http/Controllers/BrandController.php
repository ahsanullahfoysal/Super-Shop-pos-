<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand=Brand::orderBy('id',)->with('product','sale', 'purchase')->get();
        return $this->sendResponse($brand,'brand list fetched successfully!');
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
        $brand=Brand::create($input);
        return $this->sendResponse($brand, 'Brand created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand=Brand::with('product','sale','purchase')->find($id);
        return $this->sendResponse($brand,'brand fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::find($id);
        return $this ->sendResponse($brand,'Brand fetched succesfully');
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
         $brand = Brand::find($id)->update($input);
         return $this ->sendResponse($brand , 'Brand updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id)->delete();
        return $this->sendResponse($brand,'Brand deleted successfully!');
    }
}
