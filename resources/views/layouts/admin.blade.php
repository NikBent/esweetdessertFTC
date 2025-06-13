{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Admin Dashboard') | Esweet Dessert</title>

  {{-- Tailwind + your custom CSS (imports fonts, etc.) --}}
  @vite('resources/css/app.css')
  @vite('resources/js/app.js') {{-- If you have admin‐specific JS --}}
</head>
<body class="min-h-screen flex flex-col bg-cream font-body text-gray-800">
  {{-- ========================
      Optional Olive Top Bar
      (If your design has an olive horizontal strip above sidebar)
      ======================== --}}
  <div class="w-full bg-olive h-12"></div>

  <div class="flex flex-1">
    {{-- ========================
        Sidebar
        ======================== --}}
    <aside class="w-60 bg-cream border-r border-gray-300 flex flex-col justify-between py-8 px-6">
      {{-- Logo / Brand --}}
      <div class="space-y-8">
        <h1 class="brand-font text-center text-2xl font-brand text-gray-800">
          Esweet Dessert
        </h1>
        <p class="text-xs text-gray-800">PREMIUM NASTAR WIJSMAN</p>
        {{-- Sidebar nav links --}}
        <nav class="flex flex-col space-y-4">
          {{-- Orders (with badge) --}}
          <a href="{{ route('admin.orders') }}"
             class="flex items-center justify-between text-gray-900 hover:text-gray-700"
             @class([
               'font-semibold underline' => request()->routeIs('admin.orders')
             ])>
            <span>Orders</span>
            <span class="bg-red-500 text-white text-xs font-medium rounded-full px-2">1</span>
          </a>

          {{-- Products --}}
          <a href="{{ route('admin.products') }}"
             class="text-gray-900 hover:text-gray-700"
             @class([
               'font-semibold underline' => request()->routeIs('admin.products')
             ])>
            Products
          </a>

          {{-- Analytics --}}
          <a href="{{ route('admin.analytics') }}"
             class="text-gray-900 hover:text-gray-700"
             @class([
               'font-semibold underline' => request()->routeIs('admin.analytics')
             ])>
            Analytics
          </a>

          {{-- Promotions (if you want this––your screenshot showed “Notifications” not “Promotions”, but you can rename) --}}
          {{-- <a href="{{ route('admin.promotions') }}" ...>Promotions</a> --}}

          {{-- Notifications (with badge) --}}
          <a href="{{ route('admin.notifications') }}"
             class="flex items-center justify-between text-gray-900 hover:text-gray-700"
             @class([
               'font-semibold underline' => request()->routeIs('admin.notifications')
             ])>
            <span>Notifications</span>
            <span class="bg-red-500 text-white text-xs font-medium rounded-full px-2">1</span>
          </a>

          {{-- Settings --}}
          <a href="{{ route('admin.settings') }}"
             class="text-gray-900 hover:text-gray-700"
             @class([
               'font-semibold underline' => request()->routeIs('admin.settings')
             ])>
            Settings
          </a>
        </nav>
      </div>

      {{-- Logout Button at bottom --}}
      <div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button
            type="submit"
            class="w-full bg-red-500 text-white text-center py-2 rounded hover:bg-red-600 transition"
          >
            Logout
          </button>
        </form>
      </div>
    </aside>

    {{-- ========================
        Main Content Area
        ======================== --}}
    <main class="flex-1 p-6 overflow-auto">
      {{-- You can add an optional page‐header here --}}
      <div class="mb-6">
        @yield('page-title')
      </div>

      {{-- Actual page content goes here --}}
      @yield('content')
    </main>
  </div>
</body>
</html>
