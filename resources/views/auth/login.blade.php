<x-guest-layout>
    <div class="bg-white/95 text-gray-800 p-8 rounded-2xl shadow-2xl max-w-md w-full">

        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-3xl">
                🔐
            </div>
            <h2 class="text-2xl font-bold mt-3">Login</h2>
            <p class="text-sm text-gray-500">Masuk untuk ke halaman selanjutnya</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-600 px-4 py-2 rounded mb-4 animate-shake">
                Email atau password salah!
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <input type="email" name="email" placeholder="Email"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                required>

            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                required>

            <div class="flex items-center justify-between text-sm text-gray-600">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>

                @if (Route::has('call-admin'))
                    <a href="{{ route('call-admin') }}" 
   class="text-black/70 hover:text-black transition">
    Call Admin
</a>

                @endif
            </div>

            <!-- Tombol Login -->
            <button
    type="submit"
    class="w-full py-3 rounded-lg font-semibold text-white
           bg-black/90 hover:bg-black
           backdrop-blur-md
           transition-all duration-300 shadow-lg hover:shadow-xl
           active:scale-95">
     LOGIN
</button>

        </form>
    

        </p>
    </div>

    <style>
        .animate-shake {
            animation: shake 0.4s;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            50% { transform: translateX(6px); }
            75% { transform: translateX(-6px); }
            100% { transform: translateX(0); }
        }
    </style>
</x-guest-layout>
