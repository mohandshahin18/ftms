<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="background: #eee ; font-family: Arial, Helvetica, sans-serif">

    <div style="width: 550px ; background: #fff ; padding:20px; border: 2px solid #cfcfcf ; margin: 50px auto;">
        <div style="text-align: center;">
            <img style="width: 120px;" src="{{ asset('adminAssets/dist/img/logo/logo-11.png') }}" alt="">
       </div>
        <h1>Hello!</h1>
        <p style="color: #959a9a; line-height: 2; margin-bottom: 30px;">You are receiving this email because we received a password reset request for your account .</p>
        <div style="text-align: center; margin:40px auto;">
            <a href="{{ route('reset.password.get',[$type , $token] ) }}" style="background: #1a2e44; color: #fff; text-decoration: none; padding: 12px 14px; border-radius: 5px; ">Reset Password</a>

        </div>
        <p style="color: #959a9a; line-height: 2; margin-bottom: 30px;">This password reset link will expire in 60 minutes .</p>


        <h5 style="margin-bottom: 5px;">Best Regards</h5>
        <h5 style="margin-top: 10px;">FTMS</h5>

    </div>
</body>
</html>
