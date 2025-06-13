@props(['active'])

<nav x-data="{ open: false }" class="bg-[#a0a060] text-black shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Row: Auth Links or User Dropdown -->
        <div class="flex justify-end items-center h-10 text-sm">
            @guest
                <a href="{{ route('login') }}" class="hover:underline me-4">Login |</a>
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
            @else
                <div class="hidden sm:flex items-center space-x-4">
                    <span>{{ Auth::user()->name }}</span>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center">
                                <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endguest
        </div>

        <!-- Main Navigation Row -->
        <div class="py-4 flex items-center justify-between">
            <!-- Left Nav -->
            <div class="hidden md:flex space-x-8 text-sm font-medium">
                <a href="/about" class="hover:underline">About</a>
                <a href="/shop" class="hover:underline">Shop</a>
            </div>

            <!-- Center Logo -->
            <a href="/" class="text-center flex-1 absolute left-1/2 transform -translate-x-1/2">
                <h1 class="brand-font text-3xl font-semibold text-black drop-shadow-md">Esweet Dessert</h1>
                <p class="text-xs text-gray-800 uppercase tracking-widest hover:underline">Premium Nastar Wijsman</p>
            </a>

            <!-- Right Nav -->
            <div class="hidden md:flex space-x-8 text-sm font-medium">
                <a href="/contact" class="hover:underline">Contact</a>
                <a href="/cart" class="hover:underline">Cart</a>
            </div>

            <!-- Hamburger Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-black focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

            <!-- Mobile Menu -->
            <div
            x-show="open"
            x-cloak
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition transform ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="absolute right-4 top-full mt-2 bg-olive shadow-md rounded-lg p-4 space-y-2 text-right z-50 md:hidden"
            >
                <a href="/about" class="block text-sm hover:underline">About</a>
                <a href="/shop" class="block text-sm hover:underline">Shop</a>
                <a href="/contact" class="block text-sm hover:underline">Contact</a>
                <a href="/cart" class="block text-sm hover:underline">Cart</a>
            </div> 
    </div>
</nav>
<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.13.5/dist/cdn.min.js" defer></script>