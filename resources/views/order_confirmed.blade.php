<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmed</title>
</head>
<body>
    <div>
        <h3>Order confirmed!</h3>
        <p>Thank you for your purchase.</p>
    </div>

    <script>
        setTimeout(() => {
            window.open('', '_self').close(); // Attempt to close the window
            window.location.href = 'about:blank'; // Fallback navigation attempt
        }, 3000);
    </script>
</body>
</html>
