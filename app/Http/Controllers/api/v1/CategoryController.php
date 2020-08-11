<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        return response()->json(Category::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        $rules = $request->validate([
            'name' => 'required|string|max:255',            
        ]); 
        if (!$rules) {
            return response()->json($rules, 423);
        }        

        $category = new Category();
        $category->name = $request->name;        
        $category->save();
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $rules = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id.',id',            
        ]); 
        if (!$rules) {
            return response()->json($rules, 423);
        }        
        $category = Category::find($id);
        $category->name = $request->name;        
        $category->save();

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rules = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:categories,id',            
        ]);     
        if ($rules->fails()) {
            return response()->json($rules->failed(), 423);
        }

        $category = Category::find($id);        
        $category->delete();

        return response()->json([], 204);
    }
}
