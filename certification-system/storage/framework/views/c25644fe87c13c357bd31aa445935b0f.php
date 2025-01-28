<?php $__env->startSection('content'); ?>
    <style>
        .hero-section {
            position: relative;
            height: 60vh;
            background-image: url('<?php echo e(asset('storage/page.png')); ?>');
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
            background-color: rgba(0, 0, 0, 0.4);
        }

        .hero-text {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            max-width: 800px;
            padding: 0 1rem;
        }

        .certification-benefits {
            background-color: #f8f9fa;
            padding: 4rem 0;
        }

        #certification-counter {
            transition: transform 2s ease;

        }


        .counter-container {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
        }

        .counter-box {
            flex: 1;
            /* This ensures that both boxes take up equal width */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            min-height: 200px;
            /* Set a specific height for the counter boxes */
        }

        .bg-light {
            height: 100%;
            /* Ensure the card container takes up full height of the flex container */
        }
    </style>

    <!-- Hero Section with Background Image -->
    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-text">
            <h1 class="display-3 fw-bold mb-3">Get Certified</h1>
            <p class="lead">Elevate Your Professional Credentials and Unlock New Opportunities</p>
        </div>
    </div>

    <!-- Certification Benefits Section -->
    <div class="certification-benefits">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-graph-up-arrow display-4 text-primary mb-3"></i>
                            <h3 class="h4 mb-3">Career Advancement</h3>
                            <p class="text-muted">Certifications demonstrate expertise and can significantly boost your
                                career prospects and earning potential.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-shield-check display-4 text-success mb-3"></i>
                            <h3 class="h4 mb-3">Credibility</h3>
                            <p class="text-muted">Professional certifications validate your skills and knowledge, providing
                                credibility in your industry.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-globe display-4 text-info mb-3"></i>
                            <h3 class="h4 mb-3">Global Recognition</h3>
                            <p class="text-muted">Many certifications are recognized internationally, opening doors to
                                global opportunities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certification Counter Section -->
    <!-- Certification Counter Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- First Column: Certifications Created -->
            <div class="col-md-6 col-lg-4 text-center mb-4">
                <div class="bg-light p-4 rounded-4 shadow-sm d-flex flex-column justify-content-between">
                    <h3 class="mb-3 text-primary">
                        <i class="bi bi-award me-2"></i>Certifications Milestone
                    </h3>
                    <div id="certification-counter-container" class="counter-container">
                        <div class="counter-box">
                            
                            <div id="count-value" class="display-4 fw-bold text-dark">0</div>
                            <h4>Certifications created</h4>
                            <p class="lead text-muted">...and counting</p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Second Column: Signed Certifications -->
            <div class="col-md-6 col-lg-4 text-center mb-4">
                <div class="bg-light p-4 rounded-4 shadow-sm d-flex flex-column justify-content-between">
                    <h3 class="mb-3 text-primary">
                        <i class="bi bi-award me-2"></i>Signed Certificates
                    </h3>
                    <div class="counter-box">
                        <div id="signed-certificates-counter" class="display-4 fw-bold text-dark">0</div>
                        <h4>Certifications officially signed</h4>
                           
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certification Process Section -->
    <div class="container-fluid position-relative vh-100 d-flex justify-content-center align-items-center"
        style="background: url('<?php echo e(asset('storage/process.jpg')); ?>') no-repeat center center / cover;">
        <!-- Overlay to dim the background -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.5);"></div>

        <!-- Foreground content -->
        <div class="row text-center position-relative z-3">
            <div class="col-md-12 text-white">
                <h2 class="mb-4 ">Your Certification Journey</h2>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle text-primary me-3 fs-4"></i>
                        <span>Choose from a wide range of professional certifications</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle text-primary me-3 fs-4"></i>
                        <span>Complete online courses and training modules</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle text-primary me-3 fs-4"></i>
                        <span>Take comprehensive certification exams</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle text-primary me-3 fs-4"></i>
                        <span>Receive globally recognized certification</span>
                    </li>
                </ul>
                <!-- Button for Certification Process -->
                <a class="btn btn-primary btn-lg mt-4" href="<?php echo e(route('certificate')); ?>">
                    Certification Process
                </a>
            </div>
        </div>
    </div>



    <!-- Call to Action Section -->
    <div class="bg-primary text-white py-5 text-center">
        <div class="container">
            <h2 class="display-5 mb-4">Start Your Certification Journey Today</h2>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<script>
    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);

            // Easing function for smoother animation
            const easeOutQuad = progress => progress * (2 - progress);
            const currentValue = Math.floor(start + (end - start) * easeOutQuad(progress));

            element.textContent = currentValue.toLocaleString();

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                element.textContent = end.toLocaleString();
            }
        };

        window.requestAnimationFrame(step);
    }

    function updateCertificationCount() {
        const countElement = document.getElementById('count-value');
        const signedElement = document.getElementById('signed-certificates-counter');
        const currentCount = parseInt(countElement.textContent.replace(/,/g, '')) || 0;
        const currentSignedCount = parseInt(signedElement.textContent.replace(/,/g, '')) || 0;

        fetch("<?php echo e(route('getCertificationCount')); ?>")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const targetCount = data.count;
                    const targetSignedCount = data.signedCount;

                    // Animate if changes
                    if (targetCount !== currentCount) {
                        animateCounter(countElement, currentCount, targetCount, 2000); // 2-second animation
                    }

                    if (targetSignedCount !== currentSignedCount) {
                        animateCounter(signedElement, currentSignedCount, targetSignedCount,
                            2000); // 2-second animation
                    }
                }
            })
            .catch(error => {
                console.error("Error fetching certification count:", error);
            });
    }

    // Update the certification count immediately after page load
    window.addEventListener('load', updateCertificationCount);

    // Periodic updates
    setInterval(updateCertificationCount, 10000); // 20 seconds interval
</script>

<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/dashboard/home.blade.php ENDPATH**/ ?>