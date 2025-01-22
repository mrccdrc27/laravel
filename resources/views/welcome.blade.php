<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa; /* Light gray background for better contrast */
        }
    </style>
</head>
<body>
    @if (Route::has('login'))
        <div class="text-center">
            @auth
                <a href="{{ url('/home') }}" class="btn btn-primary mb-3">
                    Dashboard
                </a>
            @else
                <div>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary mb-3">
                        Log in
                    </a>
                </div>
                @if (Route::has('register'))
                    <div>
                        <a href="{{ route('register') }}" class="btn btn-outline-success">
                            Register
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    @endif

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
