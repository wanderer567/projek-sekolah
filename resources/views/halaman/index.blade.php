
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sistem Absensi Siswa') }}
            </h2>
            <span class="text-sm text-gray-500 font-medium">
                Hari ini: <span class="font-bold text-indigo-600">{{ date('d M Y') }}</span>
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Siswa</p>
                            <p class="text-2xl font-bold">36</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Hadir</p>
                            <p class="text-2xl font-bold text-green-600">32</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Izin/Sakit</p>
                            <p class="text-2xl font-bold text-yellow-600">3</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Alpa</p>
                            <p class="text-2xl font-bold text-red-600">1</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">Daftar Absensi Kelas XII-RPL</h3>
                    <div class="flex space-x-2">
                        <input type="text" placeholder="Cari nama..." class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500">
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                            + Absen Baru
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">No</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Siswa</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">NISN</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Waktu</th>
                                <th class="px-6 py-4 atext-xs font-bold text-gray-500 uppercase text-center">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">01</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">Ahmad Subardjo</td>
                                <td class="px-6 py-4 text-sm text-gray-500">0012345678</td>
                                <td class="px-6 py-4 text-sm text-gray-500">07:02:15</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">HADIR</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-indigo-600 font-semibold text-xs hover:underline">Edit</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">02</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">Bella Safira</td>
                                <td class="px-6 py-4 text-sm text-gray-500">0012345679</td>
                                <td class="px-6 py-4 text-sm text-gray-500">07:05:00</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">HADIR</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-indigo-600 font-semibold text-xs hover:underline">Edit</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">03</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">Candra Wijaya</td>
                                <td class="px-6 py-4 text-sm text-gray-500">0012345680</td>
                                <td class="px-6 py-4 text-sm text-gray-500">--:--</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">SAKIT</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-indigo-600 font-semibold text-xs hover:underline">Edit</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-600">04</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">Dodi Mulyanto</td>
                                <td class="px-6 py-4 text-sm text-gray-500">0012345681</td>
                                <td class="px-6 py-4 text-sm text-gray-500">--:--</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">ALPA</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-indigo-600 font-semibold text-xs hover:underline">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 flex justify-between items-center">
                    <span>Menampilkan 4 dari 36 siswa</span>
                    <div class="flex space-x-1">
                        <button class="px-2 py-1 bg-white border rounded shadow-sm hover:bg-gray-100">Prev</button>
                        <button class="px-2 py-1 bg-indigo-600 text-white border rounded shadow-sm">1</button>
                        <button class="px-2 py-1 bg-white border rounded shadow-sm hover:bg-gray-100">2</button>
                        <button class="px-2 py-1 bg-white border rounded shadow-sm hover:bg-gray-100">Next</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ini halaman utama</h1>
</body>
</html>
>>>>>>> 9ec3fce8091d2ce9447f042a0648bd5ef7ffc9c0
