<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            color: #333;
        }

        .error-container {
            max-width: 600px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .error-message {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .error-description {
            font-size: 16px;
            color: #777;
            margin-bottom: 30px;
        }

        .home-button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Oops! Page Not Found</div>
        <div class="error-description">
            The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </div>
        <button class="home-button" onclick="goHome()">Go to Home</button>
    </div>

    <script>
        function goHome() {
            window.location.href = '/';
        }
    </script>
</body>

</html>