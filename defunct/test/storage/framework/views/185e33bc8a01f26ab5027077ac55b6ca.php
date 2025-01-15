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
        <h1>Home Page</h1>
        <nav>
            <a href="<?php echo e(route('home')); ?>">Home</a>
            <a href="<?php echo e(route('toys')); ?>">Toys</a>
            <a href="<?php echo e(route('qr-codes')); ?>">QR Codes</a>
        </nav>
        <hr>
    </header>
    <h2>Toy Details</h2>
    <p><strong>Name:</strong> <?php echo e($toy->name); ?></p>
    <p><strong>Price:</strong> $<?php echo e(number_format($toy->price, 2)); ?></p>
    <p><strong>Created At:</strong> <?php echo e($toy->created_at); ?></p>
    <p><strong>Updated At:</strong> <?php echo e($toy->updated_at); ?></p>

    <h3>QR Code</h3>
    <div>
        <!-- Display the generated QR code -->
        <?php echo $qrCode; ?>

    </div>
</body>

</html><?php /**PATH C:\Users\Bentulan\source\repos\laravel\test\resources\views/qrModule/qrPage.blade.php ENDPATH**/ ?>