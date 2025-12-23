@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#111] text-white">
    <div class="w-full max-w-md bg-[#1a1a1a] rounded-2xl p-8 border border-gray-800">
        <h1 class="text-2xl font-semibold mb-6 text-center">Login Optimove</h1>

        <form id="login-form" class="space-y-4">
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
                Login
            </button>

            <p class="text-center text-xs text-gray-400 mt-3">
                Belum punya akun?
                <a href="{{ route('register.page') }}" class="text-orange-400">Register</a>
            </p>

            <p id="login-msg" class="text-xs mt-2 text-center text-red-400"></p>
        </form>
    </div>
</div>

<script>
document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const body = {
        email: form.email.value,
        password: form.password.value,
    };

    const res = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body),
    });

    const data = await res.json();
    const msg = document.getElementById('login-msg');

    if (res.ok) {
        localStorage.setItem('optimove_token', data.access_token);
        window.location.href = '{{ route('dashboard') }}';
    } else {
        msg.textContent = data.error ?? 'Login gagal';
    }
});
</script>
@endsection
