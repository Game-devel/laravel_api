<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\CategoryProduct;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id = null)
    {
        $rules = Validator::make(['category_id' => $category_id], [
            'category_id' => 'nullable|integer|exists:categories,id',            
        ]);     
        if ($rules->fails()) {
            return response()->json($rules->failed(), 423);
        }
        
        if ($category_id != null) {
            $products = Product::leftJoin('category_product', 'category_product.product_id', '=', 'products.id')->where('category_product.category_id', $category_id)->get();
            return response()->json($products, 200);
        }

        return response()->json(Product::all(), 200);
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
            'description' => 'required|string|max:500',       
        ]); 
        if (!$rules) {
            return response()->json($rules, 423);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();
        return response()->json($product, 201);
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
            'name' => 'required|string|max:255|unique:products,name,'.$id.',id',
            'description' => 'required|string|max:500',       
        ]);
        if (!$rules) {
            return response()->json($rules, 423);
        }        

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        return response()->json($product, 200);
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
            'id' => 'required|integer|exists:products,id',            
        ]);     
        if ($rules->fails()) {
            return response()->json($rules->failed(), 423);
        }

        $product = Product::find($id);        
        $product->delete();

        return response()->json([], 204);
    }
}
