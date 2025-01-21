@extends('layout.full')
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Issuer Information Form</h1>
    <form action="{{ url('/api/issuer') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="middleName" class="form-label">Middle Name:</label>
            <input type="text" class="form-control" id="middleName" name="middleName" maxlength="50">
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lastName" name="lastName" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="issuerSignature" class="form-label">Issuer Signature:</label>
            <input type="file" class="form-control" id="issuerSignature" name="issuerSignature" accept=".png, .jpg, .jpeg" required>
        </div>

        <div class="mb-3">
            <label for="organizationID" class="form-label">Organization ID:</label>
            <input type="number" class="form-control" id="organizationID" name="organizationID" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>
@endsection