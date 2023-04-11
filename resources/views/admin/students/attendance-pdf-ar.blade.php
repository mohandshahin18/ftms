<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            text-align: right;
            padding: 15px;
        }

        th {
            background-color: #090441;
            color: #fff;
        }

        .info {
            display: flex;
            display: -webkit-flex;
            -webkit-align-self: center;
            align-self: center;
            webkit-justify-content: space-between;
            justify-content: space-between;
            direction: rtl;
        }

        * {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>

</head>

<body>


    <div style="text-align: center; margin-bottom: 10px; margin-top: 50px;">
        <img src="{{ public_path('adminAssets/dist/img/logo/logo.png') }}" width="180" alt="">
    </div>
    <div>
        <div class="row">
            <div>
                <div class="info">
                    <h1 style="text-align: center; font-size: 30px; margin-bottom: 25px;">سجل الحضور و الغياب</h1>
                    <h5>اسم الطالب: {{ $student->name }}</h5>
                    <p style="margin-bottom: 10px;">الرقم الجامعي: {{ $student->student_id }}</p>
                    <p style="margin-bottom: 10px;">شركة التدريب: {{ $student->company->name }}</p>
                </div>

            </div>
            <div class="table mt-4">
                <table border="1" style="direction: rtl;">
                    <thead>
                        <tr>
                            <th>اليوم</th>
                            <th>التاريخ</th>
                            <th>حالة الحضور</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->dayName }}</td>
                                <td>{{ $attendance->attendance_date }}</td>
                                <td>
                                    @if ($attendance->attendance_status == 1)
                                        <span style="color: #4CAF50">حضور</span>
                                    @else
                                        <span style="color: #FF5252">غياب</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
