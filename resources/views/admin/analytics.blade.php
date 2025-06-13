{{-- resources/views/admin/analytics.blade.php --}}
@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="space-y-4">
    {{-- Outer container box, matching other pages (light background with border) --}}
    <div class="border border-gray-300 rounded bg-[#FFFEE0] p-4 space-y-4">

        {{-- Header --}}
        <h2 class="text-lg font-semibold text-black">Analytics</h2>

        {{-- Metrics placeholders: three cards with default "0" --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Total Sales --}}
            <div class="bg-white border border-gray-300 rounded p-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-600 mb-2">Total Sales</h3>
                <p id="total-sales" class="text-2xl font-semibold text-gray-800">
                    {{-- Placeholder value --}}
                    0
                </p>
            </div>
            {{-- Cancelled Orders --}}
            <div class="bg-white border border-gray-300 rounded p-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-600 mb-2">Cancelled Orders</h3>
                <p id="cancelled-orders" class="text-2xl font-semibold text-gray-800">
                    0
                </p>
            </div>
            {{-- Web Visitors --}}
            <div class="bg-white border border-gray-300 rounded p-4 shadow-sm">
                <h3 class="text-sm font-medium text-gray-600 mb-2">Web Visitors</h3>
                <p id="web-visitors" class="text-2xl font-semibold text-gray-800">
                    0
                </p>
            </div>
        </div>

        {{-- Graph placeholder --}}
        <div>
            <h3 class="text-md font-medium text-gray-700 mb-2">Graph</h3>
            {{-- Option A: a gray box placeholder --}}
            <div class="bg-gray-300 rounded h-48"></div>

            {{-- Option B: if you plan to use Chart.js later, you can include a <canvas> with an ID:
            <canvas id="analyticsChart" class="w-full h-48 bg-gray-100"></canvas>
            --}}
        </div>
    </div>
</div>

{{-- If you want to inject real data later via JS, you can add script placeholders here --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Example: later you can fetch real data via AJAX or embed data from backend.
        // For now, these remain placeholders:
        // document.getElementById('total-sales').textContent = 'Rp ' + (fetchedSales || 0);
        // document.getElementById('cancelled-orders').textContent = fetchedCancelled || 0;
        // document.getElementById('web-visitors').textContent = fetchedVisitors || 0;
        //
        // And for the graph, you can later initialize Chart.js on the <canvas> if you switch to Option B.
    });
</script>
@endpush
@endsection
