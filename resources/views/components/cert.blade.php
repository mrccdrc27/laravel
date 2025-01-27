<div class="container my-5">
    <h1 class="text-center mb-4">Certification Information</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="certificationTable">
            <thead class="table-dark">
                <tr>
                    <th>Certification ID</th>
                    <th>Certification Number</th>
                    <th>Course ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Issued At</th>
                    <th>Expiry Date</th>
                    <th>Issuer ID</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cert as $certificate)
                    <tr>
                        <td>{{ $certificate->certificationID }}</td>
                        <td>{{ $certificate->certificationNumber }}</td>
                        <td>{{ $certificate->courseID }}</td>
                        <td>{{ $certificate->title }}</td>
                        <td>{{ $certificate->description }}</td>
                        <td>{{ $certificate->issuedAt }}</td>
                        <td>{{ $certificate->expiryDate }}</td>
                        <td>{{ $certificate->issuerID }}</td>
                        <td>{{ $certificate->userID }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No certifications available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
