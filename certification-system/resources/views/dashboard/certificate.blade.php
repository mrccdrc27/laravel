@extends('layout.layout')
@section('content')
    <style>
        .hero-section {
            position: relative;
            height: 60vh;
            background-color: #3A7CA5;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .hero-text {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            max-width: 800px;
            padding: 0 1rem;
        }

        .api-documentation {
            background-color: #f8f9fa;
            padding: 3rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
        }

        .code-block {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 1.5rem;
            border-radius: 0.5rem;
            font-family: 'Courier New', monospace;
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }

        .endpoint-description {
            background-color: white;
            border-left: 4px solid #3A7CA5;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>



    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-text">
            <h1 class="display-3 fw-bold mb-3">API Certification Creation</h1>
            <p class="lead">Seamless Integration for Learning Management Systems</p>
        </div>
    </div>

    <!-- API Documentation Section -->
    <div class="container">
        <div class="api-documentation">
            <h2 class="mb-4">API Endpoint for Certification Creation</h2>

            <div class="endpoint-description">
                <h3 class="h4 mb-3">Endpoint Details</h3>
                <p><strong>Method:</strong> POST</p>
                <p><strong>URL:</strong> <code>/api/cert</code></p>
                <p><strong>Method:</strong> DELETE</p>
                <p><strong>URL:</strong> <code>/api/cert/{id}</code></p>
            </div>
            

            <div class="endpoint-description">
                <h3 class="h4 mb-3">Required Parameters</h3>
                <ul>
                    <li><strong>certificationNumber:</strong> Unique identifier for the certification</li>
                    <li><strong>courseID:</strong> ID of the course from the LMS</li>
                    <li><strong>title:</strong> Title of the certification</li>
                    <li><strong>description:</strong> Description of the certification</li>
                    <li><strong>issuedAt:</strong> Date of certification issuance</li>
                </ul>
            </div>


            <div class="step-content">
                <h3 class="step-title">Optional: Digital Signature</h3>
                <p class="step-description">
                    For enhanced credibility, consider adding a digital signature
                    from an authorized representative of your organization.
                </p>
            </div>




            <div class="code-block">
                <pre class="text-white m-0">{
    "certificationNumber": "CERT-2025-001",
    "courseID": 12345,
    "title": "Advanced Python Programming",
    "description": "Certification for completing advanced Python course",
    "issuedAt": "2024-01-26",
    "expiryDate": "2025-01-26", // Optional
    "issuerID": 67890, // Optional
    "userID": 54321 // Optional
}</pre>
            </div>

            <div class="endpoint-description">
                <h3 class="h4 mb-3">Successful Response</h3>
                <div class="code-block">
                    <pre class="text-white m-0">{
    "success": true,
    "certificationID": 123,
    "certificationNumber": "CERT-2025-001",
    "viewCertificateLink": "http://your-domain.com/cert/details/123"
}</pre>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Integration Notes:
                <ul>
                    <li>Ensure your LMS can generate a unique certification number</li>
                    <li>Validate course and user IDs before submission</li>
                    <li>Handle potential API errors in your LMS integration</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-primary text-white py-5 text-center">
        <div class="container">
            <h2 class="display-5 mb-4">Ready to Integrate?</h2>
            <p class="lead mb-4">
                Contact our support team for API documentation and integration assistance.
            </p>
            <a href="mailto:api-support@certify.com" class="btn btn-light btn-lg">
                Get API Documentation
            </a>
        </div>
    </div>
@endsection
