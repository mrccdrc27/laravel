@extends('layout.full')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">How to Create a Certification</h2>
    <div class="alert alert-info" role="alert">
        Follow the steps below to create a valid certification:
    </div>

    <ol>
        <li>
            <strong>Step 1: Ensure You Have an Organization</strong>
            <p>Before creating a certification, make sure you have an existing organization in the system. The organization will be responsible for issuing the certification.</p>
        </li>

        <li>
            <strong>Step 2: Ensure You Have an Issuer Associated with an Organization</strong>
            <p>Each certification needs to have an issuer, and the issuer must be linked to an existing organization. Make sure you have an issuer associated with the correct organization in the system.</p>
        </li>

        <li>
            <strong>Step 3: Ensure You Have a User Associated to Receive the Certificate</strong>
            <p>In order to issue a certification, you need to select a user who will be the recipient of the certification. Make sure the user is registered and associated with your organization.</p>
        </li>

        <li>
            <strong>Step 4: Ensure the Issuer is Associated to Issue the Certificate</strong>
            <p>To issue a valid certification, you must confirm that the issuer, who is associated with the organization, is authorized to issue the certificate to the selected user.</p>
        </li>
    </ol>
</div>
@endsection