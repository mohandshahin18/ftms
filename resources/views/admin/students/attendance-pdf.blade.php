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


    {{-- @dump( $->name ) --}}
    <div>
        <div class="row">
            <div>
                <div>
                    <h5>Student Name: {{ $student->name }}</h5>
                </div>

            </div>
            <div class="table mt-4">
                <table border="1">
                    <thead>
                        <tr>
                            <th style="width: 60%">Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student->attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->attendance_date }}</td>
                                <td>
                                    @if ($attendance->attendance_status == 1)
                                        <span style="color: #4CAF50">{{ __('admin.Presence') }}</span>
                                    @else
                                        <span style="color: #FF5252">{{ __('admin.Absence') }}</span>
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
