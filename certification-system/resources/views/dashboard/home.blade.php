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

  <!-- Content of the page -->
  <div style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 20px;">
    <!-- Home Page Content -->
    <main style="width: 100%; max-width: 600px;">
      <section style="margin-bottom: 30px;">
        <h1>This page is just filler, there is no functionality</h1>
        <h1>Welcome to the Certification System</h1>
        <p>Use this system to generate and manage certifications with ease.</p>
      </section>

      <!-- Certification Form -->
      <section style="margin-bottom: 30px;">
        <h2>Generate a Certificate</h2>
        <form action="" method="POST" style="display: flex; flex-direction: column; align-items: center;">
          @csrf
          <label for="studentName" style="margin-bottom: 10px; width: 100%;">Student Name:</label>
          <input type="text" id="studentName" name="studentName" placeholder="Enter the student's name" required style="margin-bottom: 20px; width: 100%; padding: 10px;">

          <label for="courseName" style="margin-bottom: 10px; width: 100%;">Course Name:</label>
          <input type="text" id="courseName" name="courseName" placeholder="Enter the course name" required style="margin-bottom: 20px; width: 100%; padding: 10px;">

          <label for="issueDate" style="margin-bottom: 10px; width: 100%;">Issue Date:</label>
          <input type="date" id="issueDate" name="issueDate" required style="margin-bottom: 20px; width: 100%; padding: 10px;">

          <button type="submit" style="padding: 10px 20px; cursor: pointer;">Generate Certificate</button>
        </form>
      </section>

      <!-- Sample Certificates -->
      <section>
        <h2>Sample Certificates</h2>
        <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background: #f9f9f9;">
          <p><strong>Certificate of Completion</strong></p>
          <p><em>John Doe</em></p>
          <p>Successfully completed the course: <em>Advanced Web Development</em></p>
          <p><small>Issued on: 2024-02-01</small></p>
        </div>
        <div style="padding: 15px; border: 1px solid #ccc; border-radius: 5px; background: #f9f9f9;">
          <p><strong>Certificate of Achievement</strong></p>
          <p><em>Jane Smith</em></p>
          <p>Successfully completed the course: <em>Data Science Basics</em></p>
          <p><small>Issued on: 2024-03-15</small></p>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
