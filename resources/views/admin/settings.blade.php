@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div x-data="settingsPage()" class="space-y-4">

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

    {{-- Container box matching design style --}}
    <div class="border border-gray-300 rounded bg-[#FFFEE0] p-4">
        <h2 class="text-lg font-semibold text-black mb-4">Settings</h2>

        {{-- Table header row --}}
        <div class="grid grid-cols-12 bg-gray-200 text-gray-700 font-medium text-sm px-2 py-2 rounded-t">
            {{-- Admin name --}}
            <div class="col-span-4">Admin</div>
            {{-- Role --}}
            <div class="col-span-3">Role</div>
            {{-- Permission --}}
            <div class="col-span-3">Permission</div>
            {{-- Remove --}}
            <div class="col-span-2 text-center">Remove</div>
        </div>

        {{-- List of admin users --}}
        <div>
            @forelse($adminUsers as $user)
                <div class="grid grid-cols-12 items-center border-t border-gray-200 bg-gray-100 even:bg-gray-200 px-2 py-3">
                    {{-- Admin name --}}
                    <div class="col-span-4 text-gray-800 font-medium">
                        {{ $user->name }}
                    </div>
                    {{-- Role --}}
                    <div class="col-span-3 text-gray-800">
                        @if($user->hasRole('Owner'))
                            Owner
                        @elseif($user->hasRole('Admin'))
                            Admin
                        @else
                            {{-- If using simple role column: $user->role --}}
                            {{ $user->role ?? '—' }}
                        @endif
                    </div>
                    {{-- Permission --}}
                    <div class="col-span-3 text-gray-800">
                        {{-- You may derive permission string. For simplicity: Full Access for both Owner/Admin --}}
                        Full Access
                    </div>
                    {{-- Remove button --}}
                    <div class="col-span-2 flex justify-center">
                        {{-- Only show remove if user is Admin (not Owner) --}}
                        @if($user->hasRole('Admin') && auth()->user()->hasRole('Owner'))
                            <button type="button"
                                @click="confirmRemove({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                class="text-red-600 hover:text-red-800"
                                title="Remove admin access"
                            >
                                {{-- X icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 11-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            {{-- Hidden form for removal --}}
                            <form 
                                id="remove-form-{{ $user->id }}" 
                                method="POST" 
                                action="{{ route('admin.settings.destroy', $user) }}" 
                                x-ref="form_{{ $user->id }}" 
                                class="hidden"
                            >
                                @csrf
                                @method('DELETE')
                            </form>
                        @else
                            {{-- No remove action (either Owner or current user cannot remove) --}}
                            <span class="text-gray-400">—</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-4 text-center text-gray-600">
                    No admin users found.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Confirmation Modal for removal --}}
    <template x-if="showModal">
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-[#FFFDD0] rounded-lg p-6 w-80 text-center">
                <p class="text-lg font-medium text-black mb-4">
                    Are you sure you want to remove admin access for
                    <span class="font-semibold" x-text="selectedName"></span>?
                </p>
                <div class="flex justify-center space-x-4">
                    <button 
                        type="button" 
                        @click="closeModal()" 
                        class="bg-gray-400 text-white px-4 py-2 rounded-full hover:bg-gray-500 transition"
                    >
                        No
                    </button>
                    <button 
                        type="button" 
                        @click="submitRemove()" 
                        class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition"
                    >
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
    function settingsPage() {
        return {
            showModal: false,
            selectedUserId: null,
            selectedName: '',

            confirmRemove(userId, userName) {
                this.selectedUserId = userId;
                this.selectedName = userName;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.selectedUserId = null;
                this.selectedName = '';
            },
            submitRemove() {
                if (this.selectedUserId) {
                    const formId = 'remove-form-' + this.selectedUserId;
                    const form = document.getElementById(formId);
                    if (form) {
                        form.submit();
                    }
                }
                this.closeModal();
            }
        }
    }
</script>
@endpush

@endsection
