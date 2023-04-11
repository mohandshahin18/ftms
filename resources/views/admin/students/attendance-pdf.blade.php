<!DOCTYPE html>
<html lang="en">

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
            text-align: left;
            padding: 15px;
        }

        th {
            background-color: #090441;
            color: #fff;
        }
    </style>

</head>

<body style="font-family: Arial, Helvetica, sans-serif;">


    <div style="text-align: center; margin-bottom: 10px; margin-top: 50px;">
        <img src="{{ public_path('adminAssets/dist/img/logo/logo.png') }}" width="180" alt="">
    </div>
    <div>
        <div class="row">
            <div>
                <div>
                    <h1 style="text-align: center; font-size: 30px;">Attendance and absence record</h1>
                    <h3>Student Name: {{ $student->name }}</h3>
                    <p>Student ID: {{ $student->student_id }}</p>
                    <p style="margin-bottom: 10px;">Training Company: {{ $student->company->name }}</p>
                </div>

            </div>
            <div class="table mt-4">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->dayName }}</td>
                                <td>{{ $attendance->attendance_date }}</td>
                                <td>
                                    @if ($attendance->attendance_status == 1)
                                        <span style="color: #4CAF50">Presence</span>
                                    @else
                                        <span style="color: #FF5252">Absence</span>
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
