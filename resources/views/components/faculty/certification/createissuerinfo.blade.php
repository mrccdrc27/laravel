<form id="ajax-form" enctype="multipart/form-data" class="p-6 border bg-white rounded-lg shadow-lg">
    @csrf

    <div class="mb-4">
        <label for="firstName" class="block text-gray-700 text-sm font-semibold mb-2">First Name</label>
        <input type="text" class="w-full p-3 border border-gray-300 rounded-md" id="firstName" name="firstName" required>
    </div>

    <div class="mb-4">
        <label for="middleName" class="block text-gray-700 text-sm font-semibold mb-2">Middle Name</label>
        <input type="text" class="w-full p-3 border border-gray-300 rounded-md" id="middleName" name="middleName">
    </div>

    <div class="mb-4">
        <label for="lastName" class="block text-gray-700 text-sm font-semibold mb-2">Last Name</label>
        <input type="text" class="w-full p-3 border border-gray-300 rounded-md" id="lastName" name="lastName" required>
    </div>

    <input type="hidden" name="someName" value="4">

    <div class="mb-4">
        <label for="issuerSignature" class="block text-gray-700 text-sm font-semibold mb-2">Issuer Signature (Image)</label>
        <input type="file" class="w-full p-3 border border-gray-300 rounded-md" id="issuerSignature" name="issuerSignature" accept="image/*" required>
    </div>

    <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">Submit</button>
</form>

<script>
    $(document).ready(function() {
        $('#ajax-form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Create a new FormData object
            
            $.ajax({
                url: '{{ url('https://genesiscs.azurewebsites.net/api/issuerV2/') }}',
                type: 'POST',
                data: formData,
                processData: true,
                contentType: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Form submitted successfully!');
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });
</script>