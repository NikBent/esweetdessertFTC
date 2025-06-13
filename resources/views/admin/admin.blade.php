{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - @yield('title', '')</title>
    @vite('resources/css/app.css')
    {{-- Alpine.js for inline interactivity --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-[#FFFDD0] min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-[#8a894d] text-center py-4">
        <h1 class="brand-font text-2xl text-black">Esweet Dessert</h1>
        <p class="text-xs text-gray-800">PREMIUM NASTAR WIJSMAN</p>
    </header>

    <div class="flex flex-1 overflow-hidden">
        {{-- Sidebar --}}
        <x-admin.sidebar />

        {{-- Main Content --}}
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>
    </div>

    {{-- Scripts stack --}}
    @stack('scripts')
</body>
</html>
