<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="actions mb-5 mt-auto flex justify-end">
            <form method="POST" action="/logout" style="display: inline;">
                @csrf
                <button type="submit" class="px-3 py-1.5 text-sm rounded-md bg-red-500 text-white hover:bg-red-600" data-animate="fadeInUp">Keluar</button>
            </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-white rounded shadow" data-animate="fadeInUp">
                <p class="text-gray-500">Total Buku</p>
                <p class="mt-3 text-center text-3xl font-bold">{{ $totalBooks }}</p>
                <div class="mt-7 flex justify-end">
                    <a href="/books" class="px-3 py-1.5 text-sm rounded-md bg-blue-500 text-white hover:bg-blue-600">Daftar Buku</a>
                </div>
            </div>
            <div class="p-4 bg-white rounded shadow" data-animate="fadeInUp">
                <p class="text-gray-500">Total Kategori</p>
                <p class="mt-3 text-center text-3xl font-bold">{{ $totalCategories }}</p>
                <div class="mt-7 flex justify-end">
                    <a href="/categories" class="px-3 py-1.5 text-sm rounded-md bg-green-500 text-white hover:bg-green-600">Kategori</a>
                </div>
            </div>
            <div class="p-4 bg-white rounded shadow" data-animate="fadeInUp">
                <p class="text-gray-500">Total Transaksi</p>
                <p class="mt-3 text-center text-3xl font-bold">{{ $totalTransactions }}</p>
                <div class="mt-7 flex justify-end">
                    <a href="/transactions" class="px-3 py-1.5 text-sm rounded-md bg-orange-400 text-white hover:bg-orange-500">Transaksi</a>
                </div>
            </div>
            <div class="p-4 bg-white rounded shadow" data-animate="fadeInUp">
                <p class="text-gray-500">Total Pendapatan</p>
                <p class="my-7 text-center text-3xl font-semibold text-green-600">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10 items-center" data-animate="fadeInUp">
            <div>
                <h3 class="text-lg font-semibold">Transaksi Terbaru</h3>
            </div>

            <div class="flex justify-start md:justify-end">
                <a href="{{ route('transactions.export') }}" class="px-3 py-1.5 text-sm rounded-md bg-blue-500 text-white hover:bg-blue-600">Unduh Data Transaksi</a>
            </div>
        </div>

        <div class="overflow-x-auto" data-animate="fadeInUp">
            <table class="min-w-full text-sm border-collapse">
                <thead>
                    <tr class="border-b text-left text-gray-500">
                        <th class="py-2 px-3 text-center">Tanggal</th>
                        <th class="py-2 px-3 text-center">Judul Buku</th>
                        <th class="py-2 px-3 text-center">Qty</th>
                        <th class="py-2 px-3 text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTransactions as $trx)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">
                                {{ $trx->created_at->format('d M Y') }}
                            </td>
                            <td class="py-2 px-3">
                                {{ $trx->book->title ?? '-' }}
                            </td>
                            <td class="py-2 px-3">
                                {{ $trx->quantity }}
                            </td>
                            <td class="py-2 px-3 font-semibold text-green-600">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-7 flex justify-end">
                <a href="/transactions" class="px-3 py-1.5 text-sm rounded-md bg-orange-400 text-white hover:bg-orange-500">Lihat Semua Transaksi</a>
            </div>
        </div>

        
        <h3 class="text-lg font-semibold mt-10" data-animate="fadeInUp">Transaksi Terbaru</h3>
        <div class="mt-5 bg-white p-6 rounded shadow" data-animate="fadeInUp">
            <h3 class="text-lg font-semibold mb-4">
                Grafik Pendapatan Bulanan
            </h3>

            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>


<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($totals),
                fill: true,
                tension: 0.4,
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
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