<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div id="success-message" class="bg-green-500 text-white p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <!-- Add Menu Button -->
                <button id="openModalBtn" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Add Menu
                </button>
            </div>

            <!-- Menu Table -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-left">Image</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr>
                            <td class="px-4 py-2">{{ $menu->name }}</td>
                            <td class="px-4 py-2">{{ $menu->description }}</td>
                            <td class="px-4 py-2">PHP {{ number_format($menu->price, 2) }}</td>
                            <td class="px-4 py-2">
                                @if($menu->image)
                                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}"
                                        class="w-50 object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <!-- Edit and Delete buttons -->
                                <a href="{{ route('edit', ['id' => $menu->id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('delete', ['id' => $menu->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this menu?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit Menu -->
    <div id="menuModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 relative">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 id="modalTitle" class="text-lg font-semibold">Add Menu</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <div class="mt-4">
                <form id="menuForm" method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Menu Name</label>
                        <input type="text" name="name" id="menuName"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" id="menuDescription"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Price</label>
                        <input type="number" name="price" id="menuPrice"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image Upload Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Image</label>
                        <input type="file" name="image" id="menuImage"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mb-4"></div>

                </form>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <button id="cancelBtn" class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400">Cancel</button>
                <button id="saveBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle modal functionality -->
    <script>
        // Check if the success message is present
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            // Hide the success message after 3 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3000ms = 3 seconds
        }

        // Get elements
        const menuModal = document.getElementById('menuModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const modalTitle = document.getElementById('modalTitle');
        const menuForm = document.getElementById('menuForm');
        const imagePreview = document.getElementById('imagePreview');

        // Open modal
        openModalBtn.addEventListener('click', () => {
            menuModal.classList.remove('hidden');
            modalTitle.innerText = 'Add Menu'; // or 'Edit Menu' for edit
        });

        // Close modal
        closeModalBtn.addEventListener('click', () => {
            menuModal.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            menuModal.classList.add('hidden');
        });

        // Handle image preview
        document.getElementById('menuImage').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    imagePreview.innerHTML = `<img src="${reader.result}" alt="Image Preview" class="w-full h-48 object-cover rounded-md">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Add menu or edit menu logic
        saveBtn.addEventListener('click', () => {
            menuForm.submit(); // Trigger form submission (or implement your own AJAX logic)
        });
    </script>
</x-app-layout>
