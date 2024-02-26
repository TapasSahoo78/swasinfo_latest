
@extends('mfi.auth.partials.app')

@push('styles')
@endpush

@section('content') 
<div class="login-form">
    <div class="login-header">
        <img src="{{asset('assets')}}" alt="logo">
        <h3>Let’s Get Started</h3>
    </div>
    <form action="{{ route('mfi.login',['slug' => $mfi_slug]) }}" method="post">
        @csrf
        <input type="hidden" name="mfi_slug" id="mfi_slug" value="{{ $mfi_slug }}" required>

        <input type="text" name="login_id" id="login_id" value="{{ old('login_id') }}" placeholder="Login Id" required>
        <div class="password-field">
            <input type="password" id="password-login" name="password" placeholder="Password" autocomplete="on" required>
            <span class="et-icon" id="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
        </div>
        <a href="#" class="forgt-password">Forget Password?</a>
        <input type="submit" value="SIGN IN">
    </form>
</div>
  
@endsection

@section('scripts')
