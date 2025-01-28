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

        img,
        svg {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            pointer-events: none;
            drag: none;
            -webkit-user-drag: none;
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
            margin-top: 5px;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 9px;
            position: relative;
            /* Add this */
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
            position: relative;
            margin-top: 80px;
            padding-bottom: 100px;
        }

        .signature-image {
            position: absolute;
            right: 1rem;
            bottom: 6.6rem;
        }

        .issuer-signature-line {
            border-top: 1px solid #000;
            margin: 2px auto;
            width: 150px;
        }

        .issuer-signature {
            font-size: 1rem;
            font-weight: bold;
            color: #000;
            margin-top: 2px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 5px;
            white-space: nowrap;
        }

        .issuer-info {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.6;
        }

        .issuer-logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 20px;
            width: 80px;
            height: 80px;
        }

        .issuer-logo img {
            width: 100%;
            height: 100%;
            margin-top: 0;
            outline: #2c0808 solid 2px;
            outline-style: outset;
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
            <div class="recipient-name"><?php echo e($certificateData->userInfo->firstName); ?>

                <?php echo e($certificateData->userInfo->lastName); ?></div>
            <div class="recipient-line"></div>
            <div class="certificate-description">
                <?php if($certificateData->issuer->firstName || $certificateData->issuer->lastName): ?>
                    This signed certificate is awarded to recognize the completion of <?php echo e($certificateData->courseName); ?>

                <?php else: ?>
                    This certificate is awarded to recognize the completion of <?php echo e($certificateData->courseName); ?>

                <?php endif; ?>
            </div>
            <div class="footer-section">
                <div class="qr-section">
                    <?php echo QrCode::size(60)->generate(url()->current()); ?>

                </div>

                <?php if(
                    !empty($certificateData->issuer->firstName) ||
                        !empty($certificateData->issuer->lastName) ||
                        $certificateData->issuer->issuerSignature_base64 ||
                        $certificateData->issuer->organization->logo_base64): ?>
                    <div class="issuer-group">
                        <div class="issuer-section">
                            <?php if($certificateData->issuer->issuerSignature_base64): ?>
                                <div class="signature-image">
                                    <img src="data:image/png;base64,<?php echo e($certificateData->issuer->issuerSignature_base64); ?>"
                                        alt="Signature" style="max-width: 150px; max-height: 50px;">
                                </div>
                            <?php endif; ?>

                            <?php if(!empty($certificateData->issuer->firstName) || !empty($certificateData->issuer->lastName)): ?>
                                <div class="issuer-signature-line"></div>
                                <div class="issuer-signature">
                                    <?php echo e($certificateData->issuer->firstName); ?>

                                    <?php echo e($certificateData->issuer->lastName); ?>

                                </div>
                            <?php endif; ?>

                            <?php if($certificateData->issuer->organization->logo_base64): ?>
                                <div class="issuer-logo">
                                    <img class="issuer-logo" style="max-width: 80px; max-height: 80px;"
                                        src="data:image/png;base64,<?php echo e($certificateData->issuer->organization->logo_base64); ?>"
                                        alt="Organization Logo" />
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

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
                        <span class="info-value"><?php echo e($certificateData->certificationNumber); ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Course:</span>
                        <span class="info-value"><?php echo e($certificateData->courseName); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Description:</span>
                        <span class="info-value"><?php echo e($certificateData->courseDescription); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Issued At:</span>
                        <span class="info-value"><?php echo e($certificateData->issuedAt); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Expiry Date:</span>
                        <span class="info-value"><?php echo e($certificateData->expiryDate); ?></span>
                    </div>
                </div>

                <!-- Student Info -->
                <div class="certificate-column">
                    <div class="section-title">Student Information</div>
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span
                            class="info-value"><?php echo e($certificateData->userInfo->firstName); ?><?php echo e($certificateData->userInfo->middleName); ?>

                            <?php echo e($certificateData->userInfo->lastName); ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo e($certificateData->userInfo->email); ?></span>
                    </div>
                    
                </div>

            </div>
        </div>
<?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/certview.blade.php ENDPATH**/ ?>