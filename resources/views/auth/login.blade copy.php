@extends('auth.partials.app')
@push('styles')

@endpush
@section('content')
    <!-- Content -->
    <div class="w-full md:w-1/2">
        <div class="min-h-screen h-full flex flex-col after:flex-1">
            <!-- Header -->
            <div class="flex-1">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Logo -->
                    <a class="block" href="{{ route('login') }}">
                        <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Canably" />
                    </a>
                </div>
            </div>

            <div class="max-w-sm mx-auto px-4 py-8">
                <h1 class="text-3xl text-slate-800 font-bold mb-6">Welcome back! ✨</h1>
                <!-- Form -->
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <input type="hidden" name="recaptcha" id="recaptcha">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="email">Email Address</label>
                            <input name="email" id="email" value="{{ old('email') }}" class="form-input w-full" type="email"
                                required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="password">Password</label>
                            <input id="password" name="password" class="form-input w-full" type="password"
                            autocomplete="on" required />
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <div class="mr-1">
                            <a class="text-sm underline hover:no-underline" href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        <input type="submit" disabled class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3" value="Login" />
                    </div>
                </form>
                <!-- Footer -->
                <div class="pt-5 mt-6 border-t border-slate-200">
                    &copy; Canably
                </div>
            </div>
        </div>
    </div>
    <!-- Image -->
    <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
        <img class="object-cover object-center w-full h-full" src="{{ asset('assets/admin/images/ADMIN-banner.jpg') }}" width="760" height="1024" alt="Authentication image" />
    </div>
@endsection
@push('scripts')
    <script  defer>
        $(document).ready(function() {
            setRecaptchaToken();
            // Every 90 Seconds
            setInterval(function() {
                setRecaptchaToken();
            }, 90 * 1000);
        });

        function setRecaptchaToken() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('captcha.sitekey') }}', {
                    action: 'login'
                }).then(function(token) {
                    // console.log(token);
                    if (token) {
                        document.getElementById('recaptcha').value = token;
                        $('input[type="submit"]').prop('disabled', false);
                    }
                });
            });
        }
    </script>
@endpush
