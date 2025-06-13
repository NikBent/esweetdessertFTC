<x-app-layout>
    <section class="min-h-screen bg-gray-100 px-6 py-12">
        <div class="max-w-5xl mx-auto space-y-8">
            <h1 class="text-2xl font-bold">Shopping Cart</h1>

            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Shopping Cart Table --}}
            @if(count($cart) > 0)
                <table class="w-full bg-white shadow rounded overflow-hidden">
                    <thead class="bg-gray-200 text-left">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Quantity</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $details)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $details['name'] }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('update.cart') }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                            class="w-16 border border-gray-300 rounded px-2 py-1 text-sm">
                                        <button type="submit" class="text-blue-600 hover:underline text-sm">Update</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">Rp
                                    {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('remove.from.cart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-600">Your cart is empty.</p>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('shop') }}"
                    class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600 transition">
                    ← Continue Shopping
                </a>
            </div>

            @if(count($cart) > 0)
                <form action="{{ route('place.order') }}" method="POST" class="mt-6 text-right">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded transition">
                        ✅ Place Order
                    </button>
                </form>
            @endif

            {{-- User Order History --}}
            <div class="mt-16">
                <h2 class="text-xl font-bold mb-4">Your Order History</h2>

                @if($orders->count())
                    <table class="w-full bg-white shadow rounded overflow-hidden">
                        <thead class="bg-gray-200 text-left">
                            <tr>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3">Quantity</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="border-t">
                                    <td class="px-4 py-3">{{ $order->customer_name }}</td>
                                    <td class="px-4 py-3">{{ $order->product_name }}</td>
                                    <td class="px-4 py-3">{{ $order->qty }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($order->date)->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">You have not placed any orders yet.</p>
                @endif
            </div>

        </div>
    </section>
</x-app-layout>
