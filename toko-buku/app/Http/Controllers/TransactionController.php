<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::with('book')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'=>'required|exists:books,id',
            'quantity'=>'required|integer|min:1'
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->stock < $request->quantity) {
            return response()->json(['message'=>'Stock tidak cukup'], 400);
        }

        // For demo purpose assume price per book is provided or default
        $pricePerBook = $request->input('price_per_book', 10000);
        $total = $pricePerBook * $request->quantity;

        $trans = Transaction::create([
            'book_id'=>$book->id,
            'quantity'=>$request->quantity,
            'total_price'=>$total
        ]);

        $book->stock -= $request->quantity;
        $book->save();

        return response()->json($trans,201);
    }
}
