<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LMS Landing</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="bg-gray-100">

    @if (Route::has('login'))
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white p-10 rounded-lg shadow-lg max-w-lg w-full">

            <div class="text-center space-y-6">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary px-8 py-4 text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700 transition duration-300 text-xl">
                        Dashboard
                    </a>
                @else
                    <div>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-8 py-4 text-blue-600 border border-blue-600 rounded-md shadow-md hover:bg-blue-100 transition duration-300 text-xl">
                            Log in
                        </a>
                        <br>
                        <br>
                    </div>
                    @if (Route::has('register'))
                        <div>
                            <a href="{{ route('register') }}" class="btn btn-outline-success px-8 py-4 text-green-600 border border-green-600 rounded-md shadow-md hover:bg-green-100 transition duration-300 text-xl">
                                Register
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endif



</body>
</html>
