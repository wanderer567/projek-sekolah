@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div x-data="attendanceApp()" class="min-h-screen bg-gray-50/50 p-4 md:p-8">
    
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Absensi</h2>
                <p class="text-gray-500 mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    Periode Aktif: <span class="font-semibold text-indigo-600" x-text="currentPeriod"></span>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" x-model="search" placeholder="Cari nama siswa..."
                        class="w-full md:w-72 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-2 bg-white text-red-500 border border-red-100 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-50 transition-all shadow-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                <div class="p-2 bg-blue-50 text-blue-500 rounded-lg"><i class="fas fa-users"></i></div>
            </div>
            <p class="text-3xl font-bold text-gray-900" x-text="totalSiswa"></p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-green-600">Hadir</p>
                <div class="p-2 bg-green-50 text-green-500 rounded-lg"><i class="fas fa-check-circle"></i></div>
            </div>
            <p class="text-3xl font-bold text-gray-900" x-text="countHadir"></p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-orange-500">Izin/Sakit</p>
                <div class="p-2 bg-orange-50 text-orange-500 rounded-lg"><i class="fas fa-envelope-open-text"></i></div>
            </div>
            <p class="text-3xl font-bold text-gray-900" x-text="countSakitIzin"></p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 transition-transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-red-500">Alpa</p>
                <div class="p-2 bg-red-50 text-red-500 rounded-lg"><i class="fas fa-times-circle"></i></div>
            </div>
            <p class="text-3xl font-bold text-gray-900" x-text="countAlpa"></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h3 class="text-lg font-bold text-gray-800">Daftar Kehadiran Siswa</h3>

            <div class="flex items-center bg-gray-100 p-1 rounded-xl">
                <button @click="currentPeriod = 'Hari Ini'" 
                    :class="currentPeriod === 'Hari Ini' ? 'bg-white shadow text-indigo-600' : 'text-gray-500'"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all">Hari Ini</button>
                <button @click="currentPeriod = 'Minggu Ini'" 
                    :class="currentPeriod === 'Minggu Ini' ? 'bg-white shadow text-indigo-600' : 'text-gray-500'"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all">Minggu Ini</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Nama Siswa</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Waktu Absen</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    <template x-for="(student, index) in filteredStudents" :key="index">
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs" x-text="student.name.charAt(0)"></div>
                                    <span class="font-medium text-gray-700" x-text="student.name"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-mono text-gray-500 bg-gray-100 px-2 py-1 rounded" x-text="student.time"></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                                    :class="{
                                        'bg-green-100 text-green-700': student.status=='Hadir',
                                        'bg-amber-100 text-amber-700': student.status=='Sakit' || student.status=='Izin',
                                        'bg-red-100 text-red-700': student.status=='Alpa'
                                    }">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="{
                                        'bg-green-500': student.status=='Hadir',
                                        'bg-amber-500': student.status=='Sakit' || student.status=='Izin',
                                        'bg-red-500': student.status=='Alpa'
                                    }"></span>
                                    <span x-text="student.status"></span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal(student)"
                                        class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteStudent(student.name)"
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <tr x-show="filteredStudents.length === 0">
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-folder-open text-4xl mb-3"></i>
                                <p>Data tidak ditemukan...</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="isModalOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
        style="display:none">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" @click.away="isModalOpen = false">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Absensi</h3>
                <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Siswa</label>
                    <input type="text" x-model="editingStudent.name"
                        class="w-full border bg-gray-50 border-gray-200 p-2.5 rounded-xl text-gray-500" readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kehadiran</label>
                    <select x-model="editingStudent.status"
                        class="w-full border border-gray-200 p-2.5 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <option>Hadir</option>
                        <option>Sakit</option>
                        <option>Izin</option>
                        <option>Alpa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu (Opsional)</label>
                    <input type="text" x-model="editingStudent.time"
                        class="w-full border border-gray-200 p-2.5 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        placeholder="Contoh: 07:30">
                </div>
            </div>

            <div class="p-6 bg-gray-50 flex justify-end gap-3">
                <button @click="isModalOpen=false"
                    class="px-5 py-2 text-gray-600 font-semibold hover:bg-gray-200 rounded-xl transition-all">
                    Batal
                </button>
                <button @click="saveChanges"
                    class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Script tetap sama, hanya beberapa penyesuaian kecil untuk konsistensi UI
function attendanceApp() {
    return {
        search: '',
        currentPeriod: 'Hari Ini',
        isModalOpen: false,
        students: JSON.parse(localStorage.getItem('absensi')) || [],
        editingStudent: {},

        init() {
            window.addEventListener('storage', () => {
                this.students = JSON.parse(localStorage.getItem('absensi')) || [];
            });
        },

        get totalSiswa() { return this.students.length; },
        get countHadir() { return this.students.filter(s => s.status === 'Hadir').length; },
        get countSakitIzin() { return this.students.filter(s => ['Sakit','Izin'].includes(s.status)).length; },
        get countAlpa() { return this.students.filter(s => s.status === 'Alpa').length; },

        get filteredStudents() {
            let filtered = this.students;
            if (this.search) {
                filtered = filtered.filter(s => s.name.toLowerCase().includes(this.search.toLowerCase()));
            }
            return filtered;
        },

        openEditModal(student) {
            this.editingStudent = JSON.parse(JSON.stringify(student));
            this.isModalOpen = true;
        },

        saveChanges() {
            let index = this.students.findIndex(s => s.name === this.editingStudent.name);
            if (index !== -1) {
                if(['Sakit','Izin','Alpa'].includes(this.editingStudent.status) && (!this.editingStudent.time || this.editingStudent.time === '-')) {
                    this.editingStudent.time = '-';
                }
                this.students[index] = this.editingStudent;
            }
            localStorage.setItem('absensi', JSON.stringify(this.students));
            this.isModalOpen = false;
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data absensi telah diperbarui.',
                timer: 1500,
                showConfirmButton: false,
                borderRadius: '1rem'
            });
        },

        deleteStudent(name) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(res => {
                if (res.isConfirmed) {
                    this.students = this.students.filter(s => s.name !== name);
                    localStorage.setItem('absensi', JSON.stringify(this.students));
                    Swal.fire('Terhapus!', 'Data siswa telah dihapus.', 'success');
                }
            });
        }
    }
}
</script>
@endsection