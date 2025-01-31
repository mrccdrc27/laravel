<h1 class="text-center mb-4 text-2xl font-semibold">Certification Form</h1>
<form action="{{ env('CERT_API_URL') }}" method="POST" class="p-6 border bg-white rounded-lg shadow-lg">

    @csrf

    <input type="hidden" name="issuerID" value="{{Auth::user()->id}}">
    <input type="hidden" name="courseID" value="{{$course->courseID}}">

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

    @php
        $users = DB::select('EXEC GetStudentDetailsByCourse ?', [$course->courseID]);
    @endphp

    <div class="mb-4">
        {{-- You can remove dd($users) after debugging --}}
        @php
            // dd($users); // Remove this after debugging
        @endphp
        <label for="userID" class="block text-sm font-medium text-gray-700">Student:</label>
        <select id="userID" name="userID" class="form-select mt-1 block w-full px-4 py-2 border rounded-md shadow-sm" required>
            <option value="" disabled selected>Select a User</option>
            
            {{-- Loop through the users data passed from the controller --}}
            @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->middleName }} {{ $user->lastName }}</option>
            @endforeach
        </select>
    </div>

    <!-- Add just before closing </body> tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 on the userID dropdown
            $('#userID').select2({
                placeholder: "Select a User",  // Placeholder text
                allowClear: true,              // Allow the option to be cleared
                width: 'resolve'               // Adjust the width of the dropdown
            });
        });
    </script>




    <button type="submit" class="w-full px-4 py-2 mt-4 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">Submit</button>
</form>