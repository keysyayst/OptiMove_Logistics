@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#111] text-white">
    <div class="w-full max-w-md bg-[#1a1a1a] rounded-2xl p-8 border border-gray-800">
        <h1 class="text-2xl font-semibold mb-6 text-center">Register Optimove</h1>

        <form id="register-form" class="space-y-4">
            <div>
                <label class="text-sm">Nama</label>
                <input type="text" name="name"
                       class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm"
                       required>
            </div>
            <div>
                <label class="text-sm">Email</label>
                <input type="email" name="email"
                       class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm"
                       required>
            </div>
            <div>
                <label class="text-sm">Password</label>
                <input type="password" name="password"
                       class="mt-1 w-full rounded-lg bg-black/40 border border-gray-700 px-3 py-2 text-sm"
                       required>
            </div>

            <button type="submit"
                    class="w-full rounded-full bg-orange-600 hover:bg-orange-500 py-2 text-sm font-medium">
                Register
            </button>

            <p class="text-center text-xs text-gray-400 mt-3">
                Sudah punya akun?
                <a href="{{ route('login.page') }}" class="text-orange-400">Login</a>
            </p>

            <p id="register-msg" class="text-xs mt-2 text-center text-red-400"></p>
        </form>
    </div>
</div>

<script>
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const body = {
        name: form.name.value,
        email: form.email.value,
        password: form.password.value,
    };

    const res = await fetch('/api/auth/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body),
    });

    const data = await res.json();
    const msg = document.getElementById('register-msg');

    if (res.ok) {
        msg.classList.remove('text-red-400');
        msg.classList.add('text-green-400');
        msg.textContent = 'Registrasi berhasil, silakan login.';
        form.reset();
    } else {
        msg.classList.remove('text-green-400');
        msg.classList.add('text-red-400');
        msg.textContent = JSON.stringify(data);
    }
});
</script>
@endsection
