<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Do you want to create an account? Contact The Admin number') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="flex justify-end mt-4">
            <x-primary-button>
                <a href="https://wa.me/+6281460367229?text=Hallo%10Admin,%10aku%10mau%10buat%10akun">Contact</a>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
