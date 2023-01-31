<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="background: #eee ; font-family: Arial, Helvetica, sans-serif">

    <div style="width: 600px ; background: #fff ; padding:20px; border: 2px solid #cfcfcf ; margin: 50px auto;">
        <h4>Dear {{ $name }} ,</h4>

        <p>Thanks for your registration your OTP Code is:</p>
        <h2 style="text-align: center; font-size: 50">{{ $code }}</h2>
        <br>
        <br>

        <h5>Best Regards</h5>

    </div>
</body>
</html>
