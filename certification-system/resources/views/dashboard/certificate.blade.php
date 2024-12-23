<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate Template</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <style>
    /* Add any specific styles here for the certificate layout */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
    }
    .navbar-menu {
      list-style-type: none;
      padding: 0;
    }
    .navbar-menu li {
      display: inline;
      margin: 0 15px;
    }
    .navbar-menu a {
      color: white;
      text-decoration: none;
    }
    .certificate-container {
      width: 80%;
      margin: 40px auto;
      padding: 30px;
      border: 2px solid #000;
      background-color: white;
      border-radius: 10px;
      text-align: center;
    }
    .certificate-header {
      margin-bottom: 20px;
    }
    .organization-logo {
      width: 100px;
      height: auto;
      display: block;
      margin: 0 auto;
    }
    .certificate-title {
      font-size: 36px;
      font-weight: bold;
      margin-top: 20px;
    }
    .certificate-body {
      font-size: 18px;
      margin-top: 20px;
    }
    .awardee-name {
      font-weight: bold;
      text-decoration: underline;
    }
    .qr-code-container {
      margin-top: 30px;
    }
    .qr-code {
      margin-top: 20px;
    }
    .footer {
      margin-top: 40px;
      font-size: 14px;
    }
    .footer img {
      width: 100px;
      height: auto;
      display: block;
      margin: 20px auto;
    }
  </style>
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

  <!-- Certificate Container -->
  <div class="certificate-container">
    <div class="certificate-header">
      <img src="data:image/jpeg;base64,{{$data['organizationLogo']}}" alt="Organization Logo" class="organization-logo">
      <h1 class="organization-name">{{$data['organizationName']}}</h1>
    </div>

    <!-- Certificate Title -->
    <h2 class="certificate-title">Certificate of Achievement</h2>

    <!-- Certificate Body -->
    <div class="certificate-body">
      <p>This is to certify that <span class="awardee-name">{{$data['firstName']}} {{$data['lastName']}}</span> has successfully completed the</p>
      <h3 class="certification-title">{{$data['title']}}</h3>
      <p>Description: {{$data['description']}}</p>
    </div>

    <!-- Certificate Details -->
    <div class="footer">
      <p><strong>Certification Number:</strong> {{$data['certificationNumber']}}</p>
      <p><strong>Issued At:</strong> {{$data['issuedAt']}}</p>
      <p><strong>Expiry Date:</strong> {{$data['expiryDate']}}</p>
      <img src="data:image/jpeg;base64,{{$data['IssuerSignature']}}" alt="Signature">
      <p><strong>Issued By:</strong> {{$data['issuerID']}}</p>
    </div>

    <!-- QR Code -->
    <div class="qr-code-container">
      <h3>QR Code:</h3>
      {!! QrCode::size(150)->generate(url("http://127.0.0.1:8000/api/v2/certifications/{$data['certificationID']}")) !!}
      <p>Scan to verify the certification</p>
    </div>
  </div>
</body>

api/v1/certifications/{certification}
</html>
