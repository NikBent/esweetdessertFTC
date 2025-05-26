<x-app-layout>
    <section class="min-h-screen bg-yellow-100 px-6 py-12">
        <div class="max-w-7xl mx-auto space-y-12">

            {{-- Product Grid - Row 1: 1, 5, 6, 8 --}}
            <div class="space-y-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ([1, 5, 6, 8] as $i)
                        <div class="rounded overflow-hidden shadow flex justify-center items-center bg-white p-2">
                            <img src="{{ asset('images/product' . $i . '.jpg') }}" alt="Product {{ $i }}"
                                class="max-w-full max-h-48 object-contain">
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center gap-4">
                    <a href="https://wa.me/yourwhatsappnumber" target="_blank"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        <img src="{{ asset('images/WhatsApp.JPG') }}" alt="WhatsApp" class="h-5 w-5">
                        Order in WhatsApp
                    </a>
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        Add to Cart
                    </a>
                </div>
            </div>

            {{-- Product Grid - Row 2: 2, 3, 4, 7 --}}
            <div class="space-y-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ([2, 3, 4, 7] as $i)
                        <div class="rounded overflow-hidden shadow flex justify-center items-center bg-white p-2">
                            <img src="{{ asset('images/product' . $i . '.jpg') }}" alt="Product {{ $i }}"
                                class="max-w-full max-h-48 object-contain">
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center gap-4">
                    <a href="https://wa.me/yourwhatsappnumber" target="_blank"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        <img src="{{ asset('images/WhatsApp.JPG') }}" alt="WhatsApp" class="h-5 w-5">
                        Order in WhatsApp
                    </a>
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        Add to Cart
                    </a>
                </div>
            </div>

            {{-- Product Grid - Row 3: 9 --}}
            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-center">
                    @foreach ([9] as $i)
                        <div class="rounded overflow-hidden shadow flex justify-center items-center bg-white p-2">
                            <img src="{{ asset('images/product' . $i . '.jpg') }}" alt="Product {{ $i }}"
                                class="max-w-full max-h-48 object-contain">
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center gap-4">
                    <a href="https://wa.me/yourwhatsappnumber" target="_blank"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        <img src="{{ asset('images/WhatsApp.JPG') }}" alt="WhatsApp" class="h-5 w-5">
                        Order in WhatsApp
                    </a>
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        Add to Cart
                    </a>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>
