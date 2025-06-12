{{-- resources/views/admin/products.blade.php --}}
@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div x-data="productPage()" class="space-y-4">

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

    {{-- Main container box --}}
    <div class="border border-gray-300 rounded bg-[#FFFEE0] p-4">
        {{-- Header --}}
        <h2 class="text-lg font-semibold text-black mb-4">Products</h2>

        {{-- Table Header --}}
        <div class="grid grid-cols-12 bg-gray-300 text-gray-700 font-medium text-sm px-2 py-2 rounded-t">
            <div class="col-span-1 flex items-center justify-center">
                <input type="checkbox" disabled>
            </div>
            <div class="col-span-4">Product Name</div>
            <div class="col-span-2">Unit Price</div>
            <div class="col-span-2">Ready</div>
            <div class="col-span-1 text-center">Sales</div>
            <div class="col-span-2 text-center">Action</div>
        </div>

        {{-- Rows container --}}
        <div>

            {{-- Add New Product Row (shown when showNew=true) --}}
            <template x-if="showNew">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
                      class="grid grid-cols-12 items-center border-t border-gray-200 bg-gray-100 px-2 py-3">
                    @csrf
                    {{-- Checkbox placeholder --}}
                    <div class="col-span-1 flex items-center justify-center">
                        {{-- empty or disabled --}}
                    </div>
                    {{-- Image upload + name --}}
                    <div class="col-span-4 flex items-center space-x-2">
                        <input type="file" name="image" class="w-16 h-16 border rounded" required>
                        <input type="text" name="name" placeholder="Product name"
                               class="w-full border rounded px-2 py-1" required>
                    </div>
                    {{-- Unit Price --}}
                    <div class="col-span-2">
                        <input type="number" name="unit_price" step="0.01" placeholder="0.00"
                               class="w-full border rounded px-2 py-1" required>
                    </div>
                    {{-- Ready select --}}
                    <div class="col-span-2 flex items-center">
                        <select name="ready" class="border rounded px-2 py-1">
                            <option value="1">Ready</option>
                            <option value="0">Not Ready</option>
                        </select>
                    </div>
                    {{-- Sales (readonly, default 0) --}}
                    <div class="col-span-1 text-center">
                        <input type="number" name="sales" value="0"
                               class="w-full border rounded px-2 py-1 text-center" readonly>
                    </div>
                    {{-- Actions: Cancel / Save --}}
                    <div class="col-span-2 flex justify-center space-x-2">
                        <button type="button" @click="cancelNew"
                                class="bg-red-600 text-white px-3 py-1 rounded-full hover:bg-red-700 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-green-500 text-white px-3 py-1 rounded-full hover:bg-green-600 transition">
                            Save
                        </button>
                    </div>
                </form>
            </template>

            {{-- Existing product rows --}}
            @foreach($products as $product)
                {{-- Display mode --}}
                <template x-if="editingId !== {{ $product->id }}">
                    <div class="grid grid-cols-12 items-center border-t border-gray-200 bg-gray-100 even:bg-gray-200 px-2 py-3">
                        {{-- Checkbox --}}
                        <div class="col-span-1 flex items-center justify-center">
                            <input type="checkbox" name="select_product[]" value="{{ $product->id }}">
                        </div>
                        {{-- Image + Name --}}
                        <div class="col-span-4 flex items-center space-x-2">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-300 rounded"></div>
                            @endif
                            <span class="text-gray-800">{{ $product->name }}</span>
                        </div>
                        {{-- Unit Price --}}
                        <div class="col-span-2 text-gray-800">
                            {{-- Format as "Rp 200.000" --}}
                            Rp {{ number_format($product->unit_price, 0, ',', '.') }}
                        </div>
                        {{-- Ready status --}}
                        <div class="col-span-2 flex items-center space-x-1">
                            @if($product->ready)
                                <span class="text-green-600 font-medium">Ready</span>
                                {{-- Check icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <span class="text-red-600 font-medium">Not Ready</span>
                                {{-- Cross icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 11-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        {{-- Sales --}}
                        <div class="col-span-1 text-center text-gray-800">
                            {{ $product->sales }}
                        </div>
                        {{-- Action: Edit --}}
                        <div class="col-span-2 flex justify-center">
                            <button type="button" @click="startEdit({{ $product->id }})"
                                    class="text-gray-700 hover:text-gray-900" title="Edit">
                                {{-- Edit icon (pencil) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-5.586-5.586a2 2 0 112.828 2.828L11 16l-4 1 1-4 7.414-7.414z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                {{-- Edit mode for this product --}}
                <template x-if="editingId === {{ $product->id }}">
                    <form method="POST" action="{{ route('admin.products.update', $product) }}"
                          enctype="multipart/form-data"
                          class="grid grid-cols-12 items-center border-t border-gray-200 bg-gray-100 px-2 py-3"
                          x-ref="form_{{ $product->id }}">
                        @csrf
                        @method('PUT')
                        {{-- Checkbox placeholder --}}
                        <div class="col-span-1 flex items-center justify-center"></div>
                        {{-- Image preview + file input + name --}}
                        <div class="col-span-4 flex items-center space-x-2">
                            {{-- Preview image: Alpine will update src when file chosen --}}
                            @if($product->image_url)
                                <img x-ref="preview_{{ $product->id }}" 
                                     src="{{ $product->image_url }}" alt="Preview"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <img x-ref="preview_{{ $product->id }}" 
                                     src="" alt="Preview" class="w-16 h-16 object-cover rounded hidden">
                            @endif
                            <input type="file" name="image"
                                   @change="previewImage($event, {{ $product->id }})"
                                   class="border rounded px-2 py-1">
                            <input type="text" name="name" 
                                   value="{{ $product->name }}"
                                   class="w-full border rounded px-2 py-1" required>
                        </div>
                        {{-- Unit Price --}}
                        <div class="col-span-2">
                            <input type="number" name="unit_price"
                                   value="{{ $product->unit_price }}"
                                   step="0.01"
                                   class="w-full border rounded px-2 py-1" required>
                        </div>
                        {{-- Ready select --}}
                        <div class="col-span-2 flex items-center">
                            <select name="ready" class="border rounded px-2 py-1">
                                <option value="1" @if($product->ready) selected @endif>Ready</option>
                                <option value="0" @if(!$product->ready) selected @endif>Not Ready</option>
                            </select>
                        </div>
                        {{-- Sales --}}
                        <div class="col-span-1 text-center">
                            <input type="number" name="sales" value="{{ $product->sales }}"
                                   class="w-full border rounded px-2 py-1 text-center" min="0" required>
                        </div>
                        {{-- Actions: Cancel / Save --}}
                        <div class="col-span-2 flex justify-center space-x-2">
                            <button type="button" @click="cancelEdit"
                                    class="bg-red-600 text-white px-3 py-1 rounded-full hover:bg-red-700 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded-full hover:bg-green-600 transition">
                                Save
                            </button>
                        </div>
                    </form>
                </template>
            @endforeach

        </div>

        {{-- Add New Product button --}}
        <div class="mt-4 flex justify-end">
            <button type="button" @click="showNew = true" x-show="!showNew"
                    class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition">
                + Add New Product
            </button>
        </div>
    </div>
</div>

{{-- Alpine.js logic --}}
@push('scripts')
<script>
    function productPage() {
        return {
            editingId: null,
            showNew: false,
            /**
             * When clicking “Edit” on a product row:
             * set editingId so that the display row is replaced by the form row.
             */
            startEdit(id) {
                this.editingId = id;
                // Hide the “Add New” row if open
                this.showNew = false;
            },
            /**
             * Cancel editing: hide form, show display row again.
             */
            cancelEdit() {
                this.editingId = null;
            },
            /**
             * Cancel new-product row.
             */
            cancelNew() {
                this.showNew = false;
            },
            /**
             * Preview image on file input change.
             * Finds the <img x-ref="preview_<id>"> and updates its src.
             */
            previewImage(event, id) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    const img = this.$refs['preview_' + id];
                    if (img) {
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>
@endpush

@endsection
