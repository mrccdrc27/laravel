<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }

        h1 {
            font-size: 50px;
            color: #333;
        }

        p {
            font-size: 20px;
            color: #777;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <h1>404</h1>
    <p>Oops! The page you are looking for doesn't exist.</p>
    <a href="{{ url('/') }}">Go Back to Home</a>
</body>

</html>
