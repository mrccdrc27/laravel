<?php
/**
 * Certification QR Code View
 *
 * This view displays details of a specific certification along with its QR code.
 *
 * Variables passed to the view:
 * @var \App\Models\Certification $certification An instance of the Certification model containing details of the certification.
 *  - CertificationNumber (string): The unique identifier for the certification.
 *  - FirstName (string): The first name of the certificate recipient.
 *  - LastName (string): The last name of the certificate recipient.
 *  - IssuedAt (string): The issue date of the certification.
 *  - CertificationID (string): The unique ID of the certification.
 */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Certification QR Code</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>Certification QR Code</h1>
        
        <div>
            <h3>Certificate Details:</h3>
            <p>Certificate Number: {{ $certification->CertificationNumber }}</p>
            <p>Name: {{ $certification->FirstName }} {{ $certification->LastName }}</p>
            <p>Issue Date: {{ $certification->IssuedAt }}</p>
            <p>Certification ID: {{ $certification->CertificationID }}</p>
        </div>

        <div style="margin: 20px;">
            <h3>QR Code:</h3>
            {{-- Generate the QR Code dynamically with the correct link --}}
            {!! QrCode::size(200)->generate(url("certifications/{$certification->CertificationID}/qr-code")) !!}
            <p>Link: <a href="{{ url("certifications/{$certification->CertificationID}/qr-code") }}">
                {{ url("certifications/{$certification->CertificationID}/qr-code") }}
            </a></p>
        </div>
    </div>
</body>
</html>
