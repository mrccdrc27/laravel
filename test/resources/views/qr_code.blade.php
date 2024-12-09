<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Details and QR Code</title>
</head>
<body>
    <h1>Toy Details</h1>
    <p><strong>Name:</strong> {{ $toy->name }}</p>
    <p><strong>Price:</strong> ${{ number_format($toy->price, 2) }}</p>
    <p><strong>Created At:</strong> {{ $toy->created_at }}</p>
    <p><strong>Updated At:</strong> {{ $toy->updated_at }}</p>

    <h2>QR Code</h2>
    <div>
        <!-- Display the generated QR code -->
        {!! $qrCode !!}
    </div>
</body>
</html>
