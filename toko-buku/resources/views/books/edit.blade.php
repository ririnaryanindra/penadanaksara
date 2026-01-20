<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Toko Buku</title>
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
    <p class="mb-3" style="font-size: 1.5rem; font-weight: 600;">Edit Buku</p>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/books/{{ $book->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Judul Buku</label>
            <input class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white file:font-semibold hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white file:font-semibold hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="form-group">
            <label for="year">Tahun Terbit</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="number" id="year" name="year" oninput="limitYear(this)" min="1000" max="{{ date('Y') }}" value="{{ old('year', $book->year) }}" placeholder="Contoh: 2026" required>
        </div>

        <div class="form-group">
            <label for="stock">Stok</label>
            <input class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white file:font-semibold hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="number" id="stock" name="stock" value="{{ old('stock', $book->stock) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"  id="category_id" name="category_id">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Gambar</label>
            @if($book->image)
                <div style="margin-bottom: 8px; font-size: 13px; color: #6b7280;">
                    Gambar saat ini:
                    <button type="button" onclick="openImageModal('/{{ $book->image }}')" class="text-indigo-600 hover:underline font-medium">Lihat Gambar</button>
                </div>
            @endif
            <input class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white file:font-semibold hover:file:bg-indigo-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" style="border: none;" type="file" id="image" onchange="previewImage(event)" name="image" accept="image/*">
            <img id="imagePreview" class="mt-4 hidden max-h-64 rounded-lg border border-gray-200 shadow-sm" alt="Preview Gambar">
        </div>

        <div class="button-group">
            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white font-semibold text-sm hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">Simpan Perubahan</button>
            <a href="/books" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 font-semibold text-sm hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline" style="text-decoration: none;">Batal</a>
        </div>
    </form>

    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-70">
        <div class="relative bg-white rounded-lg shadow-lg max-w-3xl w-full mx-4">
            
            <button onclick="closeImageModal()" class="absolute top-2 right-3 text-gray-600 hover:text-black text-2xl font-bold">
                &times;
            </button>

            <div class="flex justify-center p-4">
                <img id="modalImage" class="max-h-[80vh] rounded-lg object-contain" alt="Preview Gambar">
            </div>
        </div>
    </div>
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

<script>
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const image = document.getElementById('modalImage');

    image.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('imageModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
</body>
</html>
