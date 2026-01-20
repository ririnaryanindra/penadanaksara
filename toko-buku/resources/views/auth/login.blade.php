<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Buku</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        img {
            width: 100%;
            border-bottom-left-radius: 0.5rem;
            border-top-left-radius: 0.5rem;
        }
        button {
            margin-top: 0.75rem;
        }

        @media (max-width: 768px) {
            img {
                width: 100%;
                border-bottom-left-radius: 0;
                border-top-right-radius: 0.5rem;
                border-top-left-radius: 0.5rem;
            }
            .bagian-2 {
                margin-bottom: 2rem;
            }
            button {
                margin-top: 0.25rem;
            }
        }
    </style>
</head>
<body>
<div class="container container-small">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bagian-1">
            <img src="{{ asset('images/bglogin.jpg') }}" alt="Logo" loading="lazzy">
        </div>
        <div class="bagian-2 px-5 flex items-center justify-center">
            <div class="w-full max-w-md">
                <p class="text-center font-semibold mb-5" style="font-size: 1.5rem; font-weight: 600;">Masuk ke Toko Buku</p>

                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="error mb-3">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-2">
                    @csrf

                    <div>
                        <label for="email">Email</label>
                        <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="email" id="email" name="email" required>
                    </div>

                    <div>
                        <label for="password">Kata Sandi</label>
                        <input class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" type="password" id="password" name="password" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-violet-600 to-indigo-600 px-4 py-2 text-white font-semibold hover:from-violet-700 hover:to-indigo-700 transition">Masuk</button>

                        <p class="mt-3 text-sm">
                            Belum punya akun?
                            <a href="/register" class="text-indigo-600 hover:underline">Daftar</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
