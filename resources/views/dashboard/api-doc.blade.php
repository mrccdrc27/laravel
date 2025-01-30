@extends('layout.layout')
@section('content')
    <!-- Previous styles remain unchanged -->
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
            <h1 class="display-3 fw-bold mb-3">Certification API Documentation</h1>
            <p class="lead">Complete RESTful API Documentation for Certificate Management</p>
        </div>
    </div>

    <!-- API Documentation Section -->
    <div class="container">
        <div class="api-documentation">
            <h2 class="mb-4">API Endpoints</h2>

            <!-- Create Certificate -->
            @php
                $createCertParams = [
                    'certificationNumber' => 'Unique identifier for the certification',
                    'courseID' => 'ID of the course from your LMS',
                    'title' => 'Title of the certification',
                    'description' => 'Description of the certification',
                    'issuedAt' => 'Date of certification issuance',
                    'expiryDate' => 'Expiration date | Optional',
                    'issuerID' => 'Official issuer ID | Optional',
                    'userID' => 'ID of the student user',
                ];

                $createCertRequest = '{
    "certificationNumber": "CERT-2025-001",
    "courseID": 12345,
    "title": "Advanced Python Programming",
    "description": "Certification for completing advanced Python course",
    "issuedAt": "2024-01-26",
    "expiryDate": "2025-01-26",
    "issuerID": 67890,
    "userID": 54321
}';

                $createCertResponse = '{
    "success": true,
    "certificationID": 123,
    "certificationNumber": "CERT-2025-001",
    "viewCertificateLink": "http://your-domain.com/cert/details/123"
}';
            @endphp

            <x-api-docs method="POST" endpoint="/api/cert" :parameters="$createCertParams" :requestExample="$createCertRequest" :responseExample="$createCertResponse" />

            <!-- Get Certificate -->
            @php
                $getCertRequest = 'No request body needed';
                $getCertResponse = '{
    "success": true,
    "data": {
        "certificationID": "1",
        "certificationNumber": "CERT-001",
        "courseID": "1",
        "title": "Introduction to Computer Science",
        "description": "Certification for completing Introduction to Computer Science course",
        "issuedAt": "2025-01-27 21:12:04.740",
        "expiryDate": "2026-01-27",
        "userID": "3",
        "issuerFirstName": "Burt",
        "issuerLastName": "Goodman",
        "issuerID": "1",
        "organizationName": "Lumon Industries"
    },
    "certificateLink": "http://127.0.0.1:8000/cert/details/1"
}';
            @endphp

            <x-api-docs method="GET" endpoint="/api/cert/{id}" :requestExample="$getCertRequest" :responseExample="$getCertResponse" />

            <!-- Update Certificate -->
            @php
                $updateCertParams = [
                    'courseID' => 'ID of the course | Optional',
                    'title' => 'Title of the certification | Optional',
                    'description' => 'Description of the certification | Optional',
                    'issuedAt' => 'Date of certification issuance | Optional',
                    'expiryDate' => 'Expiration date | Optional',
                    'issuerID' => 'Official issuer ID | Optional',
                    'userID' => 'ID of the student user | Optional',
                ];

                $updateCertRequest = '{
    "title": "Updated Python Programming",
    "description": "Updated certification description",
    "expiryDate": "2026-01-26"
}';

                $updateCertResponse = '{
    "success": true,
    "message": "Certification updated successfully."
}';
            @endphp

            <x-api-docs method="PUT" endpoint="/api/cert/{id}" :parameters="$updateCertParams" :requestExample="$updateCertRequest" :responseExample="$updateCertResponse" />

            <!-- Delete Certificate -->
            @php
                $deleteCertRequest = 'No request body needed';
                $deleteCertResponse = '{
    "message": "Certification deleted successfully."
}';
            @endphp

            <x-api-docs method="DELETE" endpoint="/api/cert/{id}" :requestExample="$deleteCertRequest" :responseExample="$deleteCertResponse" />

            <!-- Verify Certificate -->
            @php
                $verifyCertRequest = 'No request body needed';
                $verifyCertResponse = '{
    "success": true,
    "data": {
        "certificate": {
            "certificationNumber": "CERT-001",
            "title": "Introduction to Computer Science",
            "issuedAt": "2025-01-27",
            "expiryDate": "2026-01-27"
        },
        "user": {
            "firstName": "John",
            "middleName": "M",
            "lastName": "Doe"
        },
        "course": {
            "title": "Introduction to Computer Science",
            "description": "Fundamental concepts of computer science"
        }
    }
}';
            @endphp

            <x-api-docs method="GET" endpoint="/api/cert/verify/{certificationNumber}" :requestExample="$verifyCertRequest" :responseExample="$verifyCertResponse" />

            <!-- Get User Certificates -->
            @php
                $userCertsRequest = 'No request body needed';
                $userCertsResponse = '{
    "success": true,
    "data": [
        {
            "certificationID": 1,
            "certificationNumber": "CERT-001",
            "title": "Introduction to Programming",
            "issuedAt": "2025-01-27",
            "certificateLink": "http://127.0.0.1:8000/cert/details/1"
        }
    ],
    "userFullName": "John M Doe"
}';
            @endphp

            <x-api-docs method="GET" endpoint="/api/user/{id}/certificates" :requestExample="$userCertsRequest" :responseExample="$userCertsResponse" />

            <!-- Search Certificates -->
            @php
                $searchCertParams = [
                    'firstName' => 'First name of the certificate holder | Optional',
                    'middleName' => 'Middle name of the certificate holder | Optional',
                    'lastName' => 'Last name of the certificate holder | Optional'
                ];

                $searchCertRequest = 'Example: GET /api/search/cert?firstName=John&lastName=Doe';
                $searchCertResponse = '[
    {
        "certificationID": 1,
        "certificationNumber": "CERT-001",
        "title": "Introduction to Programming",
        "issuedAt": "2025-01-27"
    }
]';
            @endphp

            <x-api-docs method="GET" endpoint="/api/search/cert" :parameters="$searchCertParams" :requestExample="$searchCertRequest" :responseExample="$searchCertResponse" />

            <!-- Get Certification Count -->
            @php
                $countRequest = 'No request body needed';
                $countResponse = '{
    "success": true,
    "count": 150,
    "signedCount": 120,
    "webCertificationsCount": 30
}';
            @endphp

            <x-api-docs method="GET" endpoint="/api/certification-count" :requestExample="$countRequest" :responseExample="$countResponse" />

            <div class="alert alert-info mt-4">
                <i class="bi bi-info-circle me-2"></i>
                Integration Notes:
                <ul>
                    <li>All endpoints return JSON responses</li>
                    <li>Authentication is required for write operations (POST, PUT, DELETE)</li>
                    <li>Dates should be provided in ISO 8601 format (YYYY-MM-DD)</li>
                    <li>Error responses include detailed messages for troubleshooting</li>
                    <li>Rate limiting may apply to prevent abuse</li>
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