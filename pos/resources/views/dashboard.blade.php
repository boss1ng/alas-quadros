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

                {{-- Insert here the cards containing the graphs/charts/etc. --}}
                {{--
                    3 cards at top:
                        1. Today's Order
                        2. Today's Sales
                        3. Registered Users

                    3 Graphs below it
                        1. Sales Report
                        2. By Product Sales
                --}}

            </div>
        </div>
    </div>
</x-app-layout>
