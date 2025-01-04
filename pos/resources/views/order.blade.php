<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Order Form --}}
                <div class="bg-white rounded-lg shadow-lg w-full p-6">
                    <form id="orderForm" method="POST" action="{{ route('placeOrder') }}">
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
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Select Menu Items</label>
                            @foreach($menus as $menu)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="checkbox" name="orders[{{ $menu->id }}][selected]" value="1"
                                    id="menu_{{ $menu->id }}" class="rounded">
                                <label for="menu_{{ $menu->id }}" class="flex-grow">{{ $menu->name }} - ${{ $menu->price
                                    }}</label>
                                <input type="number" name="orders[{{ $menu->id }}][quantity]" min="1" value="1"
                                    class="w-16 border-gray-300 rounded-lg focus:ring focus:ring-blue-500"
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
</x-app-layout>
