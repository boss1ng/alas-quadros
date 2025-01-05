<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Today's Orders Card -->
                <div class="bg-blue-100 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-box text-blue-600 text-3xl"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-600">Today's Orders</h3>
                            <p class="text-3xl font-bold">{{ $todaysOrders }}</p>
                        </div>
                    </div>
                </div>

                <!-- Today's Sales Card -->
                <div class="bg-green-100 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-dollar-sign text-green-600 text-3xl"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-green-600">Today's Sales</h3>
                            <p class="text-3xl font-bold">PHP {{ number_format($todaysSales, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Registered Users Card -->
                <div class="bg-purple-100 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-users text-purple-600 text-3xl"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-purple-600">Registered Users</h3>
                            <p class="text-3xl font-bold">{{ $registeredUsers }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Graphs Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                <!-- Sales Report Graph -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-800">Sales Report</h3>

                        <!-- Sales Report Filter Form -->
                        <form method="GET" action="{{ route('dashboard') }}" class="inline-block">
                            <label for="filter_sales_report" class="mr-4">Filter by:</label>
                            <select name="filter_sales_report" id="filter_sales_report" class="px-4 py-2 border rounded-md"
                                style="width: 110px;" onchange="this.form.submit()">
                                <option value="weekly" {{ $filterSalesReport=='weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $filterSalesReport=='monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ $filterSalesReport=='yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>

                            <!-- Keep the filter_product_sales in the URL when the sales report filter is changed -->
                            <input type="hidden" name="filter_product_sales" value="{{ request('filter_product_sales', 'weekly') }}">
                        </form>
                    </div>

                    <canvas id="salesChart"></canvas>
                </div>

                <!-- By Product Sales Graph -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-800">By Product Sales</h3>

                        <!-- By Product Filter Form -->
                        <form method="GET" action="{{ route('dashboard') }}" class="inline-block">
                            <label for="filter_product_sales" class="mr-4">Filter by:</label>
                            <select name="filter_product_sales" id="filter_product_sales" class="px-4 py-2 border rounded-md"
                                style="width: 110px;" onchange="this.form.submit()">
                                <option value="weekly" {{ $filterProductSales=='weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $filterProductSales=='monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ $filterProductSales=='yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>

                            <!-- Keep the filter_sales_report in the URL when the product sales filter is changed -->
                            <input type="hidden" name="filter_sales_report" value="{{ request('filter_sales_report', 'weekly') }}">
                        </form>
                    </div>

                    <canvas id="productSalesChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Add JavaScript for Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sales Report Chart
        const salesChartCtx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json($salesData);
        new Chart(salesChartCtx, {
            type: 'line',
            data: {
                labels: Object.keys(salesData),
                datasets: [{
                    label: 'Total Sales (PHP)',
                    data: Object.values(salesData),
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Date' }
                    },
                    y: {
                        title: { display: true, text: 'Sales (PHP)' },
                        beginAtZero: true
                    }
                }
            }
        });

        // By Product Sales Chart
        const productSalesChartCtx = document.getElementById('productSalesChart').getContext('2d');
        const productSalesNames = @json($productSalesNames);
        const productSalesQuantities = @json($productSalesQuantities);

        console.log("Menus ", productSalesNames)
        console.log("Qty ", productSalesQuantities)

        new Chart(productSalesChartCtx, {
            type: 'bar',
            data: {
                labels: productSalesNames,
                datasets: [{
                    label: 'Quantity Sold',
                    data: productSalesQuantities,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Menu Items' }
                    },
                    y: {
                        title: { display: true, text: 'Quantity Sold' },
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

</x-app-layout>
