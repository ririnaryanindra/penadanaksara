<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        return Book::with('category')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'author'=>'required',
            'year'=>'required|integer',
            'stock'=>'required|integer',
            'category_id'=>'nullable|exists:categories,id',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['title','author','year','stock','category_id']);
        $book = Book::create($data);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/books', 'public');
            $book->image = $path;
            $book->save();
        }
        return response()->json($book,201);
    }

    public function show($id)
    {
        return Book::with('category')->findOrFail($id);
    }

    public function update(Request $request,$id)
    {
        $book = Book::findOrFail($id);
        $request->validate([
            'title'=>'sometimes|required',
            'author'=>'sometimes|required',
            'year'=>'sometimes|required|integer',
            'stock'=>'sometimes|required|integer',
            'category_id'=>'nullable|exists:categories,id',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $book->update($request->only(['title','author','year','stock','category_id']));

        if ($request->hasFile('image')) {
            // delete old if exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $path = $request->file('image')->store('uploads/books', 'public');
            $book->image = $path;
            $book->save();
        }
        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();
        return response()->json(['message'=>'Book deleted']);
    }
}
