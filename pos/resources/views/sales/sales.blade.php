<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a class="bg-blue-500 text-white px-4 py-2 rounded">
                    Filter
                </a>
            </div>

            <!-- Sales Table -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Customer Name
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                colspan="2">
                                Orders
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Total Amount
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300"
                                rowspan="2">
                                Paid
                            </th>
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
                        </tr>
                    </thead>
                    <tbody>
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
                                <div>{{ $menu ? $menu->name : 'Menu not found' }}</div>
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
                                <input type="checkbox" {{ $order->isPaid ? 'checked' : '' }} class="payment-checkbox"
                                data-order-id="{{ $order->id }}" disabled readonly/>
                            </td>
                        </tr>
                        @endforeach
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

    </script>

</x-app-layout>
