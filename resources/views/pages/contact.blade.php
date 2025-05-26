<x-app-layout>
    <section class="min-h-screen bg-yellow-100 flex items-center justify-center px-6 py-12">
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
            <!-- Left Info Panel -->
            <div>
                <h2 class="text-3xl font-semibold mb-6">Get in touch.</h2>
                <p class="mb-4">Curios about something? We’re here to help.</p>
                <p class="mb-4">
                    We do our best to respond to emails within 48 hours (and are even faster on Instagram).
                </p>
                <p>Wholesales &amp; Bulk Inquiries:<br><a href="mailto:email@email.com" class="underline">email@email.com</a></p>
            </div>

            <!-- Contact Form -->
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-gray-500 text-xs">(required)</span></label>
                        <input type="text" id="first_name" name="first_name" required class="w-full border border-gray-400 bg-gray-200 px-4 py-2 rounded">
                    </div>
                    <div class="flex-1">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="w-full border border-gray-400 bg-gray-200 px-4 py-2 rounded">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-gray-500 text-xs">(required)</span></label>
                    <input type="email" id="email" name="email" required class="w-full border border-gray-400 bg-gray-200 px-4 py-2 rounded">
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject <span class="text-gray-500 text-xs">(required)</span></label>
                    <input type="text" id="subject" name="subject" required class="w-full border border-gray-400 bg-gray-200 px-4 py-2 rounded">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message <span class="text-gray-500 text-xs">(required)</span></label>
                    <textarea id="message" name="message" rows="5" required class="w-full border border-gray-400 bg-gray-200 px-4 py-2 rounded resize-none"></textarea>
                </div>

                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded transition duration-200">
                    Submit
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
