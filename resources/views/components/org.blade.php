<div class="container my-5">
    <h1 class="text-center mb-4">Organization Information</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="organizationTable">
            <thead class="table-dark">
                <tr>
                    <th>Organization ID</th>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($org as $organization)
                    <tr>
                        <td>{{ $organization->organizationID }}</td>
                        <td>{{ $organization->name }}</td>
                        <td>
                            @if ($organization->logo_base64)
                            <img src="data:image/png;base64,{{ $organization->logo_base64 }}" alt="Logo" style="width: 100px; height: auto;">
                            @else
                                No Logo
                            @endif
                        </td>
                        <td>{{ $organization->created_at }}</td>
                        <td>{{ $organization->updated_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No organization information available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
