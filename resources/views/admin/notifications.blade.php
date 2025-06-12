@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div x-data="notifPage()" class="space-y-4">

    {{-- Flash (optional) --}}
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

    {{-- Container box (matching Orders/Products style) --}}
    <div class="border border-gray-300 rounded bg-[#FFFEE0] p-4">
        <h2 class="text-lg font-semibold text-black mb-4">Notifications</h2>

        {{-- List of notifications --}}
        <div class="space-y-2">
            @forelse($notifications as $notif)
                <button
                    type="button"
                    @click="open(@json([
                        'id' => $notif->id,
                        'name' => $notif->name,
                        'email' => $notif->email,
                        'subject' => $notif->subject,
                        'message' => $notif->message,
                        'created_at' => $notif->created_at->format('Y-m-d H:i'),
                    ]))"
                    class="w-full text-left bg-gray-100 hover:bg-gray-200 border border-gray-200 rounded px-4 py-2 flex justify-between items-center"
                >
                    <div class="flex-1">
                        <span class="font-medium text-gray-800">{{ $notif->name }}</span>
                        <span class="text-gray-700"> - {{ $notif->subject }}</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $notif->created_at->format('Y-m-d H:i') }}
                    </div>
                </button>
            @empty
                <p class="text-gray-600">No notifications.</p>
            @endforelse
        </div>
    </div>

    {{-- Modal for details --}}
    <template x-if="showModal">
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-[#FFFDD0] rounded-lg p-6 w-11/12 max-w-lg">
                <h3 class="text-lg font-medium text-black mb-4">Notification Details</h3>
                <div class="space-y-2 text-gray-800">
                    <p><span class="font-medium">Name:</span> <span x-text="selected.name"></span></p>
                    <p><span class="font-medium">Email:</span> <span x-text="selected.email"></span></p>
                    <p><span class="font-medium">Subject:</span> <span x-text="selected.subject"></span></p>
                    <p><span class="font-medium">Submitted at:</span> <span x-text="selected.created_at"></span></p>
                    <div class="mt-4">
                        <p class="font-medium mb-1">Message:</p>
                        <p class="whitespace-pre-wrap" x-text="selected.message"></p>
                    </div>
                </div>
                <div class="mt-6 text-right">
                    <button
                        type="button"
                        @click="close()"
                        class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>

@push('scripts')
<script>
    function notifPage() {
        return {
            selected: {},
            showModal: false,
            open(notif) {
                this.selected = notif;
                this.showModal = true;
                // Optionally: mark as read via AJAX, so unread count updates
                fetch("{{ url('admin/notifications') }}/" + notif.id + "/read", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                }).then(response => {
                    if (response.ok) {
                        // Optionally: decrement the badge in the sidebar.
                        // We can dispatch a custom event, or update a DOM element if you gave it an ID.
                        // Example:
                        let badge = document.querySelector('a[href="{{ route('admin.notifications.index') }}"] span');
                        if (badge) {
                            let count = parseInt(badge.textContent) || 0;
                            if (count > 1) {
                                badge.textContent = count - 1;
                            } else {
                                // remove badge if zero
                                badge.remove();
                            }
                        }
                    }
                }).catch(err => {
                    console.error('Error marking notification read:', err);
                });
            },
            close() {
                this.showModal = false;
                this.selected = {};
            }
        }
    }
</script>
@endpush

@endsection
