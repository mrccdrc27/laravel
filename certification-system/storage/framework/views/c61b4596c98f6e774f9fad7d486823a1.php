<?php $__env->startSection('content'); ?>
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
            <h2 class="mb-4">API Documentation</h2>

            <?php
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
            ?>

            <?php if (isset($component)) { $__componentOriginal16af7096fc2166a2d5440d0e9170efd7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16af7096fc2166a2d5440d0e9170efd7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.api-docs','data' => ['method' => 'POST','endpoint' => '/api/cert','parameters' => $createCertParams,'requestExample' => $createCertRequest,'responseExample' => $createCertResponse]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('api-docs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['method' => 'POST','endpoint' => '/api/cert','parameters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($createCertParams),'requestExample' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($createCertRequest),'responseExample' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($createCertResponse)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16af7096fc2166a2d5440d0e9170efd7)): ?>
<?php $attributes = $__attributesOriginal16af7096fc2166a2d5440d0e9170efd7; ?>
<?php unset($__attributesOriginal16af7096fc2166a2d5440d0e9170efd7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16af7096fc2166a2d5440d0e9170efd7)): ?>
<?php $component = $__componentOriginal16af7096fc2166a2d5440d0e9170efd7; ?>
<?php unset($__componentOriginal16af7096fc2166a2d5440d0e9170efd7); ?>
<?php endif; ?>

            <?php
                $deleteCertRequest = '{
    "certificationID": 123
}';

                $deleteCertResponse = '{
    "success": true,
    "message": "Certificate successfully deleted"
}';
            ?>

            <?php if (isset($component)) { $__componentOriginal16af7096fc2166a2d5440d0e9170efd7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16af7096fc2166a2d5440d0e9170efd7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.api-docs','data' => ['method' => 'DELETE','endpoint' => '/api/cert/{id}','requestExample' => $deleteCertRequest,'responseExample' => $deleteCertResponse]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('api-docs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['method' => 'DELETE','endpoint' => '/api/cert/{id}','requestExample' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deleteCertRequest),'responseExample' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deleteCertResponse)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16af7096fc2166a2d5440d0e9170efd7)): ?>
<?php $attributes = $__attributesOriginal16af7096fc2166a2d5440d0e9170efd7; ?>
<?php unset($__attributesOriginal16af7096fc2166a2d5440d0e9170efd7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16af7096fc2166a2d5440d0e9170efd7)): ?>
<?php $component = $__componentOriginal16af7096fc2166a2d5440d0e9170efd7; ?>
<?php unset($__componentOriginal16af7096fc2166a2d5440d0e9170efd7); ?>
<?php endif; ?>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/dashboard/certificate.blade.php ENDPATH**/ ?>