<x-guest-layout>
    <div class="bg-white/95 text-gray-800 p-8 rounded-2xl shadow-2xl max-w-md w-full">

        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-3xl">
                🔐
            </div>
            <h2 class="text-2xl font-bold mt-3">Login</h2>
            <p class="text-sm text-gray-500">Selamat Datang Di Sistem Absensi SMPN 1 Kedawung</p>
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

<<<<<<< HEAD

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

=======
>>>>>>> b6f2da7b798cf2b35c9d18f76501570da8e5a6bc
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

<<<<<<< HEAD
=======
<<<<<<< HEAD

            
             <div class="flex items-center justify-end mt-4">
          @if (Route::has('call-admin'))
    <a href="{{ route('call-admin') }}"
       class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline">
        {{ __('Call Admin') }}
    </a>
@endif



            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        
    </form>

=======
            <!-- Tombol Login -->
>>>>>>> b6f2da7b798cf2b35c9d18f76501570da8e5a6bc
>>>>>>> 22b33e9b9d14d9c344e3af923cbca2f970962eb6
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
<<<<<<< HEAD

</x-guest-layout>
=======
</x-guest-layout>
>>>>>>> b6f2da7b798cf2b35c9d18f76501570da8e5a6bc
