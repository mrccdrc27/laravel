@extends('layout.full')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Organization Form</h1>
        <form action="{{ url('/api/org') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Organization Name:</label>
                <input type="text" class="form-control" id="OrganizationName" name="OrganizationName" maxlength="50" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo:</label>
                <input type="file" class="form-control" id="Logo" name="Logo" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
@endsection
