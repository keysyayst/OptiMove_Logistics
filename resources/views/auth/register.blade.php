<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Optimove</title>
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
    <div class="min-h-screen flex items-center justify-center px-4 py-12"
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
                <h2 class="text-2xl font-semibold mb-6 text-center">Buat Akun Baru</h2>

                <form id="register-form" class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-300 mb-2 block">
                            <i class="fas fa-user mr-2 text-orange-500"></i>Nama Lengkap
                        </label>
                        <input type="text" name="name" required
                               class="w-full rounded-lg bg-black/40 border border-gray-700 px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                               placeholder="John Doe">
                    </div>

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
                               placeholder="Minimal 8 karakter">
                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    <button type="submit" id="register-btn"
                            class="w-full rounded-full bg-orange-600 hover:bg-orange-500 py-3 text-sm font-semibold transition transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>

                    <p id="register-msg" class="text-xs mt-3 text-center hidden"></p>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login.page') }}" class="text-orange-400 hover:text-orange-300 font-medium">
                            Login di sini
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
        const registerForm = document.getElementById('register-form');
        const registerBtn = document.getElementById('register-btn');
        const registerMsg = document.getElementById('register-msg');

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const name = form.name.value.trim();
            const email = form.email.value.trim();
            const password = form.password.value;

            // Validasi
            if (password.length < 8) {
                registerMsg.textContent = 'Password minimal 8 karakter';
                registerMsg.classList.remove('hidden', 'text-green-400');
                registerMsg.classList.add('text-red-400');
                return;
            }

            // Reset message
            registerMsg.classList.add('hidden');
            registerMsg.textContent = '';

            // Disable button
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mendaftar...';

            try {
                const res = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, password }),
                });

                const data = await res.json();

                if (res.ok) {
                    // Success
                    registerMsg.classList.remove('hidden', 'text-red-400');
                    registerMsg.classList.add('text-green-400');
                    registerMsg.textContent = '✓ Registrasi berhasil! Silakan login.';
                    form.reset();

                    // Redirect ke login setelah 2 detik
                    setTimeout(() => {
                        window.location.href = '{{ route('login.page') }}';
                    }, 2000);
                } else {
                    // Error
                    const errorMsg = data.message || data.error || 'Registrasi gagal';
                    registerMsg.classList.remove('hidden', 'text-green-400');
                    registerMsg.classList.add('text-red-400');
                    registerMsg.textContent = errorMsg;

                    // Reset button
                    registerBtn.disabled = false;
                    registerBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Daftar Sekarang';
                }
            } catch (err) {
                console.error('Register error:', err);
                registerMsg.classList.remove('hidden', 'text-green-400');
                registerMsg.classList.add('text-red-400');
                registerMsg.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';

                // Reset button
                registerBtn.disabled = false;
                registerBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Daftar Sekarang';
            }
        });
    </script>
</body>
</html>
