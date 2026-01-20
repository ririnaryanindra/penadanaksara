<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Toko Buku</title>
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
    <div class="header">
        <p style="font-size: 1.5rem; font-weight: 600;" data-animate="fadeInUp">Daftar Buku</p>
        <div class="actions" data-animate="fadeInUp">
            <a href="/books/create" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white text-sm font-semibold hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">+ Tambah Buku</a>
            <form method="POST" action="/logout" style="display: inline;">
                @csrf
                <button type="submit" class="rounded-lg bg-gray-200 px-3 py-1.5 text-gray-700 text-sm font-semibold hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-400 no-underline">Keluar</button>
            </form>
        </div>
    </div>

    <div class="nav-links">
        <a href="/dashboard" data-animate="fadeInUp">← Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if($books->count() > 0)
        <div class="overflow-x-auto w-full" data-animate="fadeIn">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $index => $book)
                        <tr>
                            <td>{{ ($books->currentPage() - 1) * $books->perPage() + $index + 1 }}</td>
                            <td>
                                @if($book->image)
                                    <img src="/{{ $book->image }}" alt="{{ $book->title }}" class="cursor-pointer" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;" onclick="openImageModal(this.src, '{{ $book->title }}')">
                                @else
                                    <div style="width: 50px; height: 70px; background: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #9ca3af;">Tidak ada</div>
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->year }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>{{ $book->category->name ?? '-' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="/books/{{ $book->id }}/edit" class="px-3 py-1.5 text-sm rounded-md bg-blue-500 text-white hover:bg-blue-600">Edit</a>
                                    <form method="POST" action="/books/{{ $book->id }}" style="display: inline;">
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
            {{ $books->links() }}
        </div>
    @else
        <div class="empty">
            <p>Belum ada buku. <a href="/books/create" style="color: #2563eb;">Tambah buku sekarang</a></p>
        </div>
    @endif

    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-70">
        <div class="relative bg-white rounded-lg shadow-lg max-w-3xl w-full mx-4">
            
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-2xl">
                &times;
            </button>

            <p id="modalTitle" class="text-center font-semibold p-4"></p>

            <div class="flex justify-center p-4">
                <img id="modalImage" class="max-h-[80vh] rounded-lg object-contain" alt="Preview">
            </div>
        </div>
    </div>

</div>

<script>
function openImageModal(src, title) {
    const modal = document.getElementById('imageModal');
    const image = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');

    image.src = src;
    modalTitle.textContent = title;

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