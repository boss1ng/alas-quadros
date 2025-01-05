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
                    <h3 class="text-xl font-semibold text-gray-800">Sales Report (Last 7 Days)</h3>
                    <canvas id="salesChart"></canvas>
                </div>

                <!-- By Product Sales Graph -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800">Sales by Product (Last 30 Days)</h3>
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
        const productSalesData = @json($productSales);
        new Chart(productSalesChartCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(productSalesData),
                datasets: [{
                    label: 'Sales by Product (PHP)',
                    data: Object.values(productSalesData),
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Product' }
                    },
                    y: {
                        title: { display: true, text: 'Sales (PHP)' },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>
