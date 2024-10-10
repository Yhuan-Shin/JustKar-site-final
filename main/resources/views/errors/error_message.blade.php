<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Include your CSS file here -->
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <img src="{{ asset('images/warning.png') }}" alt="" width="100px" height="100px">
        <h1>Unauthorized Access</h1>
        <p>Your IP address <strong>{{ $ip_address }}</strong> is not authorized to access this page.</p>
        <p>Please contact the administrator if you believe this is a mistake.</p>
    </div>
</body>
</html>
