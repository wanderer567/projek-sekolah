@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="studentPage()">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Data Siswa</h2>
        <div class="flex gap-2">
            <button @click="openAddModal()" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-bold">
                Tambah Manual
            </button>

            <button @click="openImportModal()" class="bg-green-600 text-white px-5 py-2 rounded-lg font-bold">
                Import Excel
            </button>
        </div>
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
                    <th class="px-6 py-4 text-center">Absen</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">NISN</th>
                    <th class="px-6 py-4">Kelas</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($siswas as $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-center font-bold text-indigo-600">{{ $s->nomor_absen }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $s->nama }}</td>
                    <td class="px-6 py-4 text-gray-500 font-mono">{{ $s->nisn }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-md text-xs font-bold">
                            {{ $s->kelas }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button @click="openEditModal({{ json_encode($s) }})"
                                class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('admin.siswa.delete', $s->id) }}" method="POST" id="del-{{ $s->id }}">
                                @csrf @method('DELETE')
                                <button type="button" @click="confirmDelete({{ $s->id }})"
                                    class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-400 italic">Database kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL TAMBAH / EDIT -->
    <div x-show="isModalOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" @click.away="isModalOpen = false">
            <div class="bg-indigo-900 p-4 text-white flex justify-between items-center">
                <h3 class="font-bold" x-text="isEdit ? 'Edit Data Siswa' : 'Tambah Siswa Baru'"></h3>
                <button @click="isModalOpen = false"><i class="fas fa-times"></i></button>
            </div>

            <form :action="isEdit ? '/admin/data-siswa/' + formData.id : '{{ route('admin.siswa.store') }}'"
                  method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="formData.nama" required
                        class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">NISN</label>
                        <input type="text" name="nisn" x-model="formData.nisn" required
                            class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase">No Absen</label>
                        <input type="number" name="nomor_absen" x-model="formData.nomor_absen" required
                            class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase">Kelas</label>
                    <select name="kelas" x-model="formData.kelas" required
                        class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Pilih Kelas</option>
                        <option value="X-RPL">X-RPL</option>
                        <option value="XI-RPL">XI-RPL</option>
                        <option value="XII-RPL">XII-RPL</option>
                    </select>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="button" @click="isModalOpen = false"
                        class="flex-1 bg-gray-100 text-gray-600 font-bold py-3 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL IMPORT -->
    <div x-show="isImportOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         style="display: none;"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" @click.away="isImportOpen = false">
            <h3 class="font-bold text-lg mb-4">Import Data Siswa</h3>

            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" required class="mb-4 w-full border p-2 rounded">

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded w-full">
                    Upload & Import
                </button>
            </form>

            <button @click="isImportOpen = false" class="mt-3 text-sm text-gray-500">
                Batal
            </button>
        </div>
    </div>

</div>
<div class="mb-4">
    <form method="GET" action="{{ route('admin.data-siswa') }}">
        <select name="kelas" onchange="this.form.submit()" 
            class="border p-2 rounded-lg">
            
            <option value="">Semua Kelas</option>
            <option value="X-RPL" {{ request('kelas') == 'X-RPL' ? 'selected' : '' }}>X-RPL</option>
            <option value="XI-RPL" {{ request('kelas') == 'XI-RPL' ? 'selected' : '' }}>XI-RPL</option>
            <option value="XII-RPL" {{ request('kelas') == 'XII-RPL' ? 'selected' : '' }}>XII-RPL</option>
        
        </select>
    </form>
</div>
<script>
function studentPage() {
    return {
        isModalOpen: false,
        isImportOpen: false,
        isEdit: false,
        formData: { id: '', nama: '', nisn: '', kelas: '', nomor_absen: '' },

        openAddModal() {
            this.isEdit = false;
            this.formData = { id: '', nama: '', nisn: '', kelas: '', nomor_absen: '' };
            this.isModalOpen = true;
        },

        openEditModal(s) {
            this.isEdit = true;
            this.formData = { ...s };
            this.isModalOpen = true;
        },

        openImportModal() {
            this.isImportOpen = true;
        },

        confirmDelete(id) {
            Swal.fire({
                title: 'Hapus data siswa?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
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