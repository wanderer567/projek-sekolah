@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="attendanceManual()" class="min-h-screen p-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Absen Manual</h2>
            <p class="text-indigo-500 text-sm">Input kehadiran siswa secara manual</p>
            <p class="text-sm text-gray-500">
                Jam sekarang: <span x-text="getCurrentTime()"></span>
            </p>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-2xl font-bold" x-text="students.length"></p>
        </div>
        <div class="bg-green-50 p-4 rounded-xl shadow">
            <p class="text-xs text-green-500">Hadir</p>
            <p class="text-2xl font-bold text-green-600" x-text="count('Hadir')"></p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-xl shadow">
            <p class="text-xs text-yellow-500">Izin/Sakit</p>
            <p class="text-2xl font-bold text-yellow-600" x-text="countMulti(['Izin','Sakit'])"></p>
        </div>
        <div class="bg-red-50 p-4 rounded-xl shadow">
            <p class="text-xs text-red-500">Alpa</p>
            <p class="text-2xl font-bold text-red-600" x-text="count('Alpa')"></p>
        </div>
    </div>

    <!-- FORM -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <h3 class="font-bold mb-4">Input Absensi</h3>

        <div class="grid md:grid-cols-3 gap-4">
            <input x-model="form.name" type="text" placeholder="Nama Siswa"
                class="border rounded-lg p-2">

            <select x-model="form.status" class="border rounded-lg p-2">
                <option>Hadir</option>
                <option>Sakit</option>
                <option>Izin</option>
                <option>Alpa</option>
            </select>

            <input x-model="form.note" type="text" placeholder="Keterangan"
                class="border rounded-lg p-2">
        </div>

        <button @click="submitData"
            class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Simpan
        </button>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b font-bold">Data Absensi</div>

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
                <template x-for="(item, index) in students" :key="index">
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-semibold" x-text="item.name"></td>
                        <td class="p-3" x-text="item.time"></td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-bold"
                                :class="{
                                    'bg-green-100 text-green-600': item.status=='Hadir',
                                    'bg-yellow-100 text-yellow-600': item.status=='Sakit' || item.status=='Izin',
                                    'bg-red-100 text-red-600': item.status=='Alpa'
                                }"
                                x-text="item.status">
                            </span>
                        </td>
                        <td class="p-3" x-text="item.note"></td>
                        <td class="p-3 text-center">
                            <button @click="deleteData(index)"
                                class="text-red-500 hover:text-red-700">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
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

        // 🔥 ambil jam realtime
        getCurrentTime() {
            let now = new Date();
            let hours = String(now.getHours()).padStart(2, '0');
            let minutes = String(now.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        },

        submitData() {
            if (!this.form.name) {
                Swal.fire('Error','Nama wajib diisi','error')
                return;
            }

            let currentTime = this.getCurrentTime();

            let data = {
                name: this.form.name,
                status: this.form.status,
                time: this.form.status === 'Hadir' ? currentTime : '-',
                note: this.form.note || '-'
            };

            this.students.push(data);
            localStorage.setItem('absensi', JSON.stringify(this.students));

            Swal.fire('Berhasil','Data ditambahkan','success');

            this.form = { name:'', status:'Hadir', note:'' };
        },

        deleteData(index) {
            this.students.splice(index,1);
            localStorage.setItem('absensi', JSON.stringify(this.students));
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