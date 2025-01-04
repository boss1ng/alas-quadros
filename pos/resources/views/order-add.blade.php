<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div id="success-message" class="bg-green-500 text-white p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Order Form --}}
                <div class="bg-white rounded-lg shadow-lg w-full p-6">
                    <form id="orderForm" method="POST" action="{{ route('createOrder') }}">
                        @csrf

                        <!-- Customer Name -->
                        <div class="mb-4">
                            <label for="customerName" class="block text-gray-700 font-semibold mb-2">Customer
                                Name</label>
                            <input type="text" name="customer_name" id="customerName" required
                                class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                            @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Menu Items -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            @foreach($menus as $menu)
                            <div class="card bg-white dark:bg-white border rounded-lg shadow-lg p-4 flex flex-col items-center cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-2xl"
                                data-menu-id="{{ $menu->id }}" id="menuCard_{{ $menu->id }}">

                                <!-- Checkbox for each menu item -->
                                <input type="checkbox" name="orders[{{ $menu->id }}][selected]" value="1"
                                    id="menu_{{ $menu->id }}" class="opacity-0 absolute z-10 peer">

                                <!-- Card Content -->
                                <label for="menu_{{ $menu->id }}"
                                    class="w-full text-center block peer-checked:bg-gray-200 dark:peer-checked:bg-gray-200 transition-all duration-300 ease-in-out">
                                    <div class="text-center">
                                        <div class="flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }} "
                                                class="w-32 h-32 object-cover mb-2 rounded-lg">
                                        </div>
                                        <h4 class="font-semibold text-lg">{{ $menu->name }}</h4>
                                        <p class="text-gray-600 mb-2">PHP {{ number_format($menu->price, 2) }}</p>
                                    </div>
                                </label>

                                <!-- Quantity Input (enabled/disabled by checkbox state) -->
                                <input type="number" name="orders[{{ $menu->id }}][quantity]" min="1" value="1"
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500 mt-2 peer-checked:opacity-100 peer-checked:enabled text-center"
                                    placeholder="Qty" disabled>
                            </div>
                            @endforeach
                        </div>

                        <!-- Total Price -->
                        <div class="mb-4">
                            <label for="totalPrice" class="block text-gray-700 font-semibold mb-2">Total Price</label>
                            <input type="text" id="totalPrice" name="total_price" readonly
                                class="w-full border-gray-300 rounded-lg bg-gray-100">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Place Order</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Check if the success message is present
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            // Hide the success message after 3 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3000ms = 3 seconds
        }

        // Add event listeners to toggle checkbox selection and update total price
        document.querySelectorAll('.card').forEach(card => {
            const checkbox = card.querySelector('input[type="checkbox"]');
            const quantityInput = card.querySelector('input[type="number"]');

            checkbox.addEventListener('change', function() {
                // Enable/disable the quantity input based on the checkbox state
                quantityInput.disabled = !checkbox.checked;

                // Update the total price
                updateTotalPrice();
            });

            quantityInput.addEventListener('input', function() {
                // Update the total price when quantity changes
                updateTotalPrice();
            });
        });

        // Update total price dynamically and send numeric value
        function updateTotalPrice() {
            let totalPrice = 0;

            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
            const card = checkbox.closest('.card');
            const price = parseFloat(card.querySelector('p').innerText.replace('PHP ', '').replace(',', ''));
            const quantity = parseInt(card.querySelector('input[type="number"]').value);
            totalPrice += price * quantity;
            });

            document.getElementById('totalPrice').value = totalPrice.toFixed(2); // Send numeric value only
        }
    </script>

</x-app-layout>
