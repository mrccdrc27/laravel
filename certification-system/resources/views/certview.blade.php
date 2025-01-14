<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta.15/dist/css/tabler.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            margin: 50px auto;
            padding: 50px;
            max-width: 1200px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.1);
            line-height: 1.7;
            border: 1px solid #e1e8f0;
            display: flex;
            flex-direction: row; /* Adjusted to make horizontal layout */
            justify-content: space-between;
        }

        .certificate-left, .certificate-right {
            width: 48%; /* Each section takes up 48% of the container */
        }

        .certificate-header {
            font-size: 3rem;
            font-weight: 600;
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .certificate-subheading {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #007bff;
        }

        .certificate-details p {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .certificate-details strong {
            color: #555;
        }

        .certificate-logo {
            display: block;
            margin: 20px auto;
            width: 120px;
            height: auto;
            border-radius: 50%;
            border: 2px solid #007bff;
        }

        .signature-section {
            margin-top: 30px;
            text-align: center;
        }

        .signature-line {
            border-top: 2px solid #007bff;
            width: 250px;
            margin: 20px auto;
        }

        .signature-name {
            font-size: 1.2rem;
            margin-top: 5px;
            font-weight: 600;
        }

        .issuer-logo {
            display: block;
            width: 100px;
            height: auto;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <!-- Left Side: Certificate Information -->
        <div class="certificate-left">
            <div class="certificate-header">
                Certificate of Completion
            </div>

            <div class="certificate-subheading">Certification Information</div>
            <div class="certificate-details">
                <p><strong>Title:</strong> {{ $certificate->title }}</p>
                <p><strong>Certification Number:</strong> {{ $certificate->certificationNumber }}</p>
                <p><strong>Course ID:</strong> {{ $certificate->courseID }}</p>
                <p><strong>Issued At:</strong> {{ $certificate->issuedAt }}</p>
                <p><strong>Expiry Date:</strong> {{ $certificate->expiryDate }}</p>
            </div>

            <div class="certificate-subheading">Student Information</div>
            <div class="certificate-details">
                <p><strong>Name:</strong> {{ $certificate->userinfo->firstName }} {{ $certificate->userinfo->middleName }} {{ $certificate->userinfo->lastName }}</p>
                <p><strong>Student ID:</strong> {{ $certificate->userinfo->studentID }}</p>
                <p><strong>Email:</strong> {{ $certificate->userinfo->email }}</p>
                <p><strong>Nationality:</strong> {{ $certificate->userinfo->nationality }}</p>
                <p><strong>Birth Date:</strong> {{ $certificate->userinfo->birthDate }}</p>
                <p><strong>Sex:</strong> {{ $certificate->userinfo->sex ? 'Male' : 'Female' }}</p>
                <p><strong>Birth Place:</strong> {{ $certificate->userinfo->birthPlace }}</p>
            </div>
        </div>

        <!-- Right Side: Issuer Information and Signature -->
        <div class="certificate-right">
            <div class="certificate-subheading">Issuer Information</div>
            <div class="certificate-details">
                <p><strong>Issuer:</strong> {{ $certificate->issuer->firstName }} {{ $certificate->issuer->lastName }}</p>
                <p><strong>Organization:</strong> {{ $certificate->issuer->organization->name }}</p>
                @if($certificate->issuer->organization->logo_base64)
                    <img src="data:image/png;base64,{{ $certificate->issuer->organization->logo_base64 }}" class="issuer-logo" alt="Issuer Logo">
                @endif
            </div>

            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-name">Issuer's Signature</div>
                @if($certificate->issuer->issuerSignature)
                    <img src="data:image/png;base64,{{ $certificate->issuer->issuerSignature_base64 }}" class="certificate-logo" alt="Signature">
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta.15/dist/js/tabler.min.js"></script>
</body>

</html>
