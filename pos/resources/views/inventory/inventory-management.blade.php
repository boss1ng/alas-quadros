<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div id="success-message" class="bg-green-500 text-white p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="flex items-center justify-end mb-4">
                <!-- New Item Button -->
                {{-- <a href="{{ route('newItem') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    New Item
                </a> --}}
            </div>

            <!-- Sales Table -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-lg font-large text-gray-500 dark:text-gray-300">
                                FS Code
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">
                                Item Name
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">
                                Quantity
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">
                                Unit of Measurement
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">
                                Price per item
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">
                                Total
                            </th>
                            <th
                                class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventories as $inventory)
                        <tr
                            class="border-t text-center border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td
                                class="text-left px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                {{ $inventory->fscode }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                {{ $inventory->itemName }}
                            </td>
                            <td
                                class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                {{ $inventory->quantity }}
                            </td>
                            <td
                                class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                {{ $inventory->unitOfMeasurement }}
                            </td>
                            <td
                                class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                PHP {{ number_format($inventory->pricePerItem, 2) }}
                            </td>
                            <td
                                class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                PHP {{ number_format($inventory->total, 2) }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                {{-- <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('editOrder', ['id' => $inventory->id]) }}"
                                        class="inline-block px-4 py-2 bg-yellow-500 text-white text-md font-medium rounded hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('deleteOrder', ['id' => $inventory->id]) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white text-md font-medium rounded hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            {{-- <div class="mt-4">
                {{ $inventories->links() }}
            </div> --}}
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

</x-app-layout>
