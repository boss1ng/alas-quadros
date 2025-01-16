<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Discount Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Edit Discount Form --}}
                <div class="bg-white rounded-lg shadow-lg w-full p-6">
                    <form id="orderForm" method="POST" action="{{ route('updateDiscount', ['id' => $discount->id]) }}">
                        @csrf

                        <div class="mb-5">
                            <!-- Name -->
                            <div class="flex-1 mb-5">
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                                <input type="text" name="name" id="name" value="{{ $discount->name }}" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Discount Percentage -->
                            <div class="flex-1 mb-5">
                                <label for="discount" class="block text-gray-700 font-semibold mb-2">Discount</label>
                                <input type="number" name="discount" id="discount" value="{{ $discount->discount }}" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                @error('discount') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('discount') }}"
                                class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400 inline-block">
                                Cancel
                            </a>
                            <button type="submit" id="submitButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                                Update
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get references to the form fields and the submit button
            const nameField = document.getElementById('name');
            const discountField = document.getElementById('discount');
            const submitButton = document.getElementById('submitButton');

            // Store the initial values of the fields
            const initialName = nameField.value;
            const initialDiscount = discountField.value;

            // Function to check if any field has changed
            function checkChanges() {
                if (
                    nameField.value !== initialName ||
                    discountField.value !== initialDiscount
                ) {
                    submitButton.disabled = false; // Enable the submit button
                } else {
                    submitButton.disabled = true; // Keep the submit button disabled
                }
            }

            // Add event listeners to fields to track changes
            nameField.addEventListener('input', checkChanges);
            discountField.addEventListener('input', checkChanges);
        });
    </script>
</x-app-layout>
