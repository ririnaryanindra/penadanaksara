<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('books')->get();
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required']);
        return Category::create($request->only('name'));
    }

    public function show($id)
    {
        return Category::with('books')->findOrFail($id);
    }

    public function update(Request $request,$id)
    {
        $cat = Category::findOrFail($id);
        $request->validate(['name'=>'required']);
        $cat->update($request->only('name'));
        return response()->json($cat);
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(['message'=>'Category deleted']);
    }
}
