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
        {{-- <h1>Email Verification Mail</h1> --}}

        You can reset password from bellow link:
        <a href="{{ route('reset.password.get',[$type , $token] ) }}">Reset Password</a>
        <br>
        <br>

        <h5>Best Regards</h5>

    </div>
</body>
</html>
