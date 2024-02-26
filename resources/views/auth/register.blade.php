<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Canably - Admin Registration</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet"/>
    <link href="{{ asset('assets/admin/css/vendors/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .validationBox{
        margin-top: 10px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
</style>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
    <!-- <h1>{{ config('app.name') }}</h1> -->
        <h1>CANABLY</h1>
    </div>
    <div class="login-box">
        <form class="login-form register-form" action="{{ route('register') }}" method="POST" role="form">
            @csrf
            <h3 class="login-head">SIGN UP</h3>
          
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="email">E-Mail Address</label>
                <input id="email" type="hidden" class="form-control disabled" name="email" >
                <span class="separator"> </span>
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="first_name">Name</label>
                <input type="text" class="o-form-element o-custom-input form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                <span class="separator"> </span>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="first_name">User Name</label>
                <input type="text" class="o-form-element o-custom-input form-control @error('username') is-invalid @enderror" name="username" id="user_name" value="{{ old('username') }}">
                <span class="separator"> </span>
                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="password">Password</label>
                <input type="password" class="o-form-element o-custom-input form-control @error('password') is-invalid @enderror" name="password" id="password">
                <span class="separator"> </span>
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="password_confirmation">Confirm Password</label>
                <input type="password" class="o-form-element o-custom-input form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                <span class="separator"> </span>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block c-solid-btn"> Sign Up </button>
            </div>
            <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>
        </form>
    </div>

    <div class="validationBox">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
</section>
<script src="{{ asset('assets/admin/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/pace.min.js') }}"></script>
</body>
</html>
