<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name') }} | {{ __('admin.Contact Us') }}</title>
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
    <div style="width: 600px ; background: #fff ; padding:20px; border: 2px solid #cfcfcf ; margin: 50px auto;">
        <div style="text-align: center;">
            <img src="{{ asset($data['darkLogo']) }}"  style="width: 170px" alt="">
       </div>
        <h4>{{ __('admin.Dear Admin') }}</h4>
        <p>{{ __('admin.Hope this mail finds you well') }}</p>
        <br>
        <p>{{ __('admin.There is a new contact us entry as below :') }}</p>
        <p><b>{{ __('admin.Name') }} : </b>{{ $data['firstname']  }} {{ $data['lastname']  }}  </p>
        <p><b>{{ __('admin.Email') }} : </b>{{ $data['email'] }} </p>
        <p><b>{{ __('admin.Message') }} : </b>{{ $data['message'] }} </p>
        <br>
        <br>

        <h5 style="margin-bottom: 5px;">{{ __('admin.Best Regards') }}</h5>
        <h5 style="margin-top: 10px;">FTMS</h5>

    </div>
</body>
</html>
