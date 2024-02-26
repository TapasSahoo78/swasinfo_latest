<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Swasthfit- {{ $pageTitle }}</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css')}}">

  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.0/jquery.toast.min.css"/>
  <!-- Theme style -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/theme.css')}}">
  @stack('styles')
    {{--  <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        var TOAST_POSITION = 'bottom-right';
    </script>  --}}
</head>

