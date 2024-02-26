@extends('auth.partials.app')

@push('styles')
@endpush

@section('content')
<div class="login-form">
    <div class="login-header">
        <img src="{{ asset('assets/img/admin-logo.png')}}" alt="logo">
        <h3>Let’s {{__('Get Started')}}</h3>
    </div>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{__('Email address')}}" required>
        <div class="password-field">
            <input type="password" id="password-login" name="password" placeholder="{{__('Password')}}" autocomplete="on" required>
            <span class="et-icon" id="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
        </div>

        <a href="{{url('password/reset')}}" class="forgt-password">{{__('Forget Password')}}?</a>

        <input type="submit" value="SIGN IN">
    </form>
</div>

@endsection

@section('scripts')
