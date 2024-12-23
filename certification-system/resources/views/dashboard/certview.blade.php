<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate Template</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
</body>
</html>

