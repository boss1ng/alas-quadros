<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (Auth::user()->role === "admin" || Auth::user()->role === "cashier")
            <div class="min-w-full mx-auto sm:px-6 lg:px-8">

        @elseif (Auth::user()->role === "cook")
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @endif

        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            @if(session('success'))
            <div id="success-message" class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="flex justify-end mb-4">
                @if (Auth::user()->role === "admin" || Auth::user()->role === "cashier")
                    <!-- Place Order Button -->
                    <a href="{{ route('placeOrder') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Place Order
                    </a>
                @endif
            </div>

            <!-- Order Table -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                colspan="2">
                                Orders
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Total
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                colspan="2">
                                Paid
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Cooking
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Served
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Notes
                            </th>
                            @if (Auth::user()->role === "admin" || Auth::user()->role === "cashier")
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Actions
                            </th>
                            @endif
                        </tr>
                        <tr>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Menu
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Quantity
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Cash
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                GCash
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                    No records found in Orders.
                                </td>
                            </tr>
                        @else
                            @foreach($orders as $order)
                            <tr
                                class="border-t border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $order->customer_name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-md text-gray-600 dark:text-gray-400 text-center">
                                    @foreach(json_decode($order->orders) as $item)
                                    {{-- Find the menu name by matching menu_id --}}
                                    @php
                                    $menu = $menus->firstWhere('id', $item->menu_id);
                                    @endphp
                                        @if (Auth::user()->role === "admin" || Auth::user()->role === "cashier")
                                            <div>{{ $menu ? $menu->name : 'Menu not found' }}</div>
                                        @elseif (Auth::user()->role === "cook")
                                            @if ($menu !== null)
                                                <div>{{ $menu->acronym ? $menu->acronym : $menu->name }}</div>
                                            @else
                                                <div>Menu not found</div>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-md text-gray-600 dark:text-gray-400 text-center">
                                    @foreach(json_decode($order->orders) as $item)
                                    <div>{{ $item->quantity }}</div>
                                    @endforeach
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-md text-gray-600 dark:text-gray-400 text-center">
                                    PHP {{ number_format($order->total_price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" {{ $order->isPaidCash ? 'checked' : '' }} class="cash-payment-checkbox" data-order-id="{{ $order->id }}"/>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" {{ $order->isPaidGCash ? 'checked' : '' }} class="gcash-payment-checkbox" data-order-id="{{ $order->id }}"/>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" {{ $order->isCooking ? 'checked' : '' }} class="cooking-checkbox" data-order-id="{{ $order->id }}"/>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" {{ $order->isServed ? 'checked' : '' }} class="serving-checkbox" data-order-id="{{ $order->id }}"/>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-md text-gray-600 dark:text-gray-400 text-center">
                                    {{ $order->notes }}
                                </td>
                                @if (Auth::user()->role === "admin" || Auth::user()->role === "cashier")
                                <td class="px-6 py-4 whitespace-nowrap text-md">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- <a href="{{ route('editOrder', ['id' => $order->id]) }}"
                                            class="inline-block px-4 py-2 bg-yellow-500 text-white text-md font-medium rounded hover:bg-yellow-600 transition">
                                            Edit
                                        </a> --}}
                                        <form action="{{ route('deleteOrder', ['id' => $order->id]) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 text-white text-md font-medium rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $orders->links() }}
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

        // Event listener for checkbox click
        document.querySelectorAll('.cash-payment-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const isChecked = this.checked;
                const orderId = this.getAttribute('data-order-id');

                // Send the AJAX request to update the payment status
                fetch(`/order/update-payment-cash/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        isPaidCash: isChecked
                    })
                })
                .then(response => console.log("Updated payment."))
            });
        });
        document.querySelectorAll('.gcash-payment-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const isChecked = this.checked;
                const orderId = this.getAttribute('data-order-id');

                // Send the AJAX request to update the payment status
                fetch(`/order/update-payment-gcash/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        isPaidGCash: isChecked
                    })
                })
                .then(response => console.log("Updated payment."))
            });
        });
        document.querySelectorAll('.cooking-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const isChecked = this.checked;
                const orderId = this.getAttribute('data-order-id');

                // Send the AJAX request to update the payment status
                fetch(`/order/update-cooking/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        isCooking: isChecked
                    })
                })
                .then(response => console.log("Updated cooking status."))
            });
        });
        document.querySelectorAll('.serving-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const isChecked = this.checked;
                const orderId = this.getAttribute('data-order-id');

                // Send the AJAX request to update the payment status
                fetch(`/order/update-served/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        isServed: isChecked
                    })
                })
                .then(response => console.log("Updated serving status."))
            });
        });
    </script>

</x-app-layout>
