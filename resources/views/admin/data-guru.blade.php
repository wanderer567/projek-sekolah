@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div x-data="guruPage()" class="p-2 md:p-4">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Guru</h2>
            <p class="text-gray-500 text-sm mt-1 flex items-center gap-2">
                <i class="fas fa-chalkboard-teacher text-emerald-500"></i>
                Manajemen akun dan hak akses tenaga pengajar.
            </p>
        </div>
        
        <button @click="openAddModal()" 
            class="flex items-center justify-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all active:scale-95 w-full md:w-auto">
            <i class="fas fa-user-plus"></i> Tambah Guru
        </button>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}",
            showConfirmButton: false, timer: 2000, borderRadius: '1.5rem'
        });
    </script>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden transition-all">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-black tracking-[0.1em]">
                    <tr>
                        <th class="px-6 py-5">Identitas Guru</th>
                        <th class="px-6 py-5">NIP</th>
                        <th class="px-6 py-5 text-center">Status Akun</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($gurus as $g)
                    <tr class="hover:bg-emerald-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ strtoupper(substr($g->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 leading-tight">{{ $g->name }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium mt-1">{{ $g->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-mono text-gray-600 bg-gray-100 px-2 py-1 rounded-lg border border-gray-200">
                                {{ $g->nip ?? '--------' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($g->last_seen && \Carbon\Carbon::parse($g->last_seen)->diffInMinutes(now()) < 5)
                                <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-50 text-green-600 border border-green-100">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Online
                                </span>
                            @else
                                <span class="inline-flex items-center py-1.5 px-4 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-50 text-gray-400 border border-gray-100">
                                    Offline
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button @click="openEditModal({{ json_encode($g) }})" 
                                    class="p-2.5 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <form action="{{ route('admin.guru.delete', $g->id) }}" method="POST" id="del-{{ $g->id }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" @click="confirmDelete({{ $g->id }})" 
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-20">
                            <div class="flex flex-col items-center opacity-30">
                                <i class="fas fa-user-tie text-5xl mb-4"></i>
                                <p class="font-bold">Belum ada data guru terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="isModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all" @click.away="isModalOpen = false">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-black text-gray-800 text-lg uppercase tracking-tight" x-text="isEdit ? 'Update Akun Guru' : 'Daftarkan Guru'"></h3>
                <button @click="isModalOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 text-gray-400 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form :action="isEdit ? '/admin/data-guru/' + formData.id : '{{ route('admin.guru.store') }}'" method="POST" class="p-8 space-y-5">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>
                
                <div class="space-y-1">
                    <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" x-model="formData.name" required placeholder="Gelar & Nama Lengkap"
                        class="w-full border-gray-200 bg-gray-50 rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" x-model="formData.nip" required placeholder="19XXXXXXXX XXXXXX"
                        class="w-full border-gray-200 bg-gray-50 rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Alamat Email</label>
                    <input type="email" name="email" x-model="formData.email" required placeholder="nama@sekolah.id"
                        class="w-full border-gray-200 bg-gray-50 rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">
                        Password <span x-show="isEdit" class="lowercase font-medium text-gray-300">(Kosongkan jika tetap)</span>
                    </label>
                    <input type="password" name="password" :required="!isEdit" placeholder="••••••••"
                        class="w-full border-gray-200 bg-gray-50 rounded-2xl p-4 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 focus:bg-white outline-none transition-all">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                        class="w-full bg-emerald-600 text-white font-black py-4 rounded-2xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200 active:scale-[0.98]">
                        <i class="fas fa-save mr-2"></i> SIMPAN DATA GURU
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

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
                    title: 'Hapus Akun Guru?',
                    text: "Guru yang dihapus tidak dapat lagi mengakses sistem absensi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'YA, HAPUS',
                    borderRadius: '1.5rem',
                    customClass: {
                        title: 'font-bold text-gray-800',
                        confirmButton: 'font-black uppercase tracking-wider'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('del-' + id).submit();
                    }
                });
            }
        }
    }
</script>
@endsection