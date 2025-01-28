
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'method',
    'endpoint',
    'requestExample',
    'responseExample',
    'parameters' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'method',
    'endpoint',
    'requestExample',
    'responseExample',
    'parameters' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="row g-4 mb-4">
    
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <span class="badge bg-secondary me-2"><?php echo e($method); ?></span>
                    <?php echo e($endpoint); ?>

                </h5>
            </div>
            <div class="card-body">
                <?php if($parameters): ?>
                    <div class="mb-3">
                        <h6 class="fw-bold">Required Parameters:</h6>
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = $parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param => $desc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="mb-2">
                                    <code><?php echo e($param); ?></code>: <?php echo e($desc); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="code-block">
                    <pre class="text-white m-0"><?php echo e($requestExample); ?></pre>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">Response</h5>
            </div>
            <div class="card-body">
                <div class="code-block">
                    <pre class="text-white m-0"><?php echo e($responseExample); ?></pre>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/components/api-docs.blade.php ENDPATH**/ ?>