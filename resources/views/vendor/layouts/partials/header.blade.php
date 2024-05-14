<!-- Favicon -->
<link href="{{ asset('assets_f/img/favicon.ico') }}" rel="icon">
<!-- Google Web Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Libraries Stylesheet -->
<link href="{{ asset('assets_f/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets_f/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('assets_f/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- Template Stylesheet -->
<link href="{{ asset('assets_f/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/jquery-confirm.css') }}">
@stack('styles')
<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'bottom-right';
</script>
