<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - Toko Buku</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style> 
</head>
<body>
<div class="container container-small px-5 py-6">
    <h2>Detail Transaksi #{{ $transaction->id }}</h2>

    <div class="detail-group">
        <div class="label">Nama Buku</div>
        <div class="value">{{ $transaction->book->title }}</div>
    </div>

    <div class="detail-group">
        <div class="label">Penulis</div>
        <div class="value">{{ $transaction->book->author }}</div>
    </div>

    <div class="detail-group">
        <div class="label">Kategori</div>
        <div class="value">{{ $transaction->book->category->name ?? '-' }}</div>
    </div>

    <div class="detail-group">
        <div class="label">Jumlah Terjual</div>
        <div class="value">{{ $transaction->quantity }} unit</div>
    </div>

    <div class="detail-group">
        <div class="label">Total Harga</div>
        <div class="price">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
    </div>

    <div class="detail-group">
        <div class="label">Tanggal Transaksi</div>
        <div class="value">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="button-group">
        <a href="/transactions" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 text-sm font-semibold hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline">← Kembali</a>
        <form method="POST" action="/transactions/{{ $transaction->id }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-1.5 text-sm rounded-md bg-red-600 text-white hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus? Stok akan dikembalikan.')">Hapus Transaksi</button>
        </form>
    </div>
</div>
</body>
</html>
