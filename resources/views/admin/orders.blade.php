{{-- resources/views/admin/orders.blade.php --}}
@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div x-data="orderPage()" class="space-y-4">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Container box --}}
    <div class="border border-gray-300 rounded bg-[#FFFEE0] p-4">
        {{-- Header + Tabs --}}
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-black">Orders</h2>
            {{-- Tabs --}}
            <nav class="mt-2 flex space-x-4 text-sm">
                {{-- All --}}
                <a href="{{ route('admin.orders.index') }}"
                   class="px-3 py-1 rounded {{ is_null($currentStatus) ? 'bg-gray-200 font-medium' : 'hover:bg-gray-100' }}">
                    All
                    <span class="ml-1 inline-flex items-center justify-center bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">
                        {{ $counts['all'] }}
                    </span>
                </a>
                {{-- Unpaid --}}
                <a href="{{ route('admin.orders.index', ['status' => 'unpaid']) }}"
                   class="px-3 py-1 rounded {{ $currentStatus === 'unpaid' ? 'bg-gray-200 font-medium' : 'hover:bg-gray-100' }}">
                    Unpaid
                    <span class="ml-1 inline-flex items-center justify-center bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">
                        {{ $counts['unpaid'] }}
                    </span>
                </a>
                {{-- Done (Paid) --}}
                <a href="{{ route('admin.orders.index', ['status' => 'done']) }}"
                   class="px-3 py-1 rounded {{ $currentStatus === 'done' ? 'bg-gray-200 font-medium' : 'hover:bg-gray-100' }}">
                    Done
                    <span class="ml-1 inline-flex items-center justify-center bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">
                        {{ $counts['done'] }}
                    </span>
                </a>
                {{-- Cancelled --}}
                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
                   class="px-3 py-1 rounded {{ $currentStatus === 'cancelled' ? 'bg-gray-200 font-medium' : 'hover:bg-gray-100' }}">
                    Cancelled
                    <span class="ml-1 inline-flex items-center justify-center bg-red-600 text-white rounded-full px-2 py-0.5 text-xs">
                        {{ $counts['cancelled'] }}
                    </span>
                </a>
            </nav>
        </div>

        {{-- Table Header --}}
        <div class="grid grid-cols-12 bg-gray-300 text-gray-700 font-medium text-sm px-2 py-2 rounded-t">
            {{-- Checkbox header --}}
            <div class="col-span-1 flex items-center justify-center">
                <input type="checkbox" disabled>
            </div>
            <div class="col-span-4">Product</div>
            <div class="col-span-3">Amount Charged</div>
            <div class="col-span-2">Status</div>
            <div class="col-span-2 text-center">Action</div>
        </div>

        {{-- Orders List --}}
        <div>
            @forelse($orders as $order)
                {{-- Each order row container --}}
                <div class="grid grid-cols-12 items-center border-t border-gray-200 bg-gray-100 even:bg-gray-200 px-2 py-3 relative">
                    {{-- Checkbox --}}
                    <div class="col-span-1 flex items-center justify-center">
                        <input type="checkbox" name="select_order[]" value="{{ $order->id }}">
                    </div>

                    {{-- Product info: image + name + possibly seller details above or below --}}
                    <div class="col-span-4 flex items-start space-x-2">
                        {{-- Optional: show seller/name/phone above? In image, each item had a small header line: "Mamamo Toko 08234567891" --}}
                        <div class="flex-shrink-0">
                            @if($order->product && $order->product->image_url)
                                <img src="{{ $order->product->image_url }}" alt="{{ $order->product->name }}" class="w-16 h-16 object-cover rounded">
                            @else
                                {{-- Placeholder image --}}
                                <div class="w-16 h-16 bg-gray-300 rounded"></div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="font-medium text-gray-800">{{ $order->product ? $order->product->name : '—' }}</span>
                            @if(isset($order->seller_name) || isset($order->seller_phone))
                                <span class="text-xs text-gray-600">
                                    {{ $order->seller_name ?? '' }}
                                    @if(isset($order->seller_phone))
                                        — {{ $order->seller_phone }}
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Amount Charged --}}
                    <div class="col-span-3 text-gray-800">
                        {{-- Format currency, e.g., Rp 200.000 --}}
                        {{ number_format($order->amount_charged, 0, ',', '.') ? 'Rp ' . number_format($order->amount_charged, 0, ',', '.') : '-' }}
                    </div>

                    {{-- Status --}}
                    <div class="col-span-2 flex items-center space-x-1">
                        @if($order->status === 'Paid')
                            <span class="text-green-600 font-medium">Paid</span>
                            {{-- Check icon (inline SVG) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                        @elseif($order->status === 'Unpaid')
                            <span class="text-red-600 font-medium">Unpaid</span>
                            {{-- Cross icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 11-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd" />
                            </svg>
                        @elseif($order->status === 'Cancelled')
                            <span class="text-red-600 font-medium">Cancelled</span>
                            {{-- Cross icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 11-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <span class="text-gray-600">—</span>
                        @endif
                    </div>

                    {{-- Action: cancel (X) --}}
                    <div class="col-span-2 flex justify-center">
                        @if($order->status !== 'Cancelled' && $order->status !== 'Paid')
                            <button 
                                @click="confirmCancel({{ $order->id }})" 
                                class="text-red-600 hover:text-red-800"
                                title="Cancel order"
                            >
                                {{-- X icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 11-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            {{-- Hidden cancel form --}}
                            <form 
                                id="cancel-form-{{ $order->id }}" 
                                method="POST" 
                                action="{{ route('admin.orders.cancel', $order) }}" 
                                x-ref="form_{{ $order->id }}" 
                                class="hidden"
                            >
                                @csrf
                                {{-- preserve current status filter in query string --}}
                                <input type="hidden" name="status" value="{{ $currentStatus }}">
                            </form>
                        @else
                            {{-- No action if already paid or cancelled --}}
                            <span class="text-gray-400">—</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-gray-600">
                    No orders found.
                </div>
            @endforelse
        </div>

        {{-- Bottom Done button (for marking selected orders done? In your image, there is a "Done" button) --}}
        {{-- 
           If this “Done” button is for bulk marking selected orders as done,
           you’ll need additional logic/controllers. Here we replicate the look:
        --}}
        <div class="mt-4 flex justify-end">
            <button 
                type="button" 
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
                {{-- In your design it's labeled "Done". If you need functionality, add @click or form here. --}}
            >
                Done
            </button>
        </div>
    </div>

    {{-- Cancel Confirmation Modal --}}
    <template x-if="showModal">
        <div 
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        >
            <div class="bg-[#FFFDD0] rounded-lg p-6 w-80 text-center">
                <p class="text-lg font-medium text-black mb-6">Are you sure to cancel this order?</p>
                <div class="flex justify-center space-x-4">
                    {{-- No button --}}
                    <button 
                        type="button" 
                        @click="closeModal()" 
                        class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition"
                    >
                        No
                    </button>
                    {{-- Yes button --}}
                    <button 
                        type="button" 
                        @click="submitCancel()" 
                        class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition"
                    >
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

{{-- Alpine.js component script --}}
@push('scripts')
<script>
    function orderPage() {
        return {
            showModal: false,
            cancelOrderId: null,

            confirmCancel(orderId) {
                this.cancelOrderId = orderId;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.cancelOrderId = null;
            },
            submitCancel() {
                if (this.cancelOrderId) {
                    // Submit the corresponding hidden form
                    let formId = 'cancel-form-' + this.cancelOrderId;
                    let form = document.getElementById('cancel-form-' + this.cancelOrderId);
                    if (form) {
                        form.submit();
                    }
                }
                this.closeModal();
            }
        };
    }
</script>
@endpush

@endsection
