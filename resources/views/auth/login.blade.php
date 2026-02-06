<x-guest-layout>
<<<<<<< HEAD
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
=======
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
>>>>>>> 3c78d2581c8dbfd6762db81c00d4ea271138a876

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

<<<<<<< HEAD
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            
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
>>>>>>> 3c78d2581c8dbfd6762db81c00d4ea271138a876
</x-guest-layout>
