<div>
    <!-- Add Menu Button -->
    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">
        Add Menu
    </button>

    <!-- Modal for Add/Edit Menu -->
    @if ($isOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6 relative">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-semibold">{{ $menuId ? 'Edit Menu' : 'Add Menu' }}</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <div class="mt-4">
                <form wire:submit.prevent="createMenu">
                    <!-- Name Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Menu Name</label>
                        <input type="text" wire:model="name"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea wire:model="description"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Price Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Price</label>
                        <input type="number" wire:model="price"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image Upload Field -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Image</label>
                        <input type="file" wire:model="image"
                            class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image Preview -->
                    @if ($image)
                    <div class="mb-4">
                        <img src="{{ $image->temporaryUrl() }}" alt="Image Preview"
                            class="w-full h-48 object-cover rounded-md">
                    </div>
                    @endif
                </form>
            </div>

            <div class="mt-6 flex justify-end space-x-2">
                <button wire:click="closeModal" class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400">Cancel</button>
                <button wire:click="createMenu" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            </div>
        </div>
    </div>
    @endif
</div>
