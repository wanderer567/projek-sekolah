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
            <img id="loginImage" src="data:image/jpeg;base64,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" alt="Foto Sekolah">
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
        "data:image/jpeg;base64,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",
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