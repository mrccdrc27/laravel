<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Details and QR Code</title>
</head>
<body>
    <h1>Toy Details</h1>
    <p><strong>Name:</strong> <?php echo e($toy->name); ?></p>
    <p><strong>Price:</strong> $<?php echo e(number_format($toy->price, 2)); ?></p>
    <p><strong>Created At:</strong> <?php echo e($toy->created_at); ?></p>
    <p><strong>Updated At:</strong> <?php echo e($toy->updated_at); ?></p>

    <h2>QR Code</h2>
    <div>
        <!-- Display the generated QR code -->
        <?php echo $qrCode; ?>

    </div>
</body>
</html>
<?php /**PATH C:\Users\Bentulan\source\repos\laravel\test\resources\views/qr_code.blade.php ENDPATH**/ ?>