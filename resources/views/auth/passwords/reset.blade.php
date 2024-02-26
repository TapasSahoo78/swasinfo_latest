@extends('auth.partials.app')
@section('content')
    <!-- Content -->
    <div class="w-full md:w-1/2">
        <div class="min-h-screen h-full flex flex-col after:flex-1">
            <!-- Header -->
            <div class="flex-1">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 ">
                    <!-- Logo -->
                    <a class="block " href="{{ route('login') }}">
                        <img src="{{ asset('assets/img/admin-logo.png') }}" width="90" class="ml-5" alt="Canably" />
                    </a>
                </div>
            </div>

            <div class="max-w-sm mx-auto px-4 py-8">
                <h1 class="text-3xl text-slate-800 font-bold mb-6">Change Password</h1>
                <!-- Form -->
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="recaptcha" id="recaptcha">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="email">Email Address</label>
                            <input type="email" class="form-input w-full form-control" name="email" id="email"
                                value="{{ $email ?? old('email') }}" @error('email') is-invalid @enderror" readonly
                                autocomplete="new-password" autofocus required />
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="password">New Password</label>
                            <input type="password" class="form-input w-full form-control" name="password" id="password"
                                @error('password') is-invalid @enderror" autocomplete="password" autofocus required />
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="email">Confirm Password</label>
                            <input type="password" class="form-input w-full form-control" name="password_confirmation"
                                required @error('password_confirmation') is-invalid @enderror" autofocus />
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="m-2 d-flex justify-content-center">
                            <a class="text-sm underline hover:no-underline" href="{{ route('login') }}">Nevermind, take me
                                back.</a>
                        </div>
                        <div class="m-2 d-flex justify-content-center">
                            <input type="submit" class="btn btn-primary btn-md bg-indigo-500 hover:bg-indigo-600  ml-3"
                                value="Change Password" />
                        </div>
                    </div>
                </form>
                <!-- Footer -->
                {{-- <div class="pt-5 mt-6 border-t border-slate-200">
                    &copy; Canably
                </div> --}}
            </div>

        </div>
    </div>
    <!-- Image -->
    {{-- <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
        <img class="object-cover object-center w-full h-full" src="{{ asset('assets/admin/images/ADMIN-banner.jpg') }}"
            width="760" height="1024" alt="Authentication image" />
    </div> --}}
@endsection
@push('scripts')
    <script defer>
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
                    action: 'resetpassword'
                }).then(function(token) {
                    if (token) {
                        document.getElementById('recaptcha').value = token;
                        $('input[type="submit"]').prop('disabled', false);
                    }
                });
            });
        }
    </script>
@endpush
