<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal465912bafb53d2799b51398725f2e117 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal465912bafb53d2799b51398725f2e117 = $attributes; } ?>
<?php $component = App\View\Components\Search::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Search::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal465912bafb53d2799b51398725f2e117)): ?>
<?php $attributes = $__attributesOriginal465912bafb53d2799b51398725f2e117; ?>
<?php unset($__attributesOriginal465912bafb53d2799b51398725f2e117); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal465912bafb53d2799b51398725f2e117)): ?>
<?php $component = $__componentOriginal465912bafb53d2799b51398725f2e117; ?>
<?php unset($__componentOriginal465912bafb53d2799b51398725f2e117); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1 = $attributes; } ?>
<?php $component = App\View\Components\Searchname::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('searchname'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Searchname::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1)): ?>
<?php $attributes = $__attributesOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1; ?>
<?php unset($__attributesOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1)): ?>
<?php $component = $__componentOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1; ?>
<?php unset($__componentOriginalb9651d5af6aac4e7dfdfb02b1e4f42e1); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Bentulan\source\repos\laravel\certification-system\resources\views/dashboard/search.blade.php ENDPATH**/ ?>