<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Update to your CSS file path -->
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>403</h1>
        <h3>Forbidden</h3>
        <p>You don't have permission to access this resource.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
    </div>
</body>
</html>
