@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div x-data="attendanceManual()" class="min-h-screen bg-gray-50/50 p-4 md:p-8">

    <div class="max-w-7xl mx-auto mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Absen Manual</h2>
            <p class="text-gray-500 mt-1 flex items-center gap-2">
                <i class="fas fa-keyboard text-indigo-500"></i>
                Input kehadiran siswa secara mandiri
            </p>
        </div>
        <div class="bg-indigo-600 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-200 flex items-center gap-3">
            <i class="fas fa-clock animate-pulse"></i>
            <div>
                <p class="text-[10px] uppercase tracking-wider opacity-80 leading-none">Jam Sekarang</p>
                <p class="text-lg font-bold leading-none mt-1" x-text="getCurrentTime()"></p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-medium text-gray-500 mb-1">Total Input</p>
            <p class="text-3xl font-bold text-gray-900" x-text="students.length"></p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-medium text-green-600 mb-1">Hadir</p>
            <p class="text-3xl font-bold text-gray-900" x-text="count('Hadir')"></p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-medium text-orange-500 mb-1">Izin/Sakit</p>
            <p class="text-3xl font-bold text-gray-900" x-text="countMulti(['Izin','Sakit'])"></p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-medium text-red-500 mb-1">Alpa</p>
            <p class="text-3xl font-bold text-gray-900" x-text="count('Alpa')"></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-plus"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Formulir Input Data</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-600 ml-1">Nama Siswa</label>
                <input x-model="form.name" type="text" placeholder="Masukkan nama lengkap"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition-all">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-600 ml-1">Status</label>
                <select x-model="form.status" 
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition-all appearance-none cursor-pointer">
                    <option>Hadir</option>
                    <option>Sakit</option>
                    <option>Izin</option>
                    <option>Alpa</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-600 ml-1">Keterangan (Opsional)</label>
                <input x-model="form.note" type="text" placeholder="Catatan tambahan"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition-all">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button @click="submitData"
                class="w-full md:w-auto px-10 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                <i class="fas fa-save mr-2"></i> Simpan Data Kehadiran
            </button>
        </div>
    </div>

    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list text-indigo-500"></i>
                Riwayat Input Manual
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Nama Siswa</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Waktu</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Keterangan</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(item, index) in students" :key="index">
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs" x-text="item.name.charAt(0)"></div>
                                    <span class="font-medium text-gray-700" x-text="item.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-mono text-gray-500 bg-gray-100 px-2 py-1 rounded" x-text="item.time"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                                    :class="{
                                        'bg-green-100 text-green-700': item.status=='Hadir',
                                        'bg-amber-100 text-amber-700': item.status=='Sakit' || item.status=='Izin',
                                        'bg-red-100 text-red-700': item.status=='Alpa'
                                    }">
                                    <span x-text="item.status"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 italic text-sm" x-text="item.note"></td>
                            <td class="px-6 py-4 text-center">
                                <button @click="deleteData(index)"
                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="students.length === 0">
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                Belum ada data yang dimasukkan.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function attendanceManual() {
    return {
        form: {
            name: '',
            status: 'Hadir',
            note: ''
        },

        students: JSON.parse(localStorage.getItem('absensi')) || [],

        getCurrentTime() {
            let now = new Date();
            return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        },

        submitData() {
            if (!this.form.name) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nama siswa tidak boleh kosong!',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            let data = {
                name: this.form.name,
                status: this.form.status,
                time: this.form.status === 'Hadir' ? this.getCurrentTime() : '-',
                note: this.form.note || '-'
            };

            this.students.push(data);
            localStorage.setItem('absensi', JSON.stringify(this.students));

            Swal.fire({
                icon: 'success',
                title: 'Tersimpan!',
                text: 'Data absensi berhasil ditambahkan.',
                timer: 1500,
                showConfirmButton: false
            });

            this.form = { name:'', status:'Hadir', note:'' };
        },

        deleteData(index) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: "Data akan dihapus permanen dari memori lokal.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.students.splice(index, 1);
                    localStorage.setItem('absensi', JSON.stringify(this.students));
                    Swal.fire('Terhapus!', 'Data telah dihapus.', 'success');
                }
            })
        },

        count(status) {
            return this.students.filter(s => s.status === status).length;
        },

        countMulti(arr) {
            return this.students.filter(s => arr.includes(s.status)).length;
        }
    }
}
</script>
@endsection