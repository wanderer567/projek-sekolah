<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          keyframes: {
            fade: {
              '0%': { opacity: '0', transform: 'scale(0.95)' },
              '100%': { opacity: '1', transform: 'scale(1)' },
            }
          }
        }
      }
    }
    </script>
</head>
<title>Laravell</title>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
 
   <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 text-white animate-[fade_0.6s_ease-in-out]">
    {{ $slot }}
</div>


