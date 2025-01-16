<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- New User Form --}}
                <div class="bg-white rounded-lg shadow-lg w-full p-6">
                    <form id="orderForm" method="POST" action="{{ route('createUser') }}">
                        @csrf

                        <div class="mb-5">
                            <!-- Name -->
                            <div class="flex-1 mb-5">
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                                <input type="text" name="name" id="name" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="flex-1 mb-5">
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                                <input type="email" name="email" id="email" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="flex-1 mb-5">
                                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                                <input type="password" name="password" id="password" required
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="flex-1 mb-5">
                                <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                                <select name="role" id="role" required class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-500">
                                    <option value="admin">Administrator</option>
                                    <option value="cook">Chef/Cook</option>
                                    <option value="cashier">Cashier</option>
                                </select>
                                @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('user-management') }}"
                                class="bg-gray-300 px-4 py-2 rounded text-gray-700 hover:bg-gray-400 inline-block">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
