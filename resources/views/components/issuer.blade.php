<div class="container my-5">
    <h1 class="text-center mb-4">Issuer Information</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="issuerTable">
            <thead class="table-dark">
                <tr>
                    <th>Issuer ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Signature</th>
                    <th>Organization ID</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($issuer as $issuerData)
                    <tr>
                        <td>{{ $issuerData->issuerID }}</td>
                        <td>{{ $issuerData->firstName }}</td>
                        <td>{{ $issuerData->middleName }}</td>
                        <td>{{ $issuerData->lastName }}</td>
                        <td>
                            @if ($issuerData->issuerSignature)
                                <img src="data:image/png;base64,{{ base64_encode($issuerData->issuerSignature) }}" alt="Signature" style="width: 100px; height: auto;">
                            @else
                                No Signature
                            @endif
                        </td>
                        <td>{{ $issuerData->organizationID }}</td>
                        <td>{{ $issuerData->created_at }}</td>
                        <td>{{ $issuerData->updated_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No issuer information available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
