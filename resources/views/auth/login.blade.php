<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SMK Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #172554 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-family: 'sans-serif';
        }

        .bg-blob {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
        }

        .blob {
            position: absolute;
            width: 600px; height: 600px;
            background: rgba(212, 175, 55, 0.15); 
            filter: blur(80px);
            border-radius: 50%;
            animation: move 20s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(-15%, -15%); }
            to { transform: translate(35%, 35%); }
        }

        .login-container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            height: 80vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 2rem;
            border: 2px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        .login-form-wrapper {
            flex: 1;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-width: 400px;
        }

        .image-display-wrapper {
            flex: 1.5;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .image-display-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 1s ease-in-out;
        }

        .btn-gold {
            background: linear-gradient(45deg, #d4af37, #f1c40f);
            color: #1a1a1a;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(45deg, #f1c40f, #d4af37);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.4);
        }

        .btn-gold:active {
            background: #1e3a8a !important;
            color: white;
            transform: scale(0.95);
        }

        /* Styling khusus untuk container password */
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #1e3a8a;
            opacity: 0.6;
            transition: 0.3s;
        }

        .toggle-password:hover {
            opacity: 1;
        }
    </style>
</head>
<body>

    <div class="bg-blob">
        <div class="blob"></div>
        <div class="blob" style="right: 0; bottom: 0; background: rgba(30, 58, 138, 0.3);"></div>
    </div>

    <div class="login-container">
        <div class="login-form-wrapper">
            <div class="w-full max-w-sm text-center"> 
                <div class="mb-10">
                    <h1 class="text-4xl font-extrabold text-blue-900 tracking-tight">Selamat Datang</h1>
                    <p class="text-amber-600 text-base font-bold mt-2 uppercase tracking-widest">SMP NEGERI 1 KEDAWUNG</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg text-left">
                        <p class="text-sm font-bold italic">Akses ditolak. Cek kembali data Anda.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="text-left">
                        <label class="block text-xs font-bold text-blue-900 uppercase mb-2 ml-1 text-left">Email Pengguna</label>
                        <input id="email" 
                               class="w-full px-6 py-4 rounded-xl bg-gray-50 border-2 border-transparent focus:border-amber-400 focus:bg-white shadow-inner font-semibold text-gray-700 outline-none transition-all" 
                               type="email" name="email" value="{{ old('email') }}" required autofocus 
                               placeholder="user@gmail.com" />
                    </div>

                    <div class="text-left">
                        <label class="block text-xs font-bold text-blue-900 uppercase mb-2 ml-1 text-left">Kata Sandi</label>
                        <div class="password-container">
                            <input id="password" 
                                   class="w-full px-6 py-4 rounded-xl bg-gray-50 border-2 border-transparent focus:border-amber-400 focus:bg-white shadow-inner font-semibold text-gray-700 outline-none transition-all"
                                   type="password" name="password" required 
                                   placeholder="••••••••" />
                            
                            <div id="eyeBtn" class="toggle-password" onclick="togglePasswordVisibility()">
                                <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 px-1">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-900 focus:ring-amber-500">
                            <span class="ms-2 text-sm text-gray-600 font-medium">Ingat saya</span>
                        </label>
                        <a class="text-sm text-blue-800 hover:text-amber-600 font-bold transition flex items-center gap-1" href="{{ route('call-admin') }}">
                            Call Admin
                        </a>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-gold py-4 rounded-xl font-extrabold tracking-widest uppercase">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                <p class="text-center mt-10 text-xs text-blue-900 font-bold tracking-widest opacity-50">
                    &copy <?php echo date('Y'); ?> SMP NEGERI 1 KEDAWUNG 
                </p>
            </div>
        </div>

        <div class="image-display-wrapper">
            <img id="loginImage" src="https://images.unsplash.com/photo-1541339907198-e08756d1773d?q=80&w=2940&auto=format&fit=crop" alt="Foto Sekolah">
        </div>
    </div>

    <script>
        // Fungsi Toggle Mata Password
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ubah icon ke mata coret
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            } else {
                passwordInput.type = 'password';
                // Ubah icon ke mata terbuka
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Script Slideshow
        const images = [
            "https://images.unsplash.com/photo-1541339907198-e08756d1773d?q=80&w=2940&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2940&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1520108332029-4d6d02848247?q=80&w=2899&auto=format&fit=crop"
        ];
        let currentIndex = 0;
        const loginImage = document.getElementById('loginImage');

        function changeImage() {
            loginImage.style.opacity = 0;
            setTimeout(() => {
                currentIndex = (currentIndex + 1) % images.length;
                loginImage.src = images[currentIndex];
                loginImage.style.opacity = 1;
            }, 1000);
        }
        setInterval(changeImage, 5000);
    </script>
</body>
</html>