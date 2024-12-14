<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Code</title>
</head>

<body>
    <header>
        <h1>Home Page</h1>
        <nav>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('toys') }}">Toys</a>
            <a href="{{ route('qr-code') }}">QR Codes</a>
        </nav>
        <hr>
    </header>
    <h1>Toy Details</h1>
    <p><strong>Name:</strong> {{ $toy->name }}</p>
    <p><strong>Price:</strong> ${{ number_format($toy->price, 2) }}</p>
    <p><strong>Created At:</strong> {{ $toy->created_at }}</p>
    <p><strong>Updated At:</strong> {{ $toy->updated_at }}</p>

    <h2>QR Code</h2>
    <div>
        <!-- Display QR Code object -->
        {!! $qrCode !!}
    </div>
</body>

</html>
