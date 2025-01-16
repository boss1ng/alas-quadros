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
                    <form id="orderForm" method="POST" action="{{ route('updateOrder', ['id' => $order->id]) }}">
                        @csrf

                        <div class="flex items-center justify-between mb-4">
                            <!-- Customer Name -->
                            <div class="flex-1">
                                <label for="customerName" class="block text-gray-700 font-semibold mb-2">Customer Name</label>
                                <input type="text" name="customer_name" id="customerName" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500"
                                    value="{{ old('customer_name', $order->customer_name) }}">
                                @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Dine-in or Take-out -->
                            <div class="flex-1 mx-5">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">Order Type</label>
                                    <div class="flex space-x-4">
                                        <label>
                                            <input type="radio" name="order_type" value="D/I" class="mr-2" required {{ old('order_type',
                                                $order->notes) == 'D/I' ? 'checked' : '' }}> Dine-In
                                        </label>
                                        <label>
                                            <input type="radio" name="order_type" value="T/O" class="mr-2" {{ old('order_type', $order->notes)
                                            == 'T/O' ? 'checked' : '' }}> Take-Out
                                        </label>
                                    </div>
                                    @error('order_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Discounts -->
                            <div class="flex-1">
                                <label for="discount" class="block text-gray-700 font-semibold mb-2">Discount</label>
                                <select name="discount" id="discount" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                    <option value="">- None -</option>
                                    @foreach($discounts as $discount)
                                    <option value="{{$discount->discount}}">{{$discount->name}}</option>
                                    @endforeach
                                </select>
                                @error('discount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            @foreach($menus as $menu)
                            <div class="card bg-white dark:bg-white border rounded-lg shadow-lg p-4 flex flex-col items-center cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-2xl"
                                data-menu-id="{{ $menu->id }}" id="menuCard_{{ $menu->id }}">

                                <!-- Checkbox for each menu item -->
                                <input type="checkbox" name="orders[{{ $menu->id }}][selected]" value="1"
                                    id="menu_{{ $menu->id }}" class="opacity-0 absolute z-10 peer"
                                    @if(in_array($menu->id, array_column($orderItems, 'menu_id'))) checked @endif>

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
                                @php
                                    $orderItem = collect($orderItems)->firstWhere('menu_id', $menu->id);
                                @endphp

                                <input type="number" name="orders[{{ $menu->id }}][quantity]" min="1" value="{{ $orderItem['quantity'] ?? 1 }}"
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500 mt-2 peer-checked:opacity-100 peer-checked:enabled text-center"
                                    placeholder="Qty" disabled>
                            </div>
                            @endforeach
                        </div>

                        <!-- Total Price -->
                        <div class="mb-4">
                            <label for="totalPrice" class="block text-gray-700 font-semibold mb-2">Total Price</label>
                            <input type="text" id="totalPrice" name="total_price" value="{{ $order->total_price }}"
                                readonly class="w-full border-gray-300 rounded-lg bg-gray-100">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('order') }}"
                                class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400 inline-block">
                                Cancel
                            </a>

                            <button type="submit" id="saveButton"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                disabled>Save</button>
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const originalState = {
                customerName: document.getElementById("customerName").value,
                orderType: document.querySelector('input[name="order_type"]:checked')?.value,
            };

            const saveButton = document.getElementById("saveButton");

            // Save the original state for the menu items
            const menuState = new Map();
            document.querySelectorAll('.card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                const quantityInput = card.querySelector('input[type="number"]');
                const menuId = card.getAttribute('data-menu-id');

                menuState.set(menuId, {
                    selected: checkbox.checked,
                    quantity: parseInt(quantityInput.value),
                });

                // Enable or disable quantity input on page load
                quantityInput.disabled = !checkbox.checked;
            });

            // Add event listeners for the customer name and order type fields
            const customerNameInput = document.getElementById("customerName");
            customerNameInput.addEventListener("input", toggleSaveButton);

            document.querySelectorAll('input[name="order_type"]').forEach(radio => {
                radio.addEventListener("change", toggleSaveButton);
            });

            // Add event listeners for menu items
            document.querySelectorAll('.card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                const quantityInput = card.querySelector('input[type="number"]');

                checkbox.addEventListener('change', () => {
                    quantityInput.disabled = !checkbox.checked;

                    if (checkbox.checked && quantityInput.disabled) {
                        quantityInput.value = 1; // Reset quantity to 1 if enabled
                    }

                    updateTotalPrice();
                    toggleSaveButton();
                });

                quantityInput.addEventListener('input', () => {
                    updateTotalPrice();
                    toggleSaveButton();
                });
            });

            function updateTotalPrice() {
                let totalPrice = 0;

                document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                    const card = checkbox.closest('.card');
                    const price = parseFloat(card.querySelector('p').innerText.replace('PHP ', '').replace(',', ''));
                    const quantity = parseInt(card.querySelector('input[type="number"]').value);
                    totalPrice += price * quantity;
                });

                document.getElementById('totalPrice').value = totalPrice.toFixed(2); // Numeric value only
            }

            function toggleSaveButton() {
                let hasChanges = false;

                // Check if the name or order type has changed
                if (
                    customerNameInput.value !== originalState.customerName ||
                    document.querySelector('input[name="order_type"]:checked')?.value !== originalState.orderType
                ) {
                    hasChanges = true;
                }

                // Check if any menu item has changed
                document.querySelectorAll('.card').forEach(card => {
                    const checkbox = card.querySelector('input[type="checkbox"]');
                    const quantityInput = card.querySelector('input[type="number"]');
                    const menuId = card.getAttribute('data-menu-id');

                    const original = menuState.get(menuId);
                    if (
                        checkbox.checked !== original.selected ||
                        (checkbox.checked && parseInt(quantityInput.value) !== original.quantity)
                    ) {
                        hasChanges = true;
                    }
                });

                saveButton.disabled = !hasChanges;
            }
        });
    </script>

</x-app-layout>
