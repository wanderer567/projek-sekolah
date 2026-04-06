@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="attendanceApp()" class="min-h-screen p-4">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Absensi</h2>
            <p class="text-indigo-500 text-sm">
                Periode: <span x-text="currentPeriod"></span>
            </p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <input type="text" x-model="search" placeholder="Cari nama siswa..."
                class="w-full md:w-64 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-2xl font-bold" x-text="totalSiswa"></p>
        </div>

        <div class="bg-green-50 p-4 rounded-xl shadow">
            <p class="text-xs text-green-500">Hadir</p>
            <p class="text-2xl font-bold text-green-600" x-text="countHadir"></p>
        </div>

        <div class="bg-yellow-50 p-4 rounded-xl shadow">
            <p class="text-xs text-yellow-500">Izin/Sakit</p>
            <p class="text-2xl font-bold text-yellow-600" x-text="countSakitIzin"></p>
        </div>

        <div class="bg-red-50 p-4 rounded-xl shadow">
            <p class="text-xs text-red-500">Alpa</p>
            <p class="text-2xl font-bold text-red-600" x-text="countAlpa"></p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold">Data Absensi</h3>

            <select x-model="currentPeriod"
                class="border rounded-lg px-3 py-1 text-sm">
                <option>Hari Ini</option>
                <option>Minggu Ini</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Waktu</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Keterangan</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <template x-for="(student, index) in filteredStudents" :key="index">
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3 font-semibold" x-text="student.name"></td>
                            <td class="p-3 font-mono" x-text="student.time"></td>

                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-bold"
                                    :class="{
                                        'bg-green-100 text-green-600': student.status=='Hadir',
                                        'bg-yellow-100 text-yellow-600': student.status=='Sakit' || student.status=='Izin',
                                        'bg-red-100 text-red-600': student.status=='Alpa'
                                    }"
                                    x-text="student.status">
                                </span>
                            </td>

                            <td class="p-3 text-gray-500" x-text="student.note"></td>

                            <td class="p-3 text-center">
                                <button @click="openEditModal(student)"
                                    class="text-indigo-500 hover:text-indigo-700 mr-2">
                                    Edit
                                </button>

                                <button @click="deleteStudent(student.name)"
                                    class="text-red-500 hover:text-red-700">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </template>

                    <!-- EMPTY STATE -->
                    <tr x-show="students.length === 0">
                        <td colspan="5" class="text-center py-6 text-gray-400">
                            Belum ada data absensi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div x-show="isModalOpen" style="display:none"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

        <div class="bg-white p-6 rounded-xl w-full max-w-md">
            <h3 class="font-bold mb-4">Edit Absensi</h3>

            <input type="text" x-model="editingStudent.name"
                class="w-full border p-2 rounded mb-3" readonly>

            <select x-model="editingStudent.status"
                class="w-full border p-2 rounded mb-3">
                <option>Hadir</option>
                <option>Sakit</option>
                <option>Izin</option>
                <option>Alpa</option>
            </select>

            <input type="text" x-model="editingStudent.time"
                class="w-full border p-2 rounded mb-3">

            <div class="flex justify-end gap-2">
                <button @click="isModalOpen=false"
                    class="px-3 py-1 border rounded">Batal</button>

                <button @click="saveChanges"
                    class="px-3 py-1 bg-indigo-600 text-white rounded">
                    Simpan
                </button>
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

        students: JSON.parse(localStorage.getItem('absensi')) || [],
        editingStudent: {},

        // AUTO SYNC
        init() {
            window.addEventListener('storage', () => {
                this.students = JSON.parse(localStorage.getItem('absensi')) || [];
            });
        },

        // STAT
        get totalSiswa() {
            return this.students.length;
        },

        get countHadir() {
            return this.students.filter(s => s.status === 'Hadir').length;
        },

        get countSakitIzin() {
            return this.students.filter(s => ['Sakit','Izin'].includes(s.status)).length;
        },

        get countAlpa() {
            return this.students.filter(s => s.status === 'Alpa').length;
        },

        // SEARCH
        get filteredStudents() {
            if (!this.search) return this.students;
            return this.students.filter(s =>
                s.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },

        // EDIT
        openEditModal(student) {
            this.editingStudent = JSON.parse(JSON.stringify(student));
            this.isModalOpen = true;
        },

        saveChanges() {
            let index = this.students.findIndex(s => s.name === this.editingStudent.name);

            if (index !== -1) {
                this.students[index] = this.editingStudent;

                if(['Sakit','Izin','Alpa'].includes(this.editingStudent.status)) {
                    this.students[index].time = '-';
                }
            }

            localStorage.setItem('absensi', JSON.stringify(this.students));
            this.isModalOpen = false;

            Swal.fire('Berhasil','Data diperbarui','success');
        },

        // DELETE
        deleteStudent(name) {
            Swal.fire({
                title: 'Hapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33'
            }).then(res => {
                if (res.isConfirmed) {
                    this.students = this.students.filter(s => s.name !== name);
                    localStorage.setItem('absensi', JSON.stringify(this.students));
                    Swal.fire('Terhapus','Data dihapus','success');
                }
            });
        }
    }
}
</script>
@endsection