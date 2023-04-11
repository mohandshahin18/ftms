<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>التقييم</title>

    <style>
        table {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        td,
        th {
            text-align: right !important;
            padding: 15px !important;
        }

        th {
            background-color: #090441 !important;
            color: #fff !important;
        }

        * {
            direction: rtl;
        }
    </style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif !important;">

    <div style="text-align: center; margin-bottom: 10px; margin-top: 50px;">
        <img src="{{ public_path('adminAssets/dist/img/logo/logo.png') }}" width="180" alt="">
    </div>
    
    <div>
        <div class="row">
            <div
                style="direction: rtl;">
                <div>
                    <h1 style="text-align: center; font-size: 30px;">تقييم الطالب</h1>
                    <h5>اسم الطالب: {{ $student->name }}</h5>
                </div>
                <div>
                    <p>%التقييم الكلي: {{ $total_rate }}</p>
                </div>

            </div>
            <div class="table mt-4">
                <table class="table table-striped table-hover" border="1" style="direction: rtl;">
                    <thead>
                        <tr>
                            <th style="width: 80%;">السؤال</th>
                            <th>الإجابة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $id => $answer)
                            <tr>
                                <td>{{ get_question_name($id) }}</td>
                                <td>{{ $answer }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
