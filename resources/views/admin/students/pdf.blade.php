<!DOCTYPE html>
<html lang="en">
<head>

      <?php $name = $student->name; ?>
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

      td,th {
            text-align: left;
            padding: 8px;
      }

      th {
            background-color: #090441;
            color: #fff;
            
      }
      </style>

</head>
<body>
      
      

      <div>
            <div class="row">
                  <div class="col-12 header mt-4">
                        <h3>{{ $applied_evaluation->evaluation->name }} Evaluation</h3>
                        <h5>Student Name: {{ $student->name }}</h5>
                  
                  </div>
                  <div class="table mt-4">
                        <table border="1">
                              <thead>
                                    <tr>
                                          <th style="width: 60%">Question</th>
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