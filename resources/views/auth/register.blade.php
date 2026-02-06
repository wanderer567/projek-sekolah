<x-guest-layout>
    <div class="bg-white text-gray-800 p-8 rounded-2xl shadow-xl max-w-md w-full">
<div class="bg-white ... animate-[fade_0.6s_ease-in-out]">

        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-3xl">
                📝
            </div>
            <h2 class="text-2xl font-bold mt-3">Register</h2>
            <p class="text-sm text-gray-500">Buat akun baru</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-600 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Nama Lengkap"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                required>

            <input type="email" name="email" placeholder="Email"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                required>

            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                required>

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                required>

            <button
                class="w-full py-3 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-semibold transition">
                REGISTER
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-gray-800 font-semibold hover:underline">
                Login
            </a>
        </p>

    </div>
</x-guest-layout>
