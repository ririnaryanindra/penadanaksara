<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Toko Buku</title>
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
    <p class="mb-3" style="font-size: 1.5rem; font-weight: 600;">Edit Kategori</p>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/categories/{{ $category->id }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required autofocus>
        </div>

        <div class="button-group">
            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white font-semibold text-sm hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">Simpan Perubahan</button>
            <a href="/categories" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 font-semibold text-sm hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline" style="text-decoration: none;">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
