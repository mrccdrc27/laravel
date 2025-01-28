<h1 class="text-center mb-4 text-2xl font-semibold">Certification Form</h1>
<form action="{{ url('/api/cert') }}" method="POST" class="p-6 border bg-white rounded-lg shadow-lg">
    @csrf
    <div class="mb-4">
        <label for="certificationNumber" class="block text-sm font-medium text-gray-700">Certification Number:</label>
        <input type="text" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="certificationNumber" name="certificationNumber" maxlength="100" required>
    </div>

    <div class="mb-4">
        <label for="courseID" class="block text-sm font-medium text-gray-700">Course ID:</label>
        <input type="number" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="courseID" name="courseID" required>
    </div>

    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
        <input type="text" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="title" name="title" maxlength="100" required>
    </div>

    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
        <textarea class="form-textarea mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="description" name="description" rows="4" required></textarea>
    </div>

    <div class="mb-4">
        <label for="issuedAt" class="block text-sm font-medium text-gray-700">Issued At:</label>
        <input type="date" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="issuedAt" name="issuedAt" value="{{ now()->format('Y-m-d') }}" required>
    </div>

    <div class="mb-4">
        <label for="expiryDate" class="block text-sm font-medium text-gray-700">Expiry Date:</label>
        <input type="date" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="expiryDate" name="expiryDate">
    </div>

    <div class="mb-4">
        <label for="issuerID" class="block text-sm font-medium text-gray-700">Issuer ID:</label>
        <input type="number" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="issuerID" name="issuerID" required>
    </div>

    <div class="mb-4">
        <label for="userID" class="block text-sm font-medium text-gray-700">User ID:</label>
        <input type="number" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" id="userID" name="userID" required>
    </div>

    <button type="submit" class="w-full px-4 py-2 mt-4 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Submit</button>
</form>