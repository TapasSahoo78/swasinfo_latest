<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SwasthFit</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('vendor.layouts.partials.header')

</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        @include('vendor.layouts.partials.spinner')
        <!-- Spinner End -->
        <!-- Sidebar Start -->
        @include('vendor.layouts.partials.sidebar')
        <!-- Sidebar End -->
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('vendor.layouts.partials.navbar')
            <!-- Navbar End -->

            @yield('content')

        </div>
        <!-- Content End -->
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('vendor.layouts.partials.footer')

</body>

</html>
