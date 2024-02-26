<!DOCTYPE html>
<html lang="en">

@include('auth.partials.header')

<body>

    <div class="contianer">

        <div class="login-wrapper">
        @include('auth.partials.flash')

        @yield('content')

            
        </div>

        @include('auth.partials.footer')

    </div>



</body>

</html>