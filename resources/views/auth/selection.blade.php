<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | Selection Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">
<style>
      @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap');

    body {
      height: 100vh;
      background: url('{{ asset('adminAssets/dist/img/selection/bg.png') }}') no-repeat center center;
      font-family: "Barlow", sans-serif;
      background-size: cover !important;
      backdrop-filter: blur(5px); 

      padding-bottom: 40px;
    }

    a {
      text-decoration: none;
      color: #000;
    }

    a:hover {
      color: #000;
    }

    .logo, .title{
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .title {
      gap: 5px;
    }

    .boxes .box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 300px;
    }
    .boxes .box img {
      transition: all 0.3s ease;
    }

    .boxes .box h6 {
      font-size: 1.2rem;
    }

    .boxes .box:hover img{
      filter: drop-shadow(2px 8px 8px #585858);
      animation: card_movment 1.5s ease-in-out infinite;

    }

    .boxes .box img {
      width: 100px;
      height: 100px;
      margin-bottom: 20px;
      object-fit: cover;
    }


    @keyframes card_movment {
      0% {
        transform: translateZ(0px);
        transform: translateY(0px);
      }
      50% {
        transform: translateZ(10px);
        transform: translateY(-8px);
      }
    }




    .wrapper {
      display: grid;
      place-items: center;
    }

    .typing-demo {
      width: 12ch;
      animation: typing 2.5s steps(22, end) forwards, blink .5s step-end infinite alternate;
      white-space: nowrap;  
      overflow: hidden;
      border-right: 3px solid;
      font-size: 2.4em;
    }

    @keyframes typing {
      from {
        width: 0
      }
      to {
        width: 12ch;
      }
      
    }

        
    @keyframes blink {
      50% {
        border-color: transparent
      }
    }

    .typing-demo:nth-of-type(2n) {
      animation-delay: 5s;
    }

</style>
    
  </head>
  <body>
    <div class="container">
      <div class="row boxes">
        <div class="logo mt-5">
          <img src="{{ asset('adminAssets/dist/img/logo/logo-11.png') }}" class="img-responsive" width="100px" alt="">
        </div>
        <div class="wrapper mt-5">
          <div class="typing-demo">
            Selection Page </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt-5">
          <a href="{{ route('login.show','admin') }}">
            <div class="box">
              <img src="{{ asset('adminAssets/dist/img/selection/admin.png') }}" alt="">
              <h6>Admin</h6>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-sm-6 mt-5">
          <a href="{{ route('login.show','company') }}">
            <div class="box">
              <img src="{{ asset('adminAssets/dist/img/selection/company.png') }}" alt="">
              <h6>Company</h6>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-sm-6 mt-5">
          <a href="{{ route('login.show','teacher') }}">
            <div class="box">
              <img src="{{ asset('adminAssets/dist/img/selection/teacher.png') }}" alt="">
              <h6>Teacher</h6>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-sm-6 mt-5">
          <a href="{{ route('login.show','trainer') }}">
            <div class="box">
              <img src="{{ asset('adminAssets/dist/img/selection/trainer.png') }}" alt="">
              <h6>Trainer</h6>
            </div>
          </a>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

  </body>
</html>
