<?php
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-blue-400 leading-tight">
            {{ __('Accounts') }}
        </h2>        
    </x-slot>

    @php
    $request = request();
    $search = $request->input('search');
    $role = $request->input('role');
    $perPage = 10;
    $page = $request->input('page', 1);
    
    // Execute stored procedure
    $users = DB::select("EXEC GetAllUserInfo");

    // Convert to collection
    $usersCollection = collect($users);

    // Apply search filter
    if ($search) {
        $usersCollection = $usersCollection->filter(fn($user) => stripos($user->FullName, $search) !== false);
    }

    // Apply role filter
    if ($role) {
        $usersCollection = $usersCollection->where('role', $role);
    }

    // Paginate results manually
    $total = $usersCollection->count();
    $users = $usersCollection->slice(($page - 1) * $perPage, $perPage)->values();
    $paginatedUsers = new LengthAwarePaginator($users, $total, $perPage, $page, [
        'path' => url()->current(),
        'query' => request()->query(),
    ]);
    @endphp

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden">

                <div class="container px-6 py-8">
                    <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-6">Users</h2>
                    
                    <form method="GET" action="{{ request()->url() }}" class="mb-6 space-y-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by name" value="{{ request('search') }}">
                            </div>
                            <div class="flex-1">
                                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Roles</option>
                                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="faculty" {{ request('role') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Filter</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Joined</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($paginatedUsers as $user)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $user->FullName }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($user->role) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->Joined }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="flex justify-center mt-6">
                        {{ $paginatedUsers->appends(request()->query())->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
