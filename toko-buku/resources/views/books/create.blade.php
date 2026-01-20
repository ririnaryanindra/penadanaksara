<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Toko Buku</title>
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
    <p style="font-size: 1.5rem; font-weight: 600;" class="mb-3">Tambah Buku Baru</p>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/books" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Judul Buku</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul Buku" required autofocus>
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="text" id="author" name="author" value="{{ old('author') }}" placeholder="Masukkan Nama Penulis" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="form-group">
                <label for="year">Tahun Terbit</label>
                <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="number" id="year" name="year" oninput="limitYear(this)" min="1000" max="{{ date('Y') }}" value="{{ old('year') }}" placeholder="Contoh: 2026" required>
            </div>
    
            <div class="form-group">
                <label for="stock">Stok</label>
                <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0" placeholder="Masukkan Stok Buku" required>
            </div>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" id="category_id" name="category_id">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-6">
            <label for="image">Gambar</label>
            <input class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white file:font-semibold hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" style="border: none;" type="file" id="image" onchange="previewImage(event)" name="image" accept="image/*">
            <img id="imagePreview" class="mt-4 hidden max-h-64 rounded-lg border border-gray-200 shadow-sm" alt="Preview Gambar">
        </div>

        <div class="button-group">
            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">Simpan</button>
            <a href="/books" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 text-sm font-semibold hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline" style="text-decoration: none;">Batal</a>
        </div>
    </form>
</div>

<script>
function limitYear(input) {
    let value = input.value.toString();

    value = value.replace(/\D/g, '');

    if (value.length > 4) {
        value = value.slice(0, 4);
    }

    input.value = value;
}
</script>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
