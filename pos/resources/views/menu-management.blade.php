<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <livewire:menu-modal />
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
                                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" class="w-auto object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <button wire:click="openModal({{ $menu->id }})"
                                    class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                                <button wire:click="deleteMenu({{ $menu->id }})"
                                    class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
