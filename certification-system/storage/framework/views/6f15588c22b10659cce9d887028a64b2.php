<div>
    <?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['method', 'endpoint', 'requestExample', 'responseExample']));

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

foreach (array_filter((['method', 'endpoint', 'requestExample', 'responseExample']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

    <div id="api-endpoint-<?php echo e($endpoint); ?>" data-method="<?php echo e($method); ?>" data-endpoint="<?php echo e($endpoint); ?>" data-request="<?php echo e(json_encode($requestExample)); ?>" data-response="<?php echo e(json_encode($responseExample)); ?>"></div>
</div><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/components/api-endpoint.blade.php ENDPATH**/ ?>