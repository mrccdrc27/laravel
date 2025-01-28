<?php $__env->startSection('content'); ?>
    <div class="alert alert-warning">
        <h4 class="alert-heading">Certificate Not Found</h4>
        <p>The certificate with ID <?php echo e($certificateId); ?> does not exist or has been deleted.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Return to Certificates</a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/errors/error.blade.php ENDPATH**/ ?>