<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - Toko Buku</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
<div class="container px-5 py-6">
    <div class="header" data-animate="fadeInUp">
        <p style="font-size: 1.5rem; font-weight: 600;" data-animate="fadeInUp">Daftar Kategori</p>
        <div>
            <a href="/categories/create" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white font-semibold text-sm hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">+ Tambah Kategori</a>
            <form method="POST" action="/logout" style="display: inline;">
                @csrf
                <button type="submit" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 font-semibold text-sm hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline">Keluar</button>
            </form>
        </div>
    </div>

    <div class="nav-links" data-animate="fadeInUp">
        <a href="/dashboard">← Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if($categories->count() > 0)
        <div class="overflow-x-auto w-full" data-animate="fadeIn">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->books->count() }}</td>
                            <td>
                                <div class="actions">
                                    <a href="/categories/{{ $category->id }}/edit" class="px-3 py-1.5 text-sm rounded-md bg-orange-400 text-white hover:bg-orange-500">Edit</a>
                                    <form method="POST" action="/categories/{{ $category->id }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-sm rounded-md bg-red-600 text-white hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            {{ $categories->links() }}
        </div>
    @else
        <div class="empty" data-animate="fadeInUp">
            <p>Belum ada kategori. <a href="/categories/create" style="color: #2563eb;">Tambah kategori sekarang</a></p>
        </div>
    @endif
</div>

<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const el = entry.target;
            const animation = el.dataset.animate;

            el.classList.add(
                'animate__animated',
                `animate__${animation}`
            );

            observer.unobserve(el);
        }
    });
});

document.querySelectorAll('[data-animate]').forEach(el => {
    observer.observe(el);
});
</script>
</body>
</html>
