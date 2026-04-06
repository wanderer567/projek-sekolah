@extends('layouts.app')

@section('content')
<div class="p-0">
    <title>E-ABSEN - Absen QR Scanner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
        
        @keyframes flashEffect {
            0% { opacity: 0.8; background: white; }
            100% { opacity: 0; background: transparent; }
        }
        .flash-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            pointer-events: none;
            z-index: 50;
        }
        .font-nunito { font-family: 'Nunito', sans-serif; }
    </style>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 font-nunito">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#2D336B]">E-ABSEN SCANNER</h1>
                <div class="flex items-center text-[#175E92] mt-1 font-semibold text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>Hari Ini: <span id="current-date"></span></span>
                </div>
            </div>
            
            <div class="relative w-full md:w-64">
                <input type="text" id="search-siswa" placeholder="Cari nama di tabel..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border-none shadow-sm focus:ring-2 focus:ring-[#175E92] focus:outline-none text-sm bg-white">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 flex justify-between items-center transform hover:-translate-y-1 transition-all">
                <div>
                    <div class="text-xs font-bold text-gray-400 uppercase mb-1">Total Scan</div>
                    <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ count($absensis) }}</div>
                </div>
                <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-500">
                    <i class="fas fa-users text-lg"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 flex justify-between items-center transform hover:-translate-y-1 transition-all">
                <div>
                    <div class="text-xs font-bold text-gray-400 uppercase mb-1">Hadir</div>
                    <div class="text-2xl font-bold text-gray-800" id="stat-hadir">{{ $absensis->where('status', 'HADIR')->count() }}</div>
                </div>
                <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center text-green-500">
                    <i class="fas fa-check-circle text-lg"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 flex justify-between items-center transform hover:-translate-y-1 transition-all">
                <div>
                    <div class="text-xs font-bold text-gray-400 uppercase mb-1">Terlambat</div>
                    <div class="text-2xl font-bold text-gray-800" id="stat-alpa">{{ $absensis->where('status', 'TERLAMBAT')->count() }}</div>
                </div>
                <div class="h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center text-red-500">
                    <i class="fas fa-clock text-lg"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#2D336B] flex justify-between items-center transform hover:-translate-y-1 transition-all">
                <div>
                    <div class="text-xs font-bold text-gray-400 uppercase mb-1">Siswa Terdaftar</div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Siswa::count() }}</div>
                </div>
                <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-[#2D336B]">
                    <i class="fas fa-id-card text-lg"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-6">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="font-bold text-gray-700 flex items-center">
                            <i class="fas fa-qrcode mr-2 text-[#175E92]"></i> Scan QR Code
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="relative rounded-lg overflow-hidden bg-black aspect-square shadow-inner border-2 border-gray-100">
                            <div id="reader" class="w-full h-full object-cover"></div>
                            <div id="flash" class="flash-overlay"></div>
                            
                            <div class="absolute inset-0 border-[30px] border-black/30 pointer-events-none flex items-center justify-center">
                                <div class="w-48 h-48 border-2 border-white/50 rounded-lg relative">
                                    <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-green-400 -mt-1 -ml-1"></div>
                                    <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-green-400 -mt-1 -mr-1"></div>
                                    <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-green-400 -mb-1 -ml-1"></div>
                                    <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-green-400 -mb-1 -mr-1"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex gap-2">
                            <button onclick="startScanner()" id="btn-start" class="flex-1 bg-[#2D336B] hover:bg-[#175E92] text-white font-bold py-3 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-camera"></i> Mulai Scan
                            </button>
                            <button onclick="stopScanner()" id="btn-stop" class="hidden flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-stop-circle"></i> Stop
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-400 text-center mt-3">Sistem akan otomatis memotret wajah saat scan</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm h-full flex flex-col">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800">Log Absensi Live</h3>
                        <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded animate-pulse">AKTIF</span>
                    </div>

                    <div class="flex-1 overflow-auto p-2">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-4">Siswa</th>
                                    <th class="px-6 py-4">Waktu</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4">Bukti Foto</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50" id="attendance-list">
                                @forelse($absensis as $a)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-full bg-indigo-50 text-[#175E92] flex items-center justify-center font-bold mr-3 border border-indigo-100">
                                                {{ substr($a->siswa->nama, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800 text-sm">{{ $a->siswa->nama }}</div>
                                                <div class="text-[10px] text-gray-500">{{ $a->siswa->nisn }} | {{ $a->siswa->kelas }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $a->waktu_absen }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $a->status == 'HADIR' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            {{ $a->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <img src="{{ asset('storage/'.$a->bukti_foto) }}" class="w-10 h-10 object-cover rounded-md border shadow-sm mx-auto">
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row">
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                        <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-200"></i>
                                        <p>Belum ada data scan hari ini.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <canvas id="capture-canvas" class="hidden"></canvas>
    <audio id="beep-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-software-interface-start-2574.mp3"></audio>

    <script>
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', dateOptions);

        let html5QrcodeScanner = null;
        let isScanning = false;

        async function startScanner() {
            try {
                html5QrcodeScanner = new Html5Qrcode("reader");
                const config = { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 };
                
                await html5QrcodeScanner.start({ facingMode: "user" }, config, onScanSuccess);
                
                isScanning = true;
                document.getElementById('btn-start').classList.add('hidden');
                document.getElementById('btn-stop').classList.remove('hidden');
            } catch (err) {
                Swal.fire('Error', 'Gagal membuka kamera: ' + err, 'error');
            }
        }

        async function stopScanner() {
            if (html5QrcodeScanner) {
                await html5QrcodeScanner.stop();
                isScanning = false;
                document.getElementById('btn-start').classList.remove('hidden');
                document.getElementById('btn-stop').classList.add('hidden');
            }
        }

        function onScanSuccess(decodedText) {
            if (!isScanning) return;
            html5QrcodeScanner.pause();
            
            document.getElementById('beep-sound').play();
            const flash = document.getElementById('flash');
            flash.style.animation = 'flashEffect 0.5s ease-out';

            captureImage(decodedText);
        }

        function captureImage(qrCode) {
            const video = document.querySelector("#reader video");
            const canvas = document.getElementById("capture-canvas");
            
            if (video) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
                const photoData = canvas.toDataURL("image/png");
                
                sendAttendanceRequest(qrCode, photoData);
            }
        }

        function sendAttendanceRequest(qrCode, photo) {
            fetch("{{ route('admin.absen.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_code: qrCode, photo: photo })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    renderNewRow(res.data);
                    updateVisualStats(res.data.status);
                    Swal.fire({ title: 'Berhasil!', text: res.data.nama + ' (' + res.data.status + ')', icon: 'success', timer: 1500, showConfirmButton: false });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
                setTimeout(() => html5QrcodeScanner.resume(), 3000);
            })
            .catch(err => {
                console.error(err);
                html5QrcodeScanner.resume();
            });
        }

        function renderNewRow(data) {
            const tbody = document.getElementById('attendance-list');
            const emptyRow = document.getElementById('empty-row');
            if(emptyRow) emptyRow.remove();

            const badge = data.status === 'HADIR' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600';

            const tr = `
                <tr class="bg-blue-50 transition-all duration-700">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-9 w-9 rounded-full bg-indigo-50 text-[#175E92] flex items-center justify-center font-bold mr-3 border border-indigo-100">
                                ${data.nama.charAt(0)}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm">${data.nama}</div>
                                <div class="text-[10px] text-gray-500">${data.nisn} | ${data.kelas}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs text-gray-600">${data.waktu}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold ${badge}">${data.status}</span>
                    </td>
                    <td class="px-6 py-4">
                        <img src="${data.foto}" class="w-10 h-10 object-cover rounded-md border shadow-sm mx-auto">
                    </td>
                </tr>`;
            tbody.insertAdjacentHTML('afterbegin', tr);
        }

        function updateVisualStats(status) {
            document.getElementById('stat-total').innerText = parseInt(document.getElementById('stat-total').innerText) + 1;
            if(status === 'HADIR') {
                document.getElementById('stat-hadir').innerText = parseInt(document.getElementById('stat-hadir').innerText) + 1;
            } else {
                document.getElementById('stat-alpa').innerText = parseInt(document.getElementById('stat-alpa').innerText) + 1;
            }
        }
    </script>
</div>
@endsection