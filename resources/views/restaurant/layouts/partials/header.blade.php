<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Swasthfit- {{ $pageTitle ?? '' }}</title>
    <!-- Font Awesome Icons -->
    <link rel="canonical" href="https://swasthfit.in/admin/public/assets/img/admin-logo.png" />
    <link rel="shortcut icon" href="https://swasthfit.in/admin/public/assets/img/admin-logo.png" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">



    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link href="//cdn.jsdelivr.net/npm/sweetalert2@11.6.14/dist/sweetalert2.min.css" />


    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.0/jquery.toast.min.css" rel="stylesheet" />

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

    <!-- Responsive Css  -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/responsive.css') }}">
    @stack('styles')
    <script>
        var APP_URL = {!! json_encode(url('/')) !!};
        var TOAST_POSITION = 'bottom-right';
    </script>
</head>
