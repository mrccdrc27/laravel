@extends('layout.full')
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Certification Form</h1>
    <form action="{{ url('/api/cert') }}" method="POST" class="p-4 border rounded shadow">
        @csrf
        <div class="mb-3">
            <label for="certificationNumber" class="form-label">Certification Number:</label>
            <input type="text" class="form-control" id="certificationNumber" name="certificationNumber" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="courseID" class="form-label">Course ID:</label>
            <input type="number" class="form-control" id="courseID" name="courseID" required>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="issuedAt" class="form-label">Issued At:</label>
            <input type="date" class="form-control" id="issuedAt" name="issuedAt" value="{{ now()->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="expiryDate" class="form-label">Expiry Date:</label>
            <input type="date" class="form-control" id="expiryDate" name="expiryDate">
        </div>

        <div class="mb-3">
            <label for="issuerID" class="form-label">Issuer ID:</label>
            <input type="number" class="form-control" id="issuerID" name="issuerID" required>
        </div>

        <div class="mb-3">
            <label for="userID" class="form-label">User ID:</label>
            <input type="number" class="form-control" id="userID" name="userID" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>

@endsection