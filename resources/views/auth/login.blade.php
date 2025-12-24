<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Optimove</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#111111] text-white">
    <div class="min-h-screen flex items-center justify-center px-4"
         style="background-image: linear-gradient(rgba(0,0,0,0.75),rgba(0,0,0,0.9)), url('https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center;">

        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-wide">
                    OPTI<span class="text-orange-500">MOVE</span>
                </h1>
                <p class="text-gray-400 text-sm mt-2">Heavy & Oversized Logistics</p>
            </div>

            <!-- Card -->
            <div class="bg-[#1a1a1a] rounded-2xl p-8 border border-gray-800 shadow-2xl">
                <h2 class="text-2xl font-semibold mb-6 text-center">Login ke Dashboard</h2>

                <form id="login-form" class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-300 mb-2 block">
                            <i class="fas fa-envelope mr-2 text-orange-500"></i>Email
                        </label>
                        <input type="email" name="email" required
                               class="w-full rounded-lg bg-black/40 border border-gray-700 px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                               placeholder="nama@email.com">
                    </div>

                    <div>
                        <label class="text-sm text-gray-300 mb-2 block">
                            <i class="fas fa-lock mr-2 text-orange-500"></i>Password
                        </label>
                        <input type="password" name="password" required
                               class="w-full rounded-lg bg-black/40 border border-gray-700 px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                               placeholder="••••••••">
                    </div>

                    <button type="submit" id="login-btn"
                            class="w-full rounded-full bg-orange-600 hover:bg-orange-500 py-3 text-sm font-semibold transition transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </button>

                    <p id="login-msg" class="text-xs mt-3 text-center text-red-400 hidden"></p>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-400">
                        Belum punya akun?
                        <a href="{{ route('register.page') }}" class="text-orange-400 hover:text-orange-300 font-medium">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-800 text-center">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-300">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cek jika sudah login, redirect ke dashboard
        const existingToken = localStorage.getItem('optimove_token');
        if (existingToken) {
            // Verifikasi token valid
            fetch('/api/auth/me', {
                headers: { 'Authorization': `Bearer ${existingToken}` }
            })
            .then(res => {
                if (res.ok) {
                    window.location.href = '{{ route('dashboard') }}';
                }
            });
        }

        const loginForm = document.getElementById('login-form');
        const loginBtn = document.getElementById('login-btn');
        const loginMsg = document.getElementById('login-msg');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const email = form.email.value.trim();
            const password = form.password.value;

            // Reset message
            loginMsg.classList.add('hidden');
            loginMsg.textContent = '';

            // Disable button
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Login...';

            try {
                const res = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password }),
                });

                const data = await res.json();

                if (res.ok && data.access_token) {
                    // Simpan token
                    localStorage.setItem('optimove_token', data.access_token);

                    // Redirect ke dashboard
                    window.location.href = '{{ route('dashboard') }}';
                } else {
                    // Show error
                    loginMsg.textContent = data.error || data.message || 'Login gagal. Periksa email dan password Anda.';
                    loginMsg.classList.remove('hidden');

                    // Reset button
                    loginBtn.disabled = false;
                    loginBtn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Login';
                }
            } catch (err) {
                console.error('Login error:', err);
                loginMsg.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                loginMsg.classList.remove('hidden');

                // Reset button
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i>Login';
            }
        });
    </script>
</body>
</html>
