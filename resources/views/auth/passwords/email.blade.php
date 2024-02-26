@extends('auth.partials.app')

@push('styles')
@endpush

@section('content')
    <div class="login-form">
        <div class="login-header">
            <img src="{{ asset('assets/img/admin-logo.png') }}" alt="logo">
            <h3>Let’s Get Started</h3>
        </div>
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <input type="text" name="email" id="email" value="{{ old('email') }}"
                placeholder="Email address or mobile number" required>

            <a href="{{ route('login') }}" class="forgt-password">Nevermind, take me back.</a>
            <input type="submit" value="RESET PASSWORD">
        </form>
    </div>

@endsection

@section('scripts')
