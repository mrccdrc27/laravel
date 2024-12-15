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
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('toys') }}">Toys</a>
            <a href="{{ route('qr-code') }}">QR Codes</a>

        </nav>
        <hr>
        <p>This is the toys page</p>
        <div>
            <ul>
                @foreach ($toys as $toy)
                    <li>{{ $toy->name }} - ${{ $toy->price }}</li>
                @endforeach
            </ul>
        </div>
        <hr>
    </header>

</body>

</html>
