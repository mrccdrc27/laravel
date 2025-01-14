<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>User ID</th>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Birth Date</th>
                <th>Sex</th>
                <th>Nationality</th>
                <th>Birth Place</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($userinfo as $user)
                <tr>
                    <td>{{ $user->userID }}</td>
                    <td>{{ $user->studentID }}</td>
                    <td>{{ $user->firstName }}</td>
                    <td>{{ $user->middleName }}</td>
                    <td>{{ $user->lastName }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->birthDate }}</td>
                    <td>{{ $user->sex }}</td>
                    <td>{{ $user->nationality }}</td>
                    <td>{{ $user->birthPlace }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No user information available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
