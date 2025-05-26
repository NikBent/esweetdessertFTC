<x-app-layout>
    <section class="min-h-screen bg-yellow-100 px-6 py-12">
        <div class="max-w-7xl mx-auto space-y-12">

            {{-- Product Images Section (Unified) --}}
            <div class="space-y-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $i)
                        <div class="rounded overflow-hidden shadow flex justify-center items-center bg-white p-2">
                            <img src="{{ asset('images/product' . $i . '.jpg') }}" alt="Product {{ $i }}" class="max-w-full max-h-48 object-contain">
                        </div>
                    @endforeach
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-center gap-4">
                    <a href="https://wa.me/yourwhatsappnumber" target="_blank"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        <img src="{{ asset('images/WhatsApp.JPG') }}" alt="WhatsApp" class="h-5 w-5">
                        Order in WhatsApp
                    </a>
                    <a href="{{ route('cart') }}"
                        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-full transition">
                        🛒 View Cart
                    </a>
                </div>
            </div>

            {{-- Product Table from Database --}}
            <div class="overflow-x-auto bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">Available Products</h2>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="min-w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Stock</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $product->product_id }}</td>
                                <td class="px-4 py-2">{{ $product->nama }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $product->stock }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('add.to.cart', $product->product_id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                       Add to Cart
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
</x-app-layout>
