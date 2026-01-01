<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FilmoRent - Profesjonalna Wypożyczalnia Sprzętu' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @include('components.styles')
</head>
<body class="bg-slate-950 text-slate-100 antialiased flex flex-col min-h-screen">

    @include('components.navbar')

    <main id="main-content" class="flex-grow w-full">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 container mx-auto my-4" role="alert">
                <p class="font-bold">Sukces</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 py-8 mt-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4">FilmoRent</h3>
                <p class="text-sm">Najlepszy sprzęt filmowy w Twoim mieście.</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Kontakt</h3>
                <p class="text-sm">ul. Filmowa 15, Warszawa</p>
                <p class="text-sm">pomoc@filmorent.pl</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Dostępność</h3>
                <p class="text-sm">Serwis dostosowany do standardu WCAG 2.1 AA.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
