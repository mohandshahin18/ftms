<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Selection</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">
      <style>

            body {
                  background: url('{{ asset('adminAssets/dist/img/selection/bg.jpg') }}') center center no-repeat;
                  background-size: cover !important;
                  min-height: 100vh;
            }

            a {
                  text-decoration: none;
                  color: #333;
                  display: inline-block;
            }

            .container {
                  height: 100vh;
            }

            .boxes {
                  min-height: 100%;
                  display: flex;
                  align-items: center;
                  text-align: center;
            }

            .box {
                  padding: 0 !important;
                  border-radius: 20px;
                  transition: all 0.3s ease-in-out;
                  height: 150px;
                  display: flex;
                  align-items: center;
                  justify-content: center;

            }

            .box:hover {
                  box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.2);
                  background-color: rgba(255, 255, 255, 0.422);
            }

            .box:first-child img {
                  width: 80px;
            }

            .box img {
                  width: 120px;
                  object-fit: cover;
            }
      </style>


</head>
<body>
      <div class="container">
            <div class="row boxes">
                  <a class="col-lg-3 col-sm-6 box" href="{{ route('login.show','admin') }}">
                        <div>
                              <img src="{{ asset('adminAssets/dist/img/selection/admin.png') }}" class="img-responsive" alt="">
                              <h6>Admin</h6>
                        </div>
                  </a>
                  <a class="col-lg-3 col-sm-6 box" href="{{ route('login.show','teacher') }}">
                        <div>
                              <img src="{{ asset('adminAssets/dist/img/selection/teacher.png') }}" class="img-responsive" alt="">
                              <h6>Teacher</h6>
                        </div>
                  </a>
                  <a class="col-lg-3 col-sm-6 box" href="{{ route('login.show','company') }}">
                        <div>
                              <img src="{{ asset('adminAssets/dist/img/selection/company.png') }}" class="img-responsive" alt="">
                              <h6>Company</h6>
                        </div>
                  </a>
                  <a class="col-lg-3 col-sm-6 box" href="{{ route('login.show','trainer') }}">
                        <div>
                              <img src="{{ asset('adminAssets/dist/img/selection/trainer.png') }}" class="img-responsive" alt="">
                              <h6>Trainer</h6>
                        </div>
                  </a>
            </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
