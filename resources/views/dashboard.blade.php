@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="attendanceApp()" class="min-h-screen p-4">

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Ringkasan Statistik</h2>
            <p class="text-indigo-600 font-medium mt-1">
                <i class="fas fa-calendar-alt mr-1"></i> 
                Periode: <span x-text="currentPeriod"></span>
            </p>
        </div>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
                <input type="text" x-model="search" placeholder="Cari nama siswa..." 
                    class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 shadow-sm">
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-bold transition active:scale-95 shadow-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="totalSiswa"></p>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Hadir</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="countHadir"></p>
            </div>
            <div class="p-3 bg-green-50 rounded-xl text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Izin / Sakit</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="countSakitIzin"></p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600">
                <i class="fas fa-file-medical text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Alpa</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="countAlpa"></p>
            </div>
            <div class="p-3 bg-red-50 rounded-xl text-red-600">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-700 text-lg">Detail Absensi Siswa</h3>
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold flex items-center hover:bg-indigo-50 transition shadow-sm">
                    <i class="fas fa-filter mr-2"></i> 
                    <span x-text="currentPeriod"></span>
                    <i class="fas fa-chevron-down ml-2 text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl z-50 overflow-hidden">
                    <a href="#" @click.prevent="currentPeriod = 'Hari Ini'; open = false" class="block px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50">Hari Ini</a>
                    <a href="#" @click.prevent="currentPeriod = 'Minggu Ini'; open = false" class="block px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50">Minggu Ini</a>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Siswa</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <template x-for="(student, index) in filteredStudents" :key="index">
                        <tr class="hover:bg-indigo-50/30 transition duration-150 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs mr-3 shadow-sm" x-text="student.name.charAt(0)"></div>
                                    <div>
                                        <p class="font-bold text-gray-800" x-text="student.name"></p>
                                        <p class="text-xs text-gray-400">NIS: 123456</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-gray-600" x-text="student.time"></td>
                            <td class="px-6 py-4">
                                <span :class="{
                                    'bg-green-100 text-green-700 border-green-200': student.status === 'Hadir',
                                    'bg-yellow-100 text-yellow-700 border-yellow-200': student.status === 'Sakit' || student.status === 'Izin',
                                    'bg-red-100 text-red-700 border-red-200': student.status === 'Alpa'
                                }" class="px-3 py-1 rounded-full text-[11px] font-bold uppercase border tracking-wide" x-text="student.status"></span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 italic" x-text="student.note"></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <button @click="openEditModal(student)" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition"><i class="fas fa-edit"></i></button>
                                    <button @click="deleteStudent(student.name)" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="isModalOpen" style="display: none;" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
         x-transition.opacity>
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all"
             @click.away="isModalOpen = false">
            
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg">Edit Absensi</h3>
                <button @click="isModalOpen = false" class="text-indigo-200 hover:text-white transition"><i class="fas fa-times"></i></button>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa</label>
                    <input type="text" x-model="editingStudent.name" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 text-gray-500 cursor-not-allowed" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
                    <select x-model="editingStudent.status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                        <option value="Hadir">Hadir</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alpa">Alpa</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Masuk</label>
                    <input type="text" x-model="editingStudent.time" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                <button @click="isModalOpen = false" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-100">Batal</button>
                <button @click="saveChanges()" class="px-4 py-2 text-white bg-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-700">Simpan</button>
            </div>
        </div>
    </div>

</div>

<script>
    function attendanceApp() {
        return {
            search: '',
            currentPeriod: 'Hari Ini',
            isModalOpen: false,
            students: [
                { name: 'Zaid Ali', time: '07:00', status: 'Hadir', note: 'Tepat Waktu' },
                { name: 'Budi Santoso', time: '07:15', status: 'Hadir', note: 'Terlambat 5 Menit' },
                { name: 'Siti Aminah', time: '-', status: 'Sakit', note: 'Surat Dokter' },
                { name: 'Rudi Tabuti', time: '-', status: 'Alpa', note: 'Tanpa Keterangan' },
                { name: 'Rudi Tabuti', time: '-', status: 'Alpa', note: 'Tanpa Keterangan' },
                { name: 'Rudi', time: '-', status: 'Alpa', note: 'Tanpa Keterangan' }
            ],
            editingStudent: {},
            get totalSiswa() { return this.students.length; },
            get countHadir() { return this.students.filter(s => s.status === 'Hadir').length; },
            get countSakitIzin() { return this.students.filter(s => ['Sakit', 'Izin'].includes(s.status)).length; },
            get countAlpa() { return this.students.filter(s => s.status === 'Alpa').length; },
            get filteredStudents() {
                if (this.search === '') return this.students;
                return this.students.filter(student => student.name.toLowerCase().includes(this.search.toLowerCase()));
            },
            openEditModal(student) {
                this.editingStudent = JSON.parse(JSON.stringify(student)); 
                this.isModalOpen = true;
            },
            saveChanges() {
                let index = this.students.findIndex(s => s.name === this.editingStudent.name);
                if (index !== -1) {
                    this.students[index] = this.editingStudent;
                    if(['Sakit', 'Izin', 'Alpa'].includes(this.editingStudent.status)) {
                        this.students[index].time = '-';
                    }
                }
                this.isModalOpen = false;
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                Toast.fire({ icon: 'success', title: 'Data berhasil diperbarui' });
            },
            deleteStudent(name) {
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data akan terhapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.students = this.students.filter(s => s.name !== name);
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                    }
                })
            }
        }
    }
</script>
@endsection