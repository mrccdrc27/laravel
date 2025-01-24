<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Appreciation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ffffff;
        }

        .main-container {
            display: flex;
            width: 100%;
            max-width: 1600px;
            height: 90%;
            padding: 20px;
            box-sizing: border-box;
        }

        .certificate-container {
            width: 70%;
            height: 100%;
            padding: 40px;
            background-image: url('https://res.cloudinary.com/dnvchm2cy/image/upload/v1737411765/cert-bg_dckd0e.svg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .certificate-title {
            text-align: center;
            font-size: 3rem;
            font-weight: bold;
            color: #510000;
            margin-top: 80px;
        }

        .certificate-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #444;
            margin-top: 30px;
        }

        .recipient-name {
            text-align: center;
            font-size: 3rem;
            font-family: 'Georgia', serif;
            font-style: italic;
            color: #26000C;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .recipient-line {
            width: 50%;
            margin: 0 auto 20px;
            border-top: 1px solid #000;
        }

        .certificate-description {
            text-align: center;
            font-size: 1.1rem;
            line-height: 1.5;
            color: #333;
            margin-top: 30px;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 15px;
        }

        .qr-section {
            margin-left: 50px;
            margin-bottom: 50px;
        }

        .qr-section img {
            width: 100px;
            height: 100px;
        }

        .signature-placeholder img {
            width: 100px;
            height: 50px;
        }

        .svg-icon-section {
            margin-right: 50px;
            margin-bottom: 20px;
        }

        .svg-icon-section img {
            width: 100px;
            height: 100px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid rgb(165, 165, 165);
        }

        .info-label {
            font-weight: bold;
            color: #444;
        }

        .info-value {
            color: #333;
            text-align: right;
            flex-grow: 1;
        }

        .issuer-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 50%;
        }

        .issuer-section {
            text-align: center;
        }

        .issuer-signature-line {
            border-top: 1px solid #000;
            margin: 10px auto;
            width: 150px;
        }

        .issuer-signature {
            font-size: 1rem;
            font-weight: bold;
            color: #000;
            margin-bottom: 15px;
        }

        .issuer-info {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.6;
        }

        .issuer-logo img {
            width: 80px;
            height: 80px;
            margin-top: 20px;
        }

        .certificate-right {
            width: 30%;
            height: auto;
            /* Allow content to determine the height */
            margin-left: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            overflow: hidden;
            /* Remove scrollbars */
        }

        .certificate-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center horizontally */
            justify-content: flex-start;
            /* Align content at the top */
            padding: 20px 0;
            /* Add some padding for better spacing */
        }

        .certificate-column {
            width: 90%;
            /* Adjust width */
            text-align: left;
            /* Center text */
            /* Add more space between sections */
            line-height: 1.6;
            /* Increase line spacing */
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #510000;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <!-- Left Certificate Section -->
        <div class="certificate-container">
            <div class="certificate-title">CERTIFICATE OF COMPLETION</div>
            <div class="certificate-subtitle">This certificate is presented to</div>
            <div class="recipient-name">{{ $certificateData->userInfo->firstName }}
                {{ $certificateData->userInfo->lastName }}</div>
            <div class="recipient-line"></div>
            <div class="certificate-description">
                This certificate is awarded to recognize the completion of {{ $certificateData->courseName }} <br>

            </div>
            <div class="footer-section">
                <div class="qr-section">
                    {!! QrCode::size(60)->generate(url()->current()) !!}
                </div>
                <div class="issuer-group">
                    <div class="issuer-section">
                        @if ($certificateData->issuer->issuerSignature_base64)
                            <div class="signature-placeholder">
                                <img src="data:image/png;base64,{{ $certificateData->issuer->issuerSignature_base64 }}"
                                    alt="Signature">
                            </div>
                        @else
                            <div class="signature-placeholder">
                                <img src="https://placehold.co/100x50" alt="Signature">
                            </div>
                        @endif
                        <div class="issuer-signature-line"></div>
                        <div class="issuer-signature">{{ $certificateData->issuer->firstName }}
                            {{ $certificateData->issuer->lastName }}</div>
                        <div class="issuer-info">


                        </div>
                        <div class="issuer-logo">
                            @if ($certificateData->issuer->issuerSignature_base64)
                                <img class="issuer-logo" style="signature-line max-width: 80px; max-height: 80px;"
                                    src="data:image/png;base64,{{ $certificateData->issuer->issuerSignature_base64 }}"
                                    alt="Signature" />
                            @else
                                <div class="signature-placeholder">
                                    <div class="signature-line"></div>
                                    {{-- <div class="signature-text">Signature</div> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="svg-icon-section">
                    <img src="https://res.cloudinary.com/dnvchm2cy/image/upload/v1737417397/award-reward-svgrepo-com_y2n4tn.svg"
                        alt="Award Badge">
                </div>
            </div>
        </div>

        <!-- Right Additional Content -->
        <div class="certificate-right">
            <div class="certificate-content">
                <!-- Certification Info -->
                <div class="certificate-column">
                    <div class="section-title">Certification Information</div>
                    <div class="info-row">
                        <span class="info-label">Title:</span>
                        <span class="info-value">Certificate Title Placeholder</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Certification Number:</span>
                        <span class="info-value">{{ $certificateData->certificationNumber }}</span>
                    </div>
                    {{-- <div class="certificate-description-2">
                        This certificate is awarded to recognize the completion of {{ $certificateData->courseName }}
                    </div> --}}
                    <div class="info-row">
                        <span class="info-label">Course:</span>
                        <span class="info-value">{{ $certificateData->courseName }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Description:</span>
                        <span class="info-value">{{ $certificateData->courseDescription }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Issued At:</span>
                        <span class="info-value">{{ $certificateData->issuedAt }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Expiry Date:</span>
                        <span class="info-value">{{ $certificateData->expiryDate }}</span>
                    </div>
                </div>

                <!-- Student Info -->
                <div class="certificate-column">
                    <div class="section-title">Student Information</div>
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span
                            class="info-value">{{ $certificateData->userInfo->firstName }}{{ $certificateData->userInfo->middleName }}
                            {{ $certificateData->userInfo->lastName }}</span>
                    </div>
                    {{-- <div class="info-row">
                        <span class="info-label">Student ID:</span>
                        <span class="info-value">{{ $certificateData->userInfo->studentID }}</span>
                    </div> --}}
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $certificateData->userInfo->email }}</span>
                    </div>
                    {{-- <div class="info-row">
                        <span class="info-label">Nationality:</span>
                        <span class="info-value">Filipino</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Birth Date:</span>
                        <span class="info-value">January 1, 2000</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Sex:</span>
                        <span class="info-value">Male</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Birth Place:</span>
                        <span class="info-value">Manila, Philippines</span>
                    </div> --}}
                </div>

            </div>
        </div>
