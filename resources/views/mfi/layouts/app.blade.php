<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('mfi.layouts.partials.header')
@stack('css')
@stack('style')
@php
 $code = Auth::user()->mfi->code;
@endphp
<body class="hold-transition sidebar-mini">
    @include('mfi.layouts.partials.flash')
    <div class="wrapper">

        @include('mfi.layouts.partials.navbar')


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            
            <a href="{{route('mfi.home',['slug'=>$code])}}" class="brand-link">
                <img src="{{ auth()->user()->mfi->logo_picture }}" alt="" class="brand-image">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
             @include('mfi.layouts.partials.sidebar')
               
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')



    </div>


    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    
    @include('mfi.layouts.partials._footer')
    @include('mfi.layouts.partials.footer')


    @stack('scripts')
   


</body>

</html>