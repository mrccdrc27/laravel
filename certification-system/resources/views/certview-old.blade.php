<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <link href="https://cdn.jsdelivr.net/npm/tabler@latest/dist/css/tabler.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .certificate-container {
            width: 80%;
            max-width: 1100px;
            background-color: #ffffff;
            border: 2px solid #007bff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }

        .certificate-title {
            color: #007bff;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .certificate-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-bottom: 80px;
        }

        .certificate-column {
            width: 48%;
            padding: 10px;
            box-sizing: border-box;
        }

        .section-title {
            color: #007bff;
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 1rem;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
        }

        .info-value {
            color: #343a40;
        }

        .certificate-description {
            color: #495057;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-top: 10px;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .qr-section {
            width: 45%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .qr-section img {
            max-height: 100px;
        }

        .issuer-signature-section {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }

        .issuer-logo {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            border: 1px solid #ddd;
            flex-shrink: 0;
            margin-right: 20px;
        }

        .issuer-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            width: 100%;
        }

        .issuer-signature {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .signature-placeholder {
            margin-bottom: 10px;
        }

        .signature-line {
            width: 200px;
            height: 2px;
            background-color: #007bff;
            margin-bottom: 5px;
        }

        .signature-text {
            font-size: 1rem;
            font-weight: bold;
            color: #343a40;
        }

        .issuer-info {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #495057;
            text-align: left;
        }

        .footer-text {
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="certificate-container">
        <div class="certificate-title">CERTIFICATE OF COMPLETION</div>

        <!-- Main Certificate Content -->
        <div class="certificate-content">
            <!-- Left Column (Certification Info) -->
            <div class="certificate-column">
                <div class="section-title">Certification Information</div>
                <div class="info-row">
                    <span class="info-label">Title:</span>
                    <span class="info-value">{{ $certificateData->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Certification Number:</span>
                    <span class="info-value">{{ $certificateData->certificationNumber }}</span>
                </div>
                <!-- Certificate Description -->
                <div class="certificate-description">
                    This certificate is awarded to recognize the completion of a comprehensive course that builds skills
                    in a specialized field.
                </div>
                <div class="info-row">
                    <span class="info-label">Course :</span>
                    <span class="info-value">{{ $certificateData->courseName }}</span>
                </div>
                {{-- <div class="info-row">
                    <span class="info-label">Course ID:</span>
                    <span class="info-value">{{ $certificateData->courseID }}</span>
                </div> --}}
                <div class="info-row">
                    <span class="info-label">Issued At:</span>
                    <span class="info-value">{{ $certificateData->issuedAt }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Expiry Date:</span>
                    <span class="info-value">{{ $certificateData->expiryDate }}</span>
                </div>
            </div>

            <!-- Right Column (Student Info) -->
            <div class="certificate-column">
                <div class="section-title">Student Information</div>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $certificateData->userinfo->firstName }}
                        {{ $certificateData->userinfo->middleName }} {{ $certificateData->userinfo->lastName }}</span>
                </div>
                {{-- <div class="info-row">
                    <span class="info-label">Student ID:</span>
                    <span class="info-value">{{ $certificateData->userinfo->studentID }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $certificateData->userinfo->email }}</span>
                </div> --}}
                {{-- <div class="info-row">
                    <span class="info-label">Nationality:</span>
                    <span class="info-value">{{ $certificateData->userinfo->nationality }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Birth Date:</span>
                    <span class="info-value"> {{ $certificateData->userinfo->birthDate }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sex:</span>
                    <span class="info-value">{{ $certificateData->userinfo->sex ? 'Male' : 'Female' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Birth Place:</span>
                    <span class="info-value"> {{ $certificateData->userinfo->birthPlace }}</span>
                </div> --}}
            </div>
        </div>

        <!-- QR Code and Signature Row -->
        <div class="footer-section">
            <!-- Issuer Signature Section -->
            <div class="issuer-signature-section">
                <!-- Organization Logo -->
                @if ($certificateData->issuer->organization->logo_base64)
                    <img class="issuer-logo"
                        src="data:image/png;base64,{{ $certificateData->issuer->organization->logo_base64 }}"
                        class="issuer-logo" alt="Organization Logo">
                @endif
                <!-- <img class="issuer-logo" src="https://placehold.co/100x100" alt="Organization Logo"> -->

                <!-- Issuer Details -->
                <div class="issuer-details">
                    <!-- Issuer Signature Section -->
                    @if ($certificateData->issuer->issuerSignature_base64)
                        <img class="issuer-logo" style="signature-line max-width: 100px; max-height: 50px;"
                            src="data:image/png;base64,{{ $certificateData->issuer->issuerSignature_base64 }}"
                            alt="Signature" />
                    @else
                        <div class="signature-placeholder">
                            <div class="signature-line"></div>
                            <div class="signature-text">Signature</div>
                        </div>
                    @endif

                    <div class="issuer-info">
                        <div><b>Issuer:</b> {{ $certificateData->issuer->firstName }}
                            {{ $certificateData->issuer->lastName }}</div>
                        <div><b>Organization:</b> {{ $certificateData->issuer->organization->name }}</div>
                    </div>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                {!! QrCode::size(100)->generate(url()->current()) !!}

            </div>
        </div>

        <!-- Footer -->
        <div class="footer-text">
            This certificate is digitally verified. Scan the QR code for validation.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tabler@latest/dist/js/tabler.min.js"></script>
</body>

</html>
