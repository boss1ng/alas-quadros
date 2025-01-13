<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-end mb-4">
                <!-- Filter Section -->
                <label for="filter" class="mr-2 text-lg font-large text-gray-500 dark:text-gray-300">Filter by:</label>
                <div class="relative">
                    <select id="filter" name="filter" class="bg-blue-500 text-white px-4 py-2 rounded">
                        <option value="-" {{ request('filter')=='-' ? 'selected' : '' }}>All</option>
                        <option value="daily" {{ request('filter')=='daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ request('filter')=='weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('filter')=='monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ request('filter')=='yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="custom" {{ request('filter')=='custom' ? 'selected' : '' }}>Custom Date</option>
                    </select>
                </div>

                <!-- Custom Date Range Fields -->
                <div id="custom-date-range" class="flex ml-5 items-center space-x-3" style="display: none;">
                    <input type="date" id="start-date" name="start_date"
                        class="bg-gray-200 text-gray-900 px-3 py-2 rounded dark:bg-gray-700 dark:text-gray-300"
                        value="{{ request('start_date') }}">
                    <span class="text-gray-500 dark:text-gray-300">to</span>
                    <input type="date" id="end-date" name="end_date"
                        class="bg-gray-200 text-gray-900 px-3 py-2 rounded dark:bg-gray-700 dark:text-gray-300"
                        value="{{ request('end_date') }}">
                </div>

                <!-- Generate Report -->
                <div class="ml-5">
                    <a href="{{ route('sales.pdf', [
                        'filter' => request('filter', '-'),
                        'start_date' => request('filter') == 'custom' ? request('start_date') : null,
                        'end_date' => request('filter') == 'custom' ? request('end_date') : null,
                    ]) }}" class="bg-green-500 text-white px-4 py-3 rounded hover:bg-green-600">
                        Generate Report
                    </a>
                </div>
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

                    <!-- Footer Row for Total Sales (Only on Last Page) -->
                    @if ($orders->currentPage() == $orders->lastPage())
                        <tfoot class="w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <td colspan="3"
                                    class="px-6 py-4 text-end whitespace-nowrap text-lg font-medium text-gray-800 dark:text-gray-200">
                                    TOTAL SALES
                                </td>
                                <td colspan="1" class="px-6 py-4 text-center text-lg font-semibold text-gray-600 dark:text-white">
                                    PHP {{ number_format($totalSales, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <script>
        const filterDropdown = document.getElementById('filter');
            const customDateRange = document.getElementById('custom-date-range');
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');

            // Toggle custom date range visibility based on selected filter
            filterDropdown.addEventListener('change', function () {
                const filterValue = this.value;

                if (filterValue === 'custom') {
                    customDateRange.style.display = 'flex';
                } else {
                    customDateRange.style.display = 'none';
                }

                // Update query parameters
                const url = new URL(window.location.href);
                url.searchParams.set('filter', filterValue);
                if (filterValue !== 'custom') {
                    url.searchParams.delete('start_date');
                    url.searchParams.delete('end_date');
                }
                window.location.href = url.toString();
            });

            // Auto-submit when dates are selected
            [startDateInput, endDateInput].forEach(input => {
                input.addEventListener('change', () => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('filter', 'custom');
                    url.searchParams.set('start_date', startDateInput.value);
                    url.searchParams.set('end_date', endDateInput.value);
                    window.location.href = url.toString();
                });
            });

            // Show custom date range if already selected
            if (filterDropdown.value === 'custom') {
                customDateRange.style.display = 'flex';
            }
    </script>

</x-app-layout>
