<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('admin.Verify Email') }}</title>
    @if(app()->getLocale() == 'ar')
        <style>
            body{
                direction: rtl;
            }
        </style>
    @endif
</head>
<body style="background: #eee ; font-family: Arial, Helvetica, sans-serif">
    @php
    $data = json_decode(File::get(storage_path('app/settings.json')), true);
    @endphp
    <div style="width: 550px ; background: #fff ; padding:20px; border: 2px solid #cfcfcf ; margin: 50px auto;">
        <div style="text-align: center;">
            <img src="{{ asset($data['darkLogo']) }}"  style="width: 170px" alt="">
       </div>
        <h1>{{ __('admin.Hello!') }}</h1>
        <p style="color: #959a9a; line-height: 2; margin-bottom: 30px;">{{ __('admin.You are receiving this email because we have received your confirmation email request .') }}</p>
        <div style="text-align: center; margin:40px auto;">
            <a href="{{ route('admin.Eamilverify', [$slug,$actor]) }}" style="background: #1a2e44; color: #fff; text-decoration: none; padding: 12px 14px; border-radius: 5px; ">{{ __('admin.Verify Email') }}</a>
        </div>
        <h5 style="margin-bottom: 5px;">{{ __('admin.Best Regards') }}</h5>
        <h5 style="margin-top: 10px;">FTMS</h5>

    </div>
</body>
</html>
