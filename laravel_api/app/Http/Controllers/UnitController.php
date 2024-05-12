<?php

namespace App\Http\Controllers;


use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit=Unit::all();
        return $this->sendResponse($unit,'unit list fetched successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
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
        $unit=Unit::create($input);
        return $this->sendResponse($unit, 'Unit created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit=Unit::find($id);
        return $this->sendResponse($unit,'Unit fetched successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = Unit::find($id);
        return $this ->sendResponse($unit,'Unit fetched succesfully');
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
         $unit = Unit::find($id)->update($input);
         return $this ->sendResponse($unit , 'Unit updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::find($id)->delete();
        return $this->sendResponse($unit,'Unit deleted successfully!');
    }
}
