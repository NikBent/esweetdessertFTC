<div class="flex flex-col h-screen bg-[#FFFDD0] border-r border-gray-300 px-6 py-8 justify-between">
    <div>
        <!-- Logo -->
        <div class="text-center mb-10">
            <h1 class="brand-font text-2xl font-bold">Esweet Dessert</h1>
            <p class="text-xs tracking-wide text-gray-700">PREMIUM NASTAR WIJSMAN</p>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-6 text-sm text-black">
            <a href="{{ route('admin.orders.index') }}" class="relative flex items-center justify-between">
                <span>Orders</span>
                {{-- badge if any --}}
            </a>
            <a href="{{ route('admin.products.index') }}" class="block">Products</a>
            <a href="{{ route('admin.analytics.index') }}" class="block">Analytics</a>
            <a href="{{ route('admin.notifications.index') }}" class="relative flex items-center justify-between">
                <span>Notifications</span>
                @if(isset($notificationCount) && $notificationCount > 0)
                    <span class="bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">{{ $notificationCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.settings.index') }}" class="block">Settings</a>
        </nav>
    </div>

    <!-- Logout Button -->
    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-full text-sm hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </div>
</div>
