<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Transaksi - Toko Buku</title>
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
    <p class="mb-3" style="font-size: 1.5rem; font-weight: 600;">Buat Transaksi Baru</p>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="info">
        Saat transaksi dibuat, stok buku akan otomatis berkurang sesuai jumlah yang dijual.
    </div>

    <form method="POST" action="/transactions">
        @csrf
        <div class="form-group">
            <label for="book_id">Pilih Buku</label>
            <select class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" id="book_id" name="book_id" required onchange="updateBookInfo()">
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" data-stock="{{ $book->stock }}" data-price="{{ $book->id }}">
                        {{ $book->title }} (Stok: {{ $book->stock }})
                    </option>
                @endforeach
            </select>
            <div id="book-info" class="book-info" style="display: none;"></div>
        </div>

        <div class="form-group">
            <label for="quantity">Jumlah Terjual</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
        </div>

        <div class="form-group">
            <label for="total_price">Total Harga (Rp)</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="number" id="total_price" name="total_price" value="{{ old('total_price') }}" min="0" step="1000" required>
        </div>

        <div class="button-group">
            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">Simpan Transaksi</button>
            <a href="/transactions" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 text-sm font-semibold hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline" style="text-decoration: none;">Batal</a>
        </div>
    </form>

    <script>
        function updateBookInfo() {
            const select = document.getElementById('book_id');
            const selectedOption = select.options[select.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            const bookInfo = document.getElementById('book-info');
            
            if (select.value) {
                bookInfo.innerHTML = `📦 Stok tersedia: <strong>${stock}</strong> unit`;
                bookInfo.style.display = 'block';
            } else {
                bookInfo.style.display = 'none';
            }
        }
    </script>
</div>
</body>
</html>
