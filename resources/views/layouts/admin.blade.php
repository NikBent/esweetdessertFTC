<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Esweet Dessert</title>
    @vite('resources/css/app.css') <!-- or include Tailwind if manually configured -->
</head>
<body class="bg-yellow-50 text-gray-800 font-sans">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-60 bg-yellow-100 border-r border-gray-300 p-4 flex flex-col justify-between">
            <div class="space-y-4">
                <h1 class="text-center text-2xl font-pinyon font-semibold">Esweet Dessert</h1>
                <nav class="space-y-2">
                    <a href="#" class="flex justify-between hover:underline">Orders <span class="bg-red-500 text-white text-xs rounded-full px-2">1</span></a>
                    <a href="#" class="hover:underline">Products</a>
                    <a href="#" class="hover:underline">Analytics</a>
                    <a href="#" class="hover:underline">Promotions</a>
                    <a href="#" class="flex justify-between hover:underline">Notifications <span class="bg-red-500 text-white text-xs rounded-full px-2">1</span></a>
                    <a href="#" class="hover:underline">Settings</a>
                </nav>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Logout</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
