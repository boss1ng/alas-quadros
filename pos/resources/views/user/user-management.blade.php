<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
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
                <!-- New User Button -->
                <a href="{{ route('newUser') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    New User
                </a>
            </div>

            <!-- Sales Table -->
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Name
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Email Address
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Role
                            </th>
                            <th class="px-6 py-3 text-center text-lg font-large text-gray-500 uppercase dark:text-gray-300">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isEmpty())
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                    No records found in Users.
                                </td>
                            </tr>
                        @else
                            @foreach($users as $user)
                            <tr
                                class="border-t text-center border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td
                                    class="text-left px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $user->name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $user->email }}
                                </td>
                                <td
                                    class="uppercase px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    {{ $user->role }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-800 dark:text-gray-200">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('editUser', ['id' => $user->id]) }}"
                                            class="inline-block px-4 py-2 bg-yellow-500 text-white text-md font-medium rounded hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('deleteUser', ['id' => $user->id]) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this user?')">
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
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
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
