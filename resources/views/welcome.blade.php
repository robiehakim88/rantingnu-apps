<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranting NU Pelem</title>
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] font-sans">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-white shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)]">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="text-xl font-medium text-[#1b1b18] hover:text-[#F53003] transition-colors duration-300">
                Ranting NU Pelem
            </a>
            <ul class="flex space-x-4">
               
                <li><a href="{{ route('login') }}" class="hover:text-[#F53003] transition-colors duration-300">Login</a></li>
                 </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="container mx-auto px-6 py-12">
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-[#1b1b18] animate-fade-in-up">
                Selamat Datang di Ranting NU Pelem Apps
            </h1>
            <p class="text-lg text-[#706f6c] leading-normal animate-fade-in-up" style="animation-delay: 0.3s;">
                Kami adalah bagian dari Nahdlatul Ulama yang berkomitmen untuk mengembangkan nilai-nilai keislaman berhaluan Ahlussunah Wal Jamaah An Nahdhiyyah.
            </p>
            <a href="#"
               class="inline-block px-6 py-3 bg-[#F53003] text-white rounded-full hover:bg-[#e02d02] transition-colors duration-300 shadow-[0px_4px_6px_rgba(0,0,0,0.1)] animate-bounce-in">
                Terdepan Menyenangkan
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#1b1b18] text-white py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            &copy; {{ date('Y') }} Ranting NU Pelem. All rights reserved.
        </div>
    </footer>

</body>
</html>