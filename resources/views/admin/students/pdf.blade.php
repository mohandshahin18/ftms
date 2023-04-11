<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluation</title>

    {{-- <link rel="stylesheet" href="{{ asset('pdfassets/style.css') }}"> --}}
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
                    <h1 style="text-align: center; font-size: 30px;">Student Evaluation</h1>
                    <h5>Student Name: {{ $student->name }}</h5>
                </div>
                <div>
                    <p>Total rate: {{ $total_rate }}%</p>
                </div>

            </div>
            <div class="table mt-4">
                <table border="1">
                    <thead>
                        <tr>
                            <th style="width: 80%">Question</th>
                            <th>Answer</th>
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
