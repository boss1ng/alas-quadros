<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div id="alertMessage" class="bg-green-500 text-white p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div id="alertMessage" class="bg-red-500 text-white p-4 mb-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex items-center justify-end mb-4 space-x-3">
                <!-- In/Out Item Button -->
                <button id="openInModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded">
                    In
                </button>
                <button id="openOutModalBtn" class="bg-red-500 text-white px-4 py-2 rounded">
                    Out
                </button>
            </div>

            @foreach($inventories as $category => $items)
            <!-- Category Table -->
            <div class="mt-4">
                <h2 class="text-2xl font-semibold mb-4 text-black dark:text-white">{{ $category === 'zzz' ? 'Others' : $category }}</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Item Name</th>

                                {{-- @if ($category !== 'zzz')
                                    <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Category</th>
                                @endif --}}

                                {{-- <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Category</th> --}}

                                <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Quantity</th>
                                <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Unit of
                                    Measurement</th>
                                <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Quantity per
                                    Box</th>
                                <th class="px-6 py-3 text-center text-lg font-large text-gray-500 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $inventory)
                            <tr
                                class="border-t text-center border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{$inventory->itemName }}
                                </td>

                                {{-- @if ($category !== 'zzz')
                                    <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                        {{$inventory->category }}
                                    </td>
                                @endif --}}

                                {{-- <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{$inventory->category === 'zzz' ? '' : $inventory->category }}
                                </td> --}}

                                <td
                                    class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $inventory->quantity }}
                                    @if($inventory->quantity <= 2) <p class="text-red-500">!NOTICE</p>
                                        @endif
                                </td>
                                <td
                                    class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $inventory->unitOfMeasurement }}</td>
                                <td
                                    class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $inventory->quantityPerPackage ? $inventory->quantityPerPackage . ' pieces' : '---' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    <div class="flex items-center justify-center space-x-2">
                                        <form action="{{ route('deleteItem', ['id' => $inventory->id]) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 text-white text-md font-medium rounded hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for Inventory -->
    <div id="inventoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 relative">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 id="modalTitle" class="text-lg font-semibold">Inventory Form</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <div class="mt-4 overflow-y-auto" style="max-height: 500px;">
                <form id="inventoryForm" method="POST" action="{{ route('inventoryInOut') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Item Name Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Item Name</label>
                        <select id="itemName" name="itemName" class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500"
                            onchange="toggleCustomInput()">
                            <option value="" disabled selected>Select an item</option>
                            <option value="Mayonnaise">Mayonnaise</option>
                            <option value="Chicken">Chicken</option>
                            <option value="Sibuyas">Sibuyas</option>
                            <option value="Bawang">Bawang</option>
                            <option value="Custom">- Custom -</option>
                        </select>

                        <!-- Custom Item Name Input -->
                        <div id="customItemNameDiv" class="mt-2 hidden">
                            <input type="text" name="itemName" id="customItemName"
                                class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500" placeholder="Enter item name">
                        </div>

                        @error('itemName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category Field -->
                    <div class="mb-4" id="category">
                        <label class="block text-gray-700 font-semibold mb-2">Category</label>
                        <select name="category" class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                            <option value="" disabled selected>Select a category</option>
                            <option value="Spices">Spices</option>
                            <option value="Meat">Meat</option>
                            <option value="Others">Others</option>
                        </select>
                        @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Quantity Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Quantity</label>
                        <input type="number" name="quantity"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Unit of Measurement Field -->
                    <div class="mb-4" id="unitOfMeasurement">
                        <label class="block text-gray-700 font-semibold mb-2">Unit of Measurement</label>
                        <select name="unitOfMeasurement" class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                            <option value="" disabled selected>Select an item</option>
                            <option value="Boxes">Boxes</option>
                            <option value="Kilo">Kilo</option>
                            <option value="Pieces">Pieces</option>
                        </select>
                        @error('unitOfMeasurement') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Quantity per Box Field -->
                    <div class="mb-4" id="quantityPerPackage">
                        <label class="block text-gray-700 font-semibold mb-2">Quantity per Box</label>
                        <input type="number" name="quantityPerPackage"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('quantityPerPackage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Add a hidden input field to track the action -->
                    <input type="hidden" name="actionType" id="actionType" value="">
                </form>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <button id="cancelBtn" class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400">Cancel</button>
                <button id="inBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" style="display: none">In</button>
                <button id="outBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"style="display: none">Out</button>
            </div>
        </div>
    </div>

    <script>
        // Check if the success message is present
        const alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            // Hide the success message after 3 seconds
            setTimeout(() => {
                alertMessage.style.display = 'none';
            }, 3000); // 3000ms = 3 seconds
        }
    </script>

    <!-- JavaScript to handle modal functionality -->
    <script>
        function toggleCustomInput() {
            var select = document.getElementById("itemName");
            var customItemNameDiv = document.getElementById("customItemNameDiv");
            var customItemNameInput = document.getElementById("customItemName");

            if (select.value === "Custom") {
                customItemNameDiv.classList.remove("hidden");
                select.removeAttribute("name"); // Remove the name from select when Custom is selected
                customItemNameInput.setAttribute("name", "itemName"); // Set name for the custom input
            } else {
                customItemNameDiv.classList.add("hidden");
                select.setAttribute("name", "itemName"); // Restore the name to select
                customItemNameInput.removeAttribute("name"); // Remove name from custom input
            }
        }

        // Get elements
        const inventoryModal = document.getElementById('inventoryModal');

        const openInModalBtn = document.getElementById("openInModalBtn");
        const openOutModalBtn = document.getElementById("openOutModalBtn");

        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const inBtn = document.getElementById('inBtn');
        const outBtn = document.getElementById('outBtn');
        const modalTitle = document.getElementById('modalTitle');
        const inventoryForm = document.getElementById('inventoryForm');
        const actionTypeInput = document.getElementById('actionType');
        const quantityPerPackage = document.getElementById("quantityPerPackage");
        const category = document.getElementById("category");
        const unitOfMeasurement = document.getElementById("unitOfMeasurement");

        // Open IN modal
        openInModalBtn.addEventListener('click', () => {
            inventoryModal.classList.remove('hidden');
            modalTitle.innerText = 'Inventory Form';
            quantityPerPackage.style.display = "block"; // Show field
            category.style.display = "block"; // Show field
            unitOfMeasurement.style.display = "block"; // Show field
            inBtn.style.display = "block"; // Show button
            outBtn.style.display = "none"; // Hide button
        });

        // Open OUT modal
        openOutModalBtn.addEventListener('click', () => {
            inventoryModal.classList.remove('hidden');
            modalTitle.innerText = 'Inventory Form';
            quantityPerPackage.style.display = "none"; // Hide field
            category.style.display = "none"; // Hide field
            unitOfMeasurement.style.display = "none"; // Hide field
            inBtn.style.display = "none"; // Show button
            outBtn.style.display = "block"; // Hide button
        });

        // Close modal
        closeModalBtn.addEventListener('click', () => {
            inventoryModal.classList.add('hidden');
            inBtn.style.display = "none";
            outBtn.style.display = "none";
        });

        cancelBtn.addEventListener('click', () => {
            inventoryModal.classList.add('hidden');
            inBtn.style.display = "none";
            outBtn.style.display = "none";
        });

        // Handle "In" button click
        inBtn.addEventListener('click', () => {
            inBtn.style.display = "none";
            outBtn.style.display = "none";
            actionTypeInput.value = 'in'; // Set the action type to "in"
            inventoryForm.submit(); // Submit the form
        });

        // Handle "Out" button click
        outBtn.addEventListener('click', () => {
            inBtn.style.display = "none";
            outBtn.style.display = "none";
            actionTypeInput.value = 'out'; // Set the action type to "out"
            inventoryForm.submit(); // Submit the form
        });

        // Inventory Form
        inBtn.addEventListener('click', () => {
            inBtn.style.display = "none";
            outBtn.style.display = "none";
            inventoryForm.submit(); // Trigger form submission (or implement your own AJAX logic)
        });
        outBtn.addEventListener('click', () => {
            inBtn.style.display = "none";
            outBtn.style.display = "none";
            inventoryForm.submit(); // Trigger form submission (or implement your own AJAX logic)
        });
    </script>

</x-app-layout>
