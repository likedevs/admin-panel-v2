<!DOCTYPE html>
<html lang="{{$lang->lang}}">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="nofollow,noindex">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="_token" content="{{ csrf_token() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

  <title>SOLEDY.COM - {{ @$seoData['seo_title'] }}</title>

  <link rel="stylesheet" href="{{  asset('fronts/css/resets.css?'.uniqid('', true)) }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{  asset('fronts/css/style.css?'.uniqid('', true)) }}">
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

</head>

<body>
    <div class="julia-zoom">
        <div class="closeZoomImg"></div>
        <img class="zoomImg" src='' width='100%' />
        <div id="controlZoomImg">
        </div>
     </div>

  <div id="cover">
    <div class="container-fluid">
        @yield('content')
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="{{  asset('fronts/js/actions.js?'.uniqid('', true)) }}"></script>
  <script src="{{  asset('fronts/js/main.js?'.uniqid('', true)) }}"></script>
  <script src="{{asset('js/app.js')}}"></script>

</body>

</html>
