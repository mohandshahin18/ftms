<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ config('app.name') }} |  @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    <style>
        @import url("https://fonts.googleapis.com/css?family=Fira+Sans");
    /*Variables*/
    .left-section .inner-content {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      padding: 0;
    }

    body {
      font-family: "Fira Sans", sans-serif;
      color: #f5f6fa;
    }

    .background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(#0C0E10, #446182);
    }
    .background .ground {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 25vh;
      background: #0C0E10;
    }
    @media (max-width: 770px) {
      .background .ground {
        height: 0vh;
      }
    }

    .container {
      position: relative;
      margin: 0 auto;
      width: 85%;
      height: 100vh;
      padding-bottom: 25vh;
      display: flex;
      flex-direction: row;
      justify-content: space-around;
    }
    @media (max-width: 770px) {
      .container {
        flex-direction: column;
        padding-bottom: 0vh;
      }
    }

    .left-section, .right-section {
      position: relative;
    }

    .left-section {
      width: 40%;
    }
    @media (max-width: 770px) {
      .left-section {
        width: 100%;
        height: 40%;
        position: absolute;
        top: 0;
      }
    }
    @media (max-width: 770px) {
      .left-section .inner-content {
        position: relative;
        padding: 1rem 0;
      }
    }

    .heading {
      text-align: center;
      font-size: 9em;
      line-height: 1.3em;
      margin: 2rem 0 0.5rem 0;
      padding: 0;
      text-shadow: 0 0 1rem #fefefe;
    }
    @media (max-width: 770px) {
      .heading {
        font-size: 7em;
        line-height: 1.15;
        margin: 0;
      }
    }

    .subheading {
      text-align: center;
      max-width: 480px;
      font-size: 1.5em;
      line-height: 1.15em;
      padding: 0 1rem;
      margin: 0 auto;
    }
    @media (max-width: 770px) {
      .subheading {
        font-size: 1.3em;
        line-height: 1.15;
        max-width: 100%;
      }
    }

    .right-section {
      width: 50%;
    }
    @media (max-width: 770px) {
      .right-section {
        width: 100%;
        height: 60%;
        position: absolute;
        bottom: 0;
      }
    }

    .svgimg {
      position: absolute;
      bottom: 0;
      padding-top: 10vh;
      padding-left: 1vh;
      max-width: 100%;
      max-height: 100%;
    }
    @media (max-width: 770px) {
      .svgimg {
        padding: 0;
      }
    }
    .svgimg .bench-legs {
      fill: #0C0E10;
    }
    .svgimg .top-bench, .svgimg .bottom-bench {
      stroke: #0C0E10;
      stroke-width: 1px;
      fill: #5B3E2B;
    }
    .svgimg .bottom-bench path:nth-child(1) {
      fill: #432d20;
    }
    .svgimg .lamp-details {
      fill: #202425;
    }
    .svgimg .lamp-accent {
      fill: #2c3133;
    }
    .svgimg .lamp-bottom {
      fill: linear-gradient(#202425, #0C0E10);
    }
    .svgimg .lamp-light {
      fill: #EFEFEF;
    }

    @keyframes glow {
      0% {
        text-shadow: 0 0 1rem #fefefe;
      }
      50% {
        text-shadow: 0 0 1.85rem #ededed;
      }
      100% {
        text-shadow: 0 0 1rem #fefefe;
      }
    }
    </style>

</head>
<body>
@yield('content')
</body>
</html>
