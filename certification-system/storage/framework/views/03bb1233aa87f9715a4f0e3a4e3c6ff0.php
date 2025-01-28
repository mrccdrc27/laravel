<?php $__env->startSection('content'); ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Something Went Wrong</h4>
        <p>We're sorry, but an error occurred. Please try again later.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Return to Home</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/errors/generic_error.blade.php ENDPATH**/ ?>