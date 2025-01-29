@extends('layout.layout')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-search me-2"></i>Search Certificates</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('certificates.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control form-control-lg"
                                placeholder="Search by certificate number, name, course, or title..."
                                value="{{ request('query') }}" aria-label="Search certificates">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                        <small class="form-text text-muted mt-2">
                            Tip: You can search using partial numbers or names (e.g., "CERT-2023" or "John")
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (isset($certificates))
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Search Results ({{ $certificates->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Certificate Number</th>
                                        <th>Recipient Name</th>
                                        <th>Course</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($certificates as $certificate)
                                        <tr>
                                            <td class="fw-bold">{{ $certificate->certificationNumber }}</td>
                                            <td>
                                                @if ($certificate->type === 'web')
                                                    {{ $certificate->name }}
                                                @else
                                                    {{ $certificate->fullName }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $certificate->courseTitle ?? $certificate->title }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($certificate->issuedAt)->format('M d, Y') }}</td>
                                            <td>
                                                @if ($certificate->expiryDate)
                                                    {{ \Carbon\Carbon::parse($certificate->expiryDate)->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($certificate->expiryDate && \Carbon\Carbon::now()->gt($certificate->expiryDate))
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('cert.details', ['id' => $certificate->certificationID ?? $certificate->id]) }}" 
                                                       class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 d-flex align-items-center"
                                                       title="View Certificate"
                                                       data-bs-toggle="tooltip">
                                                        <i class="bi bi-eye-fill me-1"></i> View
                                                    </a>
                                                    {{-- <a href="{{ route('certificate.verify', ['certificationNumber' => $certificate->certificationNumber]) }}"
                                                       class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 d-flex align-items-center"
                                                       title="Verify Certificate"
                                                       data-bs-toggle="tooltip">
                                                        <i class="bi bi-patch-check-fill me-1"></i> Verify
                                                    </a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="alert alert-warning mb-0">
                                                    <i class="bi bi-exclamation-circle me-2"></i>
                                                    No certificates found matching your search criteria.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .table thead th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.75em;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--primary-color), 0.05);
        }
    </style>
@endsection
