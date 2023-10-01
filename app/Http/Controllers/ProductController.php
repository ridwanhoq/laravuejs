<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->get();

        return $products;
    }

    public function store(){
        $request = request();

        $product = Product::create([
            'name' => $request->name,
            'detail' => $request->detail
        ]);

        return response()->json(
            $product
        );

    }

    public function show($id){
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update($id){
        $request = request();
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'detail' => $request->detail
        ]);
        return response()->json('Product updated.');
    }

    public function destroy($id){
        $product = Product::find($id);
        $product->delete();

        return response()->json('Product deleted.');
    }


}
