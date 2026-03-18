@extends('layouts.app')

@section('content')

    <title>E-ABSEN - Absen QR</title>
    
    <!-- Tailwind CSS (Gunakan Vite di Laravel aslinya) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts: Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- HTML5-QRCode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    },
                    colors: {
                        sidebar: '#2a2a4e', 
                        primary: '#4e73df',
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 3px; }
        
        .nav-item.active {
            background-color: white;
            color: #2a2a4e;
            font-weight: 800;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
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
    </style>

    <!-- SIDEBAR -->
    <!-- <aside class="w-64 bg-sidebar text-white flex-shrink-0 hidden md:flex flex-col transition-all duration-300 shadow-xl z-20">
        <!-- Brand -->
        <!-- <div class="h-20 flex items-center px-8 border-b border-white/10">
            <div class="text-2xl font-extrabold tracking-wider flex items-center gap-2">
                E-ABSEN
            </div>
        </div> --> 

        <!-- Menu Title -->
        <!-- <div class="px-6 pt-6 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
            Menu
        </div> -->

        <!-- Navigation -->
        <!-- <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white/10 rounded-lg transition-all group">
                <i class="fas fa-desktop w-6 text-center mr-3 text-lg"></i>
                <span class="font-semibold">Dashboard Guru</span>
            </a>
            
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white/10 rounded-lg transition-all group">
                <i class="fas fa-user-edit w-6 text-center mr-3 text-lg"></i>
                <span class="font-semibold">Absen Manual</span>
            </a> -->
            
            <!-- Active Item (Absen Qr) -->
            <!-- <a href="#" class="nav-item active flex items-center px-4 py-3 rounded-lg transition-all group">
                <i class="fas fa-qrcode w-6 text-center mr-3 text-lg"></i>
                <span class="font-bold">Absen Qr</span>
            </a> -->
<!-- 
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-white/10 rounded-lg transition-all group">
                <i class="fas fa-download w-6 text-center mr-3 text-lg"></i>
                <span class="font-semibold">Download Absen</span>
            </a>
        </nav> -->

        <!-- Footer Sidebar -->
        <!-- <div class="p-4 border-t border-white/10">
            <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:text-white hover:bg-red-500/20 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt w-6 mr-3"></i>
                <span class="font-semibold">Keluar Sistem</span>
            </a>
        </div>
    </aside> -->
<!-- 
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative"> -->
        
        <!-- Header Mobile -->
        <!-- <header class="md:hidden bg-white shadow-sm h-16 flex items-center justify-between px-4 z-20">
            <div class="font-extrabold text-sidebar text-xl">E-ABSEN</div>
            <button class="text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </header> -->

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Absen QR Scanner</h1>
                    <div class="flex items-center text-primary mt-1 font-semibold text-sm">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Periode: Hari Ini (<span id="current-date"></span>)</span>
                    </div>
                </div>
                
                <div class="relative w-full md:w-64">
                    <input type="text" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border-none shadow-sm focus:ring-2 focus:ring-primary focus:outline-none text-sm bg-white">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase mb-1">Total Scan</div>
                        <div class="text-2xl font-bold text-gray-800" id="stat-total">0</div>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-500">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase mb-1">Hadir</div>
                        <div class="text-2xl font-bold text-gray-800" id="stat-hadir">0</div>
                    </div>
                    <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center text-green-500">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase mb-1">Izin / Sakit</div>
                        <div class="text-2xl font-bold text-gray-800" id="stat-izin">0</div>
                    </div>
                    <div class="h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-500">
                        <i class="fas fa-file-medical text-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase mb-1">Terlambat/Alpa</div>
                        <div class="text-2xl font-bold text-gray-800" id="stat-alpa">0</div>
                    </div>
                    <div class="h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center text-red-500">
                        <i class="fas fa-times-circle text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <h3 class="font-bold text-gray-700">Scan QR Code</h3>
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
                                <button onclick="startScanner()" id="btn-start" class="flex-1 bg-primary hover:bg-blue-600 text-white font-bold py-2.5 rounded-lg shadow-sm transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-camera"></i> Mulai Scan
                                </button>
                                <button onclick="stopScanner()" id="btn-stop" class="hidden flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 rounded-lg shadow-sm transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-stop-circle"></i> Stop
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 text-center mt-3">Pastikan cahaya ruangan cukup terang</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm h-full flex flex-col">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-gray-800">Detail Absensi Siswa</h3>
                            
                            <div class="relative">
                                <button class="flex items-center space-x-2 bg-gray-50 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-semibold text-gray-600 transition-colors border border-gray-200">
                                    <i class="far fa-calendar text-gray-400"></i>
                                    <span>Hari Ini</span>
                                    <i class="fas fa-chevron-down text-xs ml-1"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 overflow-auto p-2">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                        <th class="px-6 py-4">Nama Siswa</th>
                                        <th class="px-6 py-4">Waktu</th>
                                        <th class="px-6 py-4 text-center">Status</th>
                                        <th class="px-6 py-4">Bukti</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-50" id="attendance-list">
                                    <tr id="empty-row">
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-200"></i>
                                                <p>Belum ada data scan masuk.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="p-4 border-t border-gray-100 text-xs text-gray-500 flex justify-between items-center">
                            <span>Menampilkan data terbaru</span>
                            <div class="flex gap-1">
                                <button class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"><i class="fas fa-chevron-left"></i></button>
                                <button class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <canvas id="capture-canvas" class="hidden"></canvas>
    <audio id="beep-sound" src="https://assets.mixkit.co/sfx/preview/mixkit-correct-answer-tone-2870.mp3"></audio>

    <script>
        // 
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', dateOptions);

        const studentDb = {
            "123456": { name: "Zaid Ali", nis: "123456", class: "XII RPL 1" },
            "654321": { name: "Budi Santoso", nis: "654321", class: "XI TKJ 2" },
            "112233": { name: "Siti Aminah", nis: "112233", class: "X MM 1" },
            "445566": { name: "Rudi Tabuti", nis: "445566", class: "XII RPL 1" }
        };

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
                console.error(err);
                alert("Gagal membuka kamera. Pastikan izin diberikan.");
            }
        }

        async function stopScanner() {
            if (html5QrcodeScanner) {
                await html5QrcodeScanner.stop();
                html5QrcodeScanner.clear();
                isScanning = false;
                document.getElementById('btn-start').classList.remove('hidden');
                document.getElementById('btn-stop').classList.add('hidden');
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (!isScanning) return;
            
            // 
            html5QrcodeScanner.pause();
            
            // 
            document.getElementById('beep-sound').play();
            const flash = document.getElementById('flash');
            flash.style.animation = 'none';
            flash.offsetHeight; /* trigger reflow */
            flash.style.animation = 'flashEffect 0.5s ease-out';

            // 
            captureImage(decodedText);
        }

        function captureImage(qrCode) {
            const video = document.querySelector("#reader video");
            const canvas = document.getElementById("capture-canvas");
            
            if (video) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageDataUrl = canvas.toDataURL("image/png");
                
                processAttendance(qrCode, imageDataUrl);
            }
        }

        function processAttendance(qrCode, photoUrl) {
            const student = studentDb[qrCode] || { name: "Tamu / Tidak Dikenal", nis: qrCode };
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            // baim
            const hour = now.getHours();
            // const minute = now.getMinute();
            let status = 'HADIR';
            let badgeColor = 'bg-green-100 text-green-600 border border-green-200';
                    // & minute
            if (hour > 7) {            
                status = 'TERLAMBAT'; 
                badgeColor = 'bg-yellow-100 text-yellow-600 border border-yellow-200';
                updateStat('stat-alpa', 1); // 
            } else {
                updateStat('stat-hadir', 1);
            }
            updateStat('stat-total', 1);

            // baim
            const tbody = document.getElementById('attendance-list');
            const emptyRow = document.getElementById('empty-row');
            if(emptyRow) emptyRow.remove();

            const tr = document.createElement('tr');
            tr.className = "hover:bg-gray-50 transition-colors group";
            tr.innerHTML = `
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-3 border border-indigo-200">
                            ${student.name.charAt(0)}
                        </div>
                        <div>
                            <div class="font-bold text-gray-800 text-sm">${student.name}</div>
                            <div class="text-xs text-gray-500">NIS: ${student.nis}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 font-mono text-sm text-gray-600">
                    ${timeStr}
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold ${badgeColor}">
                        ${status}
                    </span>
                </td>
                <td class="px-6 py-4">
                     <div class="relative group cursor-pointer w-12 h-12">
                        <img src="${photoUrl}" class="w-full h-full object-cover rounded-md border border-gray-200 shadow-sm">
                        <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center rounded-md text-white text-xs">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <button class="text-gray-400 hover:text-blue-500 transition mx-1"><i class="fas fa-edit"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition mx-1"><i class="fas fa-trash-alt"></i></button>
                </td>
            `;
            
            tbody.prepend(tr);
//
            // delay
            setTimeout(() => {
                html5QrcodeScanner.resume();
            }, 2500);
        }

        function updateStat(id, val) {
            const el = document.getElementById(id);
            el.innerText = parseInt(el.innerText) + val;
        }
    </script>

</main>

@endsection