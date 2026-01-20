<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // Statistik Utama
        // =====================
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_price');

        // =====================
        // Transaksi Terbaru
        // =====================
        $latestTransactions = Transaction::with('book')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // =====================
        // Grafik Pendapatan Bulanan
        // =====================
        $monthlyRevenue = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $months = [];
        $totals = [];

        foreach ($monthlyRevenue as $row) {
            $months[] = date('F', mktime(0, 0, 0, $row->month, 1));
            $totals[] = $row->total;
        }

        return view('dashboard.index', compact(
            'totalBooks',
            'totalCategories',
            'totalTransactions',
            'totalRevenue',
            'latestTransactions',
            'months',
            'totals'
        ));
    }

    // =====================
    // Export CSV Transaksi
    // =====================
    public function exportTransactions()
    {
        $fileName = 'data_transaksi_' . date('Y-m-d') . '.csv';

        $transactions = Transaction::with('book')
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Tanggal',
                'Judul Buku',
                'Quantity',
                'Total Harga'
            ]);

            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->created_at->format('d-m-Y'),
                    $trx->book->title ?? '-',
                    $trx->quantity,
                    $trx->total_price
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}