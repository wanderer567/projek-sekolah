<x-guest-layout>
    <div class="max-w-md mx-auto">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
            Konfirmasi Akses Absensi
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            Untuk melanjutkan ke halaman absensi, silakan masukkan password Anda.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="relative">
                <x-input-label for="password" value="Password" />

                <x-text-input
                    id="password"
                    class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required
                    autofocus
                    autocomplete="current-password"
                

                <!-- Show / Hide Password -->
                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700"
                >
                    👁️
                </button>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    Lanjutkan ke Absensi
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
