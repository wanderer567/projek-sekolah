<x-guest-layout>

    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-900 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            
            <!-- Left Menu -->
            <div class="text-sm">
                <a href="{{ url('/') }}"
                   class="text-gray-600 dark:text-gray-300 hover:text-green-600 transition">
                    Home
                </a>
            </div>

            <!-- Logo Center -->
            <div class="flex items-center justify-center">
                <img
                    src="{{ asset('images/logo-smp.png') }}"
                    alt="Logo Sekolah"
                    class="h-10 w-auto"
                />
            </div>

            <!-- Right Menu -->
            <div class="text-sm">
                <a href="{{ route('login') }}"
                   class="text-gray-600 dark:text-gray-300 hover:text-green-600 transition">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)"
        x-show="show"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="max-w-md mx-auto mt-10"
    >
        <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 text-center
                   transition-transform duration-300 hover:-translate-y-1"
        >

            <!-- Icon -->
            <div
                class="mx-auto mb-4 w-14 h-14 flex items-center justify-center
                       rounded-full bg-green-100 text-green-600 animate-pulse"
            >
                📲
            </div>

            <!-- Title -->
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                Belum Punya Akun Absensi?
            </h2>

            <!-- Description -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Akun absensi dibuat oleh admin untuk menjaga keamanan data.
                Silakan hubungi admin melalui WhatsApp.
            </p>

            <!-- CTA Button -->
            <a
                href="https://wa.me/6281460367229?text=Halo%20Admin,%20saya%20ingin%20membuat%20akun%20absensi."
                target="_blank"
                class="inline-flex items-center justify-center w-full px-4 py-3
                       bg-green-600 hover:bg-green-700
                       text-white font-semibold rounded-xl
                       transition-all duration-200
                       hover:-translate-y-0.5 hover:shadow-lg
                       active:scale-95"
            >
                💬 Hubungi Admin
            </a>

            <!-- Footer -->
            <p class="text-xs text-gray-400 mt-4">
                Jam layanan admin: 08.00 – 16.00 WIB
            </p>
        </div>
    </div>

</x-guest-layout>
