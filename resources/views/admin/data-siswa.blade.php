@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div x-data="studentPage()" class="p-2 md:p-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Siswa</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola informasi peserta didik dan QR Code kehadiran.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.data-siswa') }}" class="flex-1 md:flex-none">
                <select name="kelas" onchange="this.form.submit()" 
                    class="w-full border-gray-200 rounded-xl text-sm font-semibold focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @foreach(['X-RPL', 'XI-RPL', 'XII-RPL'] as $kls)
                        <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </form>

            <!-- <button @click="openImportModal()" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-emerald-50 text-emerald-700 border border-emerald-100 px-4 py-2.5 rounded-xl font-bold hover:bg-emerald-100 transition-all">
                <i class="fas fa-file-excel"></i> Import
            </button> -->

            <button @click="openAddModal()" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                <i class="fas fa-plus"></i> Tambah Siswa
            </button>
        </div>
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
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-5 text-center">Absen</th>
                        <th class="px-6 py-5">Identitas Siswa</th>
                        <th class="px-6 py-5">NISN</th>
                        <th class="px-6 py-5">Kelas</th>
                        <th class="px-6 py-5 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($siswas as $s)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-sm border border-indigo-100">
                                {{ $s->nomor_absen }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr($s->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 leading-tight">{{ $s->nama }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium">Siswa Aktif</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-mono text-sm tracking-tight">{{ $s->nisn }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-white border border-gray-200 text-gray-600 px-3 py-1 rounded-full text-[10px] font-black tracking-wide shadow-sm">
                                {{ $s->kelas }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button @click="generateQR('{{ $s->code_qr_siswa }}', '{{ $s->nama }}', '{{ $s->kelas }}', '{{ $s->nisn }}')"
                                    class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm"
                                    title="Generate QR">
                                    <i class="fas fa-qrcode"></i>
                                </button>

                                <button @click="openEditModal({{ json_encode($s) }})"
                                    class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.siswa.delete', $s->id) }}" method="POST" id="del-{{ $s->id }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" @click="confirmDelete({{ $s->id }})"
                                        class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-20">
                            <div class="flex flex-col items-center opacity-30">
                                <i class="fas fa-database text-5xl mb-4"></i>
                                <p class="font-bold">Database Masih Kosong</p>
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

        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all" @click.away="isModalOpen = false">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-black text-gray-800 text-lg uppercase tracking-tight" x-text="isEdit ? 'Update Data' : 'Siswa Baru'"></h3>
                <button @click="isModalOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 text-gray-400 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form :action="isEdit ? '/admin/data-siswa/' + formData.id : '{{ route('admin.siswa.store') }}'"
                  method="POST" class="p-8 space-y-5">
                @csrf
                <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                <div class="space-y-1">
                    <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="formData.nama" required placeholder="Rizky Ibrahim "
                        class="w-full border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">NISN</label>
                        <input type="text" name="nisn" x-model="formData.nisn" required placeholder="001234..."
                            class="w-full border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">No Absen</label>
                        <input type="number" name="nomor_absen" x-model="formData.nomor_absen" required placeholder="01"
                            class="w-full border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[11px] font-black text-gray-400 uppercase tracking-widest ml-1">Kelas</label>
                    <select name="kelas" x-model="formData.kelas" required
                        class="w-full border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white outline-none transition-all cursor-pointer">
                        <option value="">Pilih Kelas</option>
                        <option value="X-RPL">X-RPL</option>
                        <option value="XI-RPL">XI-RPL</option>
                        <option value="XII-RPL">XII-RPL</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 text-white font-black py-4 rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 active:scale-[0.98]">
                        <i class="fas fa-check mr-2"></i> SIMPAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="isImportOpen" x-cloak
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-[2rem] p-8 w-full max-w-sm text-center" @click.away="isImportOpen = false">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm border border-emerald-100">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h3 class="font-black text-gray-800 text-xl mb-1">Import Excel</h3>
            <p class="text-sm text-gray-400 mb-6 font-medium">Pastikan format kolom sudah sesuai template.</p>

            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="relative group">
                    <input type="file" name="file" required 
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                </div>
                <button type="submit" class="w-full bg-emerald-600 text-white font-black py-3.5 rounded-2xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">
                    MULAI IMPORT
                </button>
            </form>
        </div>
    </div>

    <div x-show="isQRModalOpen" x-cloak
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 z-[1000] flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4">

        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-sm w-full overflow-hidden" @click.away="isQRModalOpen = false">
            <div class="p-8 text-center">
                <div class="flex justify-between items-center mb-6">
                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Active QR Card</span>
                    <button @click="isQRModalOpen = false" class="text-gray-300 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>

                <div class="mx-auto mb-6 p-4 bg-white rounded-3xl shadow-inner border border-gray-50 flex items-center justify-center">
                    <canvas x-ref="qrCanvas" class="rounded-xl"></canvas>
                </div>

                <div class="space-y-1 mb-8">
                    <h4 class="font-black text-2xl text-gray-800 tracking-tight" x-text="qrData.nama"></h4>
                    <p class="text-indigo-600 font-bold" x-text="qrData.kelas"></p>
                    <p class="text-gray-400 text-xs font-mono" x-text="'NISN: ' + qrData.nisn"></p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button @click="downloadQR()" 
                        class="bg-gray-900 text-white font-bold py-3.5 rounded-2xl hover:bg-black transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-download text-xs"></i> PNG
                    </button>
                    <button @click="copyQRLink()" 
                        class="bg-indigo-50 text-indigo-700 font-bold py-3.5 rounded-2xl hover:bg-indigo-100 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-copy text-xs"></i> COPY
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    /* Soft scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar { height: 6px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: transparent; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

<script>
function studentPage() {
    return {
        isModalOpen: false, isImportOpen: false, isQRModalOpen: false, isEdit: false,
        formData: { id: '', nama: '', nisn: '', kelas: '', nomor_absen: '' },
        qrData: { nama: '', nisn: '', kelas: '', code: '' },

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
        openImportModal() { this.isImportOpen = true; },
        generateQR(code, nama, kelas, nisn) {
            this.qrData = { code, nama, kelas, nisn };
            this.isQRModalOpen = true;
            this.$nextTick(() => this.createQRCode());
        },
        async createQRCode() {
            const canvas = this.$refs.qrCanvas;
            try {
                await QRCode.toCanvas(canvas, `SISWA:${this.qrData.code}`, {
                    width: 200, margin: 2, color: { dark: '#1e1b4b', light: '#ffffff' }
                });
            } catch (err) { console.error(err); }
        },
        downloadQR() {
            const link = document.createElement('a');
            link.download = `QR-${this.qrData.nisn}.png`;
            link.href = this.$refs.qrCanvas.toDataURL();
            link.click();
        },
        copyQRLink() {
            navigator.clipboard.writeText(`SISWA:${this.qrData.code}`).then(() => {
                Swal.fire({
                    icon: 'success', title: 'Data Disalin!',
                    timer: 1500, showConfirmButton: false, toast: true, position: 'top-end'
                });
            });
        },
        confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Siswa?', text: "Data ini akan dihapus permanen!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444',
                confirmButtonText: 'YA, HAPUS', borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('del-' + id).submit();
            });
        }
    }
}
</script>
@endsection