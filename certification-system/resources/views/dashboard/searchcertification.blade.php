<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>API Call Form</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-logo">
        <img src="{{ asset('css/CS logo.png') }}" alt="Logo" class="navbar-logo-img">
      </div>
      <ul class="navbar-menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('certificate') }}">Certificate</a></li>
        <li><a href="{{ route('search') }}">Search</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
    <form id="certificationForm">
        <label for="certificationID">Enter Certification ID:</label>
        <input type="text" id="certificationID" name="certificationID" required>
        <button type="submit">Submit</button>
    </form>

    <script>
        // Add event listener for form submission
        document.getElementById('certificationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get the certification ID from the input field
            const certificationID = document.getElementById('certificationID').value;

            // Construct the URL
            const url = `http://127.0.0.1:8000/api/v2/certifications/${certificationID}`;

            // Redirect the browser to the URL
            window.location.href = url;
        });
    </script>
</body>
</html>
