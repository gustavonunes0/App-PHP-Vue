<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('images')->get();
    }

    public function store(Request $request)
{
    \Log::info($request->all());

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $category = Category::create($request->only('name'));

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images/categories', 'public');
        \Log::info('Image stored at: ' . $path);
        $category->images()->create(['url' => $path, 'filename' => $request->file('image')->getClientOriginalName()]);
    }

    return response()->json($category->load('images'), 201);
}


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update($request->only('name'));
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
}