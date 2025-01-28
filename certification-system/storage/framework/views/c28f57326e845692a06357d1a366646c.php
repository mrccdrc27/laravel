<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="text-center mb-4" style="color: var(--primary-color)">Our Partners</h2>
    
    <div class="card shadow">
        <div id="organizationCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Carousel items -->
            <div class="carousel-inner">
                <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orgId => $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>"
                         data-org-id="<?php echo e($orgId); ?>">
                        <div class="carousel-image-container d-flex justify-content-center align-items-center">
                            <img src="<?php echo e($org['logo']); ?>" 
                                 class="carousel-image"
                                 alt="<?php echo e($org['name']); ?>">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Carousel controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#organizationCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#organizationCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Organization name and Issuers section -->
        <div class="card-body py-4">
            <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orgId => $org): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="organization-section <?php echo e($loop->first ? 'd-block' : 'd-none'); ?>" 
                     data-org-id="<?php echo e($orgId); ?>">
                    
                    <h3 class="text-center mb-5"><?php echo e($org['name']); ?></h3>
                    
                    <?php if(count($org['issuers']) > 0): ?>
                        <div class="issuers-section">
                            <h4 class="text-center mb-4" style="color: var(--secondary-color)">Authorized Issuers</h4>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
                                <?php $__currentLoopData = $org['issuers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issuer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col">
                                        <div class="card h-100 issuer-card">
                                            <div class="card-body text-center p-4">
                                                <h5 class="card-title mb-3">
                                                    <?php echo e($issuer['firstName']); ?>

                                                    <?php echo e($issuer['middleName'] ? $issuer['middleName'] . ' ' : ''); ?>

                                                    <?php echo e($issuer['lastName']); ?>

                                                </h5>
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted">No authorized issuers available.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<style>
.carousel {
    background-color: white;
}

.carousel-image-container {
    height: 400px;
    background-color: white;
    padding: 2rem;
}

.carousel-image {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    margin: auto;
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
    background-color: rgba(0, 0, 0, 0.1);
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: rgba(0, 0, 0, 0.2);
}

.carousel-indicators {
    display: none;
}

.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.issuer-card {
    border: 1px solid rgba(0,0,0,0.1) !important;
    transition: transform 0.2s ease-in-out;
    background-color: #fff;
}

.issuer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.signature-container {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.signature-image {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.issuers-section {
    max-width: 1200px;
    margin: 0 auto;
}


.organization-section {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.organization-section.d-block {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('organizationCarousel');
    const sections = document.querySelectorAll('.organization-section');
    
    // Function to update organization section
    function updateOrganizationSection(orgId) {
        sections.forEach(section => {
            if (section.dataset.orgId === orgId) {
                section.classList.remove('d-none');
                // Small delay to trigger fade in animation
                setTimeout(() => section.classList.add('d-block'), 50);
            } else {
                section.classList.remove('d-block');
                section.classList.add('d-none');
            }
        });
    }

    // Update sections before the slide changes
    carousel.addEventListener('slide.bs.carousel', function(event) {
        const nextSlide = event.relatedTarget;
        const nextOrgId = nextSlide.dataset.orgId;
        updateOrganizationSection(nextOrgId);
    });

    // Initial setup
    const activeSlide = carousel.querySelector('.carousel-item.active');
    if (activeSlide) {
        updateOrganizationSection(activeSlide.dataset.orgId);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/dashboard/org.blade.php ENDPATH**/ ?>