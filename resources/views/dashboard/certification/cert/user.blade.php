@extends('layout.full')
@section('content')

<div class="container mt-5">
    <h1 class="text-center mb-4">User Information Form</h1>
    <form action="{{ url('/api/user_info') }}" method="POST" class="p-4 border rounded shadow">
        @csrf
        <div class="mb-3">
            <label for="studentID" class="form-label">Student ID:</label>
            <input type="number" class="form-control" id="studentID" name="studentID" required>
        </div>

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
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="birthDate" class="form-label">Birth Date:</label>
            <input type="date" class="form-control" id="birthDate" name="birthDate" required>
        </div>

        <div class="mb-3">
            <label for="sex" class="form-label">Sex:</label>
            <select class="form-select" id="sex" name="sex" required>
                <option value="0">Female</option>
                <option value="1">Male</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality:</label>
            <input type="text" class="form-control" id="nationality" name="nationality" maxlength="50" required>
        </div>

        <div class="mb-3">
            <label for="birthPlace" class="form-label">Birth Place:</label>
            <input type="text" class="form-control" id="birthPlace" name="birthPlace" maxlength="100" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>
@endsection