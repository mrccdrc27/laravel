<h1 class="text-center mb-4 text-2xl font-semibold">Certification Form</h1>
<form action="https://genesiscs.azurewebsites.net/api/cert" method="POST">
    @csrf

    <div class="mb-4">
        <label for="certificationNumber" class="block text-sm font-medium text-gray-700">Certification Number:</label>
        <input type="text" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" 
               id="certificationNumber" name="certificationNumber" maxlength="100" required
               placeholder="e.g., CERT-XYZ-001">
    </div>

    <input type="hidden" name="courseID" value="{{$course->courseID}}">

    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
        <input type="text" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" 
               id="title" name="title" maxlength="100" required
               placeholder="e.g., Full-Stack Web Development">
    </div>

    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
        <textarea class="form-textarea mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" 
                  id="description" name="description" rows="4" required
                  placeholder="e.g., Certification for successfully completing the Full-Stack Web Development course."></textarea>
    </div>

    <div class="mb-4">
        <label for="issuedAt" class="block text-sm font-medium text-gray-700">Issued At:</label>
        <input type="date" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" 
               id="issuedAt" name="issuedAt" required>
    </div>

    <div class="mb-4">
        <label for="expiryDate" class="block text-sm font-medium text-gray-700">Expiry Date:</label>
        <input type="date" class="form-input mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" 
               id="expiryDate" name="expiryDate">
    </div>

    <input type="hidden" name="issuerID" value="{{Auth::user()->id}}">

    @php
        $users = DB::select('EXEC GetStudentDetailsByCourse ?', [$course->courseID]);
    @endphp

    <div class="mb-4">
        <label for="userID" class="block text-sm font-medium text-gray-700">Student:</label>
        <select id="userID" name="userID" class="form-select mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" required>
            <option value="" disabled selected>Select a User</option>
            @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ $user->firstName }} {{ $user->middleName }} {{ $user->lastName }}
            </option>
            @endforeach
        </select>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userID').select2({
                placeholder: "Select a User",
                allowClear: true,
                width: 'resolve'
            });
        });
    </script>

    <button type="submit" class="w-full px-4 py-2 mt-4 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Submit</button>
</form>
