<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;

class TransactionWebController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('book')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::all();
        return view('transactions.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $book = Book::findOrFail($request->book_id);
        
        // Cek stok
        if ($book->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak cukup. Stok tersedia: ' . $book->stock])->withInput();
        }

        // Kurangi stok buku
        $book->decrement('stock', $request->quantity);

        Transaction::create($request->only('book_id', 'quantity', 'total_price'));

        return redirect('/transactions')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show($id)
    {
        $transaction = Transaction::with('book')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Kembalikan stok buku
        $transaction->book->increment('stock', $transaction->quantity);
        
        $transaction->delete();
        return redirect('/transactions')->with('success', 'Transaksi berhasil dihapus.');
    }
}
