@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    /* Efek Flash yang lebih halus */
    @keyframes flashSuccess {
        0% { background: rgba(34, 197, 94, 0.5); opacity: 1; }
        100% { background: transparent; opacity: 0; }
    }
    .flash-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        pointer-events: none; z-index: 50; transition: all 0.3s;
    }

    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar { width: 5px; }
    .custom-scroll::-webkit-scrollbar-track { background: transparent; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    
    /* Scanner Frame */
    .scanner-box { position: relative; }
    .scanner-box::before {
        content: ""; position: absolute; top: 20px; left: 20px; width: 40px; height: 40px;
        border-top: 4px solid #4F46E5; border-left: 4px solid #4F46E5; z-index: 10; border-radius: 4px 0 0 0;
    }
    .scanner-box::after {
        content: ""; position: absolute; bottom: 20px; right: 20px; width: 40px; height: 40px;
        border-bottom: 4px solid #4F46E5; border-right: 4px solid #4F46E5; z-index: 10; border-radius: 0 0 4px 0;
    }
</style>

<div class="min-h-screen bg-[#F8FAFC] font-jakarta p-4 md:p-8">
    
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1E293B] tracking-tight">E-ABSEN <span class="text-indigo-600">SCANNER</span></h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2 font-medium">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-ping"></span>
                    Sistem Absensi Real-time: <span id="current-date" class="text-slate-700"></span>
                </p>
            </div>
            
            <div class="flex flex-wrap gap-3 w-full md:w-auto">
                <div class="relative group flex-1 md:w-72">
                    <input type="text" id="search-siswa" placeholder="Cari nama siswa..." 
                        class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-sm">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>

                <select id="filter-kelas" class="px-4 py-3 rounded-2xl border border-slate-200 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-sm bg-white cursor-pointer min-w-[140px]">
                    <option value="">Semua Kelas</option>
                    @foreach(\App\Models\Siswa::select('kelas')->distinct()->orderBy('kelas')->get() as $kelas)
                        <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'Total Scan', 'val' => count($absensis), 'icon' => 'fa-expand', 'color' => 'indigo'],
                ['label' => 'Hadir', 'val' => $absensis->where('status', 'HADIR')->count(), 'icon' => 'fa-check-double', 'color' => 'emerald'],
                ['label' => 'Terlambat', 'val' => $absensis->where('status', 'TERLAMBAT')->count(), 'icon' => 'fa-clock', 'color' => 'amber'],
                ['label' => 'Total Siswa', 'val' => \App\Models\Siswa::count(), 'icon' => 'fa-user-graduate', 'color' => 'slate']
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col gap-3 transition-all hover:shadow-md">
            <div class="w-12 h-12 rounded-2xl bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-600 flex items-center justify-center text-xl">
                <i class="fas {{ $s['icon'] }}"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">{{ $s['label'] }}</p>
                <h3 class="text-2xl font-black text-slate-800" id="stat-{{ Str::slug($s['label']) }}">{{ $s['val'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 overflow-hidden sticky top-8">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 tracking-tight">Kamera Scanner</h3>
                    <div class="flex items-center gap-2">
                         <span id="scan-status" class="w-2 h-2 bg-red-500 rounded-full"></span>
                         <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Live Cam</span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="scanner-box rounded-3xl overflow-hidden bg-slate-900 aspect-square shadow-2xl relative">
                        <div id="reader" class="w-full h-full object-cover"></div>
                        <div id="flash" class="flash-overlay"></div>
                        
                        <div id="scanner-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-white p-8 text-center bg-slate-900/80 backdrop-blur-sm z-20 transition-opacity duration-500">
                            <div class="w-16 h-16 border-4 border-dashed border-slate-600 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-video-slash text-2xl text-slate-500"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-400">Kamera dinonaktifkan. Klik tombol di bawah untuk mulai scan.</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 space-y-3">
                        <button onclick="startScanner()" id="btn-start" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <i class="fas fa-power-off"></i> Aktifkan Scanner
                        </button>
                        <button onclick="stopScanner()" id="btn-stop" class="hidden w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-4 rounded-2xl transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-stop"></i> Matikan Kamera
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 flex flex-col min-h-[600px]">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-xl text-slate-800">Log Kehadiran</h3>
                        <p class="text-sm text-slate-400">Data absen yang masuk hari ini secara real-time</p>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto custom-scroll p-4">
                    <table class="w-full border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-left">
                                <th class="px-6 py-2 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Peserta Didik</th>
                                <th class="px-6 py-2 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu</th>
                                <th class="px-6 py-2 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                                <th class="px-6 py-2 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Snapshot</th>
                            </tr>
                        </thead>
                        <tbody id="attendance-list">
                            @forelse($absensis as $a)
                            <tr class="bg-white border border-slate-50 shadow-sm hover:shadow-md hover:bg-slate-50/50 transition-all rounded-2xl overflow-hidden group" 
                                data-nama="{{ strtolower($a->siswa->nama) }}" data-kelas="{{ $a->siswa->kelas }}">
                                <td class="px-6 py-4 rounded-l-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="h-11 w-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg border border-indigo-100 shadow-sm">
                                            {{ substr($a->siswa->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800">{{ $a->siswa->nama }}</div>
                                            <div class="text-[11px] font-semibold text-slate-400">{{ $a->siswa->nisn }} • {{ $a->siswa->kelas }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700 uppercase tracking-tighter">{{ date('H:i', strtotime($a->waktu_absen)) }}</span>
                                        <span class="text-[10px] text-slate-400">WIB</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $a->status == 'HADIR' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                        {{ $a->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 rounded-r-2xl text-center">
                                    <div class="relative inline-block overflow-hidden rounded-xl border-2 border-white shadow-sm w-12 h-12 group-hover:scale-110 transition-transform">
                                        <img src="{{ asset('storage/'.$a->bukti_foto) }}" class="w-full h-full object-cover">
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="empty-row">
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="max-w-xs mx-auto">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                            <i class="fas fa-inbox text-3xl"></i>
                                        </div>
                                        <h4 class="font-bold text-slate-800">Belum ada data</h4>
                                        <p class="text-sm text-slate-400 mt-1">Data absensi hari ini akan muncul di sini secara otomatis.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<canvas id="capture-canvas" class="hidden"></canvas>
<audio id="beep-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-software-interface-start-2574.mp3"></audio>

<script>
// Format Tanggal
const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', dateOptions);

let scanner = null;
let isScanning = false;

async function startScanner() {
    try {
        const placeholder = document.getElementById('scanner-placeholder');
        const statusDot = document.getElementById('scan-status');
        
        scanner = new Html5Qrcode("reader");
        const config = { fps: 15, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 };
        
        await scanner.start({ facingMode: "user" }, config, onScanSuccess);
        
        isScanning = true;
        placeholder.classList.add('opacity-0', 'pointer-events-none');
        statusDot.classList.replace('bg-red-500', 'bg-green-500');
        document.getElementById('btn-start').classList.add('hidden');
        document.getElementById('btn-stop').classList.remove('hidden');
    } catch (err) {
        Swal.fire({ icon: 'error', title: 'Akses Kamera Gagal', text: 'Pastikan izin kamera sudah aktif.' });
    }
}

async function stopScanner() {
    if (scanner) {
        await scanner.stop();
        isScanning = false;
        document.getElementById('scanner-placeholder').classList.remove('opacity-0', 'pointer-events-none');
        document.getElementById('scan-status').classList.replace('bg-green-500', 'bg-red-500');
        document.getElementById('btn-start').classList.remove('hidden');
        document.getElementById('btn-stop').classList.add('hidden');
    }
}

function onScanSuccess(decodedText) {
    if (!isScanning) return;
    scanner.pause();
    document.getElementById('beep-sound').play();
    
    const flash = document.getElementById('flash');
    flash.style.animation = 'flashSuccess 0.6s ease-out';
    setTimeout(() => flash.style.animation = '', 600);
    
    captureImage(decodedText);
}

function captureImage(qrCode) {
    const video = document.querySelector("#reader video");
    const canvas = document.getElementById("capture-canvas");
    if(video) {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
        sendAttendance(qrCode, canvas.toDataURL("image/png"));
    }
}

function sendAttendance(qrCode, photo) {
    fetch("{{ route('admin.absen.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: JSON.stringify({ qr_code: qrCode, photo: photo })
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){
            renderNewRow(res.data);
            updateStats(res.data.status);
            Swal.fire({ 
                title: 'Absensi Berhasil', 
                html: `<b>${res.data.nama}</b><br><span class="text-sm">${res.data.status} pada ${res.data.waktu}</span>`,
                icon: 'success', 
                timer: 2000, 
                showConfirmButton: false,
                padding: '2rem',
                customClass: { popup: 'rounded-[2rem]' }
            });
        } else {
            Swal.fire({ icon: 'warning', title: 'Scan Gagal', text: res.message });
        }
        setTimeout(() => isScanning && scanner.resume(), 2500);
    })
    .catch(err => {
        console.error(err);
        scanner.resume();
    });
}

function renderNewRow(data){
    const tbody = document.getElementById('attendance-list');
    const emptyRow = document.getElementById('empty-row');
    if(emptyRow) emptyRow.remove();

    const badge = data.status === 'HADIR' ? 
        'bg-emerald-50 text-emerald-600 border border-emerald-100' : 
        'bg-rose-50 text-rose-600 border border-rose-100';

    const tr = document.createElement('tr');
    tr.className = "bg-indigo-50/50 border border-indigo-100 shadow-md hover:bg-slate-50 transition-all rounded-2xl overflow-hidden group scale-95 opacity-0";
    tr.setAttribute('data-nama', data.nama.toLowerCase());
    tr.setAttribute('data-kelas', data.kelas);
    
    tr.innerHTML = `
        <td class="px-6 py-4 rounded-l-2xl">
            <div class="flex items-center gap-4">
                <div class="h-11 w-11 rounded-xl bg-white text-indigo-600 flex items-center justify-center font-bold text-lg border border-indigo-200 shadow-sm">
                    ${data.nama.charAt(0)}
                </div>
                <div>
                    <div class="font-bold text-slate-800">${data.nama}</div>
                    <div class="text-[11px] font-semibold text-slate-400">${data.nisn} • ${data.kelas}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-700 uppercase tracking-tighter">${data.waktu}</span>
                <span class="text-[10px] text-slate-400">WIB</span>
            </div>
        </td>
        <td class="px-6 py-4 text-center">
            <span class="inline-block px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest ${badge}">
                ${data.status}
            </span>
        </td>
        <td class="px-6 py-4 rounded-r-2xl text-center">
            <div class="relative inline-block overflow-hidden rounded-xl border-2 border-white shadow-sm w-12 h-12">
                <img src="${data.foto}" class="w-full h-full object-cover">
            </div>
        </td>
    `;
    tbody.prepend(tr);
    
    // Trigger animation
    setTimeout(() => tr.classList.replace('scale-95', 'scale-100'), 10);
    setTimeout(() => tr.classList.replace('opacity-0', 'opacity-100'), 10);
}

function updateStats(status){
    const total = document.getElementById('stat-total-scan');
    const hadir = document.getElementById('stat-hadir');
    const telat = document.getElementById('stat-terlambat');
    
    total.innerText = parseInt(total.innerText) + 1;
    if(status === 'HADIR') hadir.innerText = parseInt(hadir.innerText) + 1;
    else telat.innerText = parseInt(telat.innerText) + 1;
}

// Search & Filter
document.getElementById('search-siswa').addEventListener('input', filterTable);
document.getElementById('filter-kelas').addEventListener('change', filterTable);

function filterTable() {
    const search = document.getElementById('search-siswa').value.toLowerCase();
    const kelas = document.getElementById('filter-kelas').value;
    const rows = document.querySelectorAll('#attendance-list tr:not(#empty-row)');

    rows.forEach(row => {
        const matchesSearch = row.getAttribute('data-nama').includes(search);
        const matchesKelas = kelas === '' || row.getAttribute('data-kelas') === kelas;
        row.style.display = (matchesSearch && matchesKelas) ? '' : 'none';
    });
}
</script>
@endsection