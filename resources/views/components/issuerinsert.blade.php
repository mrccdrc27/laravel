{{-- this works --}}

<div>
    @php
    $id = 1
    @endphp
    <form method="POST" action="http://127.0.0.1:8000/api/issuer/{{$id}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        
        <div>
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required maxlength="50">
        </div>

        <div>
            <label for="middleName">Middle Name</label>
            <input type="text" id="middleName" name="middleName" maxlength="50">
        </div>

        <div>
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required maxlength="50">
        </div>

        <div>
            <label for="issuerSignature">Issuer Signature (optional)</label>
            <input type="file" id="issuerSignature" name="issuerSignature" accept=".jpg, .jpeg, .png, .pdf">
        </div>

        <div>
            <label for="organizationID">Organization ID</label>
            <input type="number" id="organizationID" name="organizationID" required>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
