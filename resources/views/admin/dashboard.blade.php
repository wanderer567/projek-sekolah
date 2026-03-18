<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6 text-xl font-bold text-indigo-600">
                Admin Panel
            </div>
            <nav class="px-4 space-y-2">
                <a href="#" class="block px-4 py-2 rounded bg-indigo-100 text-indigo-700">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">Users</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">Reports</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">Settings</a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-8">

            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Total Users</p>
                    <h2 class="text-3xl font-bold">120</h2>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Active</p>
                    <h2 class="text-3xl font-bold text-green-500">95</h2>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Pending</p>
                    <h2 class="text-3xl font-bold text-yellow-500">15</h2>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Admins</p>
                    <h2 class="text-3xl font-bold text-indigo-600">3</h2>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold mb-4">Latest Users</h2>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2">Faiz</td>
                            <td>faiz@gmail.com</td>
                            <td>Admin</td>
                            <td class="text-green-600">Active</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2">Budi</td>
                            <td>budi@gmail.com</td>
                            <td>User</td>
                            <td class="text-yellow-600">Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</x-app-layout>
