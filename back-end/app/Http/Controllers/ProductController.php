<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('images')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::create($request->only('name', 'description', 'category_id'));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');

            Image::create([
                'imageable_id' => $product->id,
                'imageable_type' => Product::class,
                'filename' => $request->file('image')->getClientOriginalName(),
                'url' => $imagePath,
            ]);
        }

        return response()->json($product->load('imageable'), 201);
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $product->update($request->only('name', 'description', 'category_id'));
        
        return response()->json($product, 200);
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
