<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Toys Page</h1>
        <nav>
            <a href="<?php echo e(route('home')); ?>">Home</a>
            <a href="<?php echo e(route('toys')); ?>">Toys</a>
            <a href="<?php echo e(route('qr-code')); ?>">QR Codes</a>

        </nav>
        <hr>
        <p>This is the toys page</p>
        <div>
            <ul>
                <?php $__currentLoopData = $toys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($toy->name); ?> - $<?php echo e($toy->price); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <hr>
    </header>

</body>

</html>
<?php /**PATH C:\Users\Bentulan\source\repos\laravel\test\resources\views/toys.blade.php ENDPATH**/ ?>