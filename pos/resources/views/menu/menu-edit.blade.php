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

            <!-- Removed modal styling and positioning -->
            <div class="bg-white rounded-lg shadow-lg w-full p-6">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 id="modalTitle" class="text-lg font-semibold">Edit Menu</h3>
                </div>

                <div class="mt-4">
                    <form id="menuForm" method="POST" action="{{ route('update', ['id' => $menu->id]) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Menu Name</label>
                            <input type="text" name="name" id="menuName" value="{{ old('name', $menu->name) }}"
                                class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Description</label>
                            <textarea name="description" id="menuDescription"
                                class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">{{ old('description', $menu->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Price Field -->
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Price</label>
                            <input type="number" name="price" id="menuPrice" value="{{ old('price', $menu->price) }}"
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
                        <div id="imagePreview" class="mb-4">
                            @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Menu Image"
                                class="object-cover" style="height: 15rem;">
                            @endif
                        </div>

                    </form>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <a href="{{ route('menu-management') }}"
                        class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400 inline-block">
                        Cancel
                    </a>
                    <button type="submit" id="saveBtn"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle success message removal -->
    <script>
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            // Hide the success message after 3 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3000ms = 3 seconds
        }

        const menuForm = document.getElementById('menuForm');
        const saveBtn = document.getElementById('saveBtn');

        // Get the current image filename from the backend
        const currentImage = "{{ asset('storage/' . $menu->image) }}";
        const currentImageName = currentImage.split('/').pop(); // Extract just the filename

        const initialData = {
            name: "{{ old('name', $menu->name) }}",
            description: "{{ old('description', $menu->description) }}",
            price: "{{ old('price', $menu->price) }}",
            image: currentImageName
        };

        const checkChanges = () => {
            const nameChanged = document.getElementById('menuName').value !== initialData.name;
            const descriptionChanged = document.getElementById('menuDescription').value !== initialData.description;
            const priceChanged = document.getElementById('menuPrice').value !== initialData.price;
            const imageChanged = document.getElementById('menuImage').files.length > 0;

            // If an image is uploaded, check if it's different from the existing image
            const newImageFile = document.getElementById('menuImage').files[0];
            const imageFileChanged = newImageFile && newImageFile.name !== initialData.image;

            // Enable or disable the Save button based on changes
            if (nameChanged || descriptionChanged || priceChanged || imageFileChanged) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        };

        // Initialize Save button state
        checkChanges();

        // Listen for input changes to check for updates
        document.getElementById('menuName').addEventListener('input', checkChanges);
        document.getElementById('menuDescription').addEventListener('input', checkChanges);
        document.getElementById('menuPrice').addEventListener('input', checkChanges);
        document.getElementById('menuImage').addEventListener('change', checkChanges);

        // Edit menu logic
        saveBtn.addEventListener('click', () => {
            menuForm.submit(); // Trigger form submission (or implement your own AJAX logic)
        });
    </script>
</x-app-layout>
