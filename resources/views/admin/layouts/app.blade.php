<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.layouts.partials.header')

<body class="hold-transition sidebar-mini">
    @include('admin.layouts.partials.flash')
    <div class="wrapper">

        @include('admin.layouts.partials.navbar')


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.home') }}" class="brand-link">
                <img src="{{asset('assets/img/admin-logo.png')}}" alt="" class="brand-image">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
             @include('admin.layouts.partials.sidebar')

            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')



    </div>


    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->

    @include('admin.layouts.partials._footer')
    @include('admin.layouts.partials.footer')


    @stack('scripts')



</body>

</html>
