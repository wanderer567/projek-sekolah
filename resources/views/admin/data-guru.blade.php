@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="guruPage()">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Data Guru</h2>
        <button @click="openAddModal()" class="bg-emerald-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-emerald-700 shadow-lg transition">
            <i class="fas fa-plus mr-2"></i> Tambah Guru
        </button>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            borderRadius: '1rem'
        });
    </script>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-400 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">NIP</th>
                    <th class="px-6 py-4">Nama Guru</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($gurus as $g)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono text-sm text-gray-600">{{ $g->nip ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">{{ $g->name }}</div>
                        <div class="text-xs text-gray-400">{{ $g->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($g->last_seen && \Carbon\Carbon::parse($g->last_seen)->diffInMinutes(now()) < 5)
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Online
                            </span>
                        @else
                            <span class="inline-flex items-center py-1 px-3 rounded-full text-xs font-bold bg-gray-100 text-gray-400">
                                Offline
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button @click="openEditModal({{ json_encode($g) }})" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="{{ route('admin.guru.delete', $g->id) }}" method="POST" id="del-{{ $g->id }}">
                                @csrf @method('DELETE')
                                <button type="button" @click="confirmDelete({{ $g->id }})" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-10 text-gray-400 italic">Data guru kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-show="isModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;" 
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" @click.away="isModalOpen = false">
            <div class="bg-emerald-800 p-4 text-white flex justify-between items-center">
                <h3 class="font-bold" x-text="isEdit ? 'Edit Data Guru' : 'Tambah Guru Baru'"></h3>
                <button @click="isModalOpen = false"><i class="fas fa-times"></i></button>
            </div>

            <form :action="isEdit ? '/admin/data-guru/' + formData.id : '{{ route('admin.guru.store') }}'" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Nama Lengkap</label>
                    <input type="text" name="name" x-model="formData.name" required class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">NIP</label>
                    <input type="text" name="nip" x-model="formData.nip" required class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Email</label>
                    <input type="email" name="email" x-model="formData.email" required class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Password <span x-show="isEdit" class="lowercase text-[10px] text-gray-400">(Kosongkan jika tidak ganti)</span></label>
                    <input type="password" name="password" :required="!isEdit" class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="button" @click="isModalOpen = false" class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 rounded-lg hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="flex-1 bg-emerald-600 text-white font-bold py-3 rounded-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function guruPage() {
        return {
            isModalOpen: false, 
            isEdit: false,
            formData: { id: '', name: '', nip: '', email: '' },

            openAddModal() { 
                this.isEdit = false; 
                this.formData = { id: '', name: '', nip: '', email: '' }; 
                this.isModalOpen = true; 
            },

            openEditModal(g) { 
                this.isEdit = true; 
                this.formData = { ...g }; 
                this.isModalOpen = true; 
            },

            confirmDelete(id) {
                Swal.fire({
                    title: 'Hapus data guru?',
                    text: "Akun guru akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    borderRadius: '1rem'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            didOpen: () => { Swal.showLoading() },
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                        document.getElementById('del-' + id).submit();
                    }
                });
            }
        }
    }
</script>
@endsection