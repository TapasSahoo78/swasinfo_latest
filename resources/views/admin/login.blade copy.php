<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Canably - Admin Login</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="{{ asset('assets/admin/css/vendors/flatpickr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
    </head>
    <body class="font-inter antialiased bg-slate-100 text-slate-600 sidebar-expanded">
        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>
        <main class="bg-white">
            <div class="relative flex">
                <!-- Content -->
                <div class="w-full md:w-1/2">
                    <div class="min-h-screen h-full flex flex-col after:flex-1">
                        <!-- Header -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                                <!-- Logo -->
                                <a class="block" href="index.html">
                                    <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Canably" />
                                </a>
                            </div>
                        </div>
                        <div class="max-w-sm mx-auto px-4 py-8">
                            @include('admin.partials.error')
                            <h1 class="text-3xl text-slate-800 font-bold mb-6">Welcome back! </h1>
                            <!-- Form -->
                            <form action="{{ url('/admin') }}" method="post">@csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="email">Email Address</label>
                                        <input name="email" id="email" class="form-input w-full" type="email"
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
                                        <a class="text-sm underline hover:no-underline" href="reset-password.html">Forgot
                                            Password?</a>
                                    </div>
                                    <input type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3"
                                        value="Sign In" />
                                    <a href="#" id="login_submit"></a>
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
                    <img class="object-cover object-center w-full h-full"
                        src="{{ asset('assets/admin/images/ADMIN-banner.jpg') }}" width="760" height="1024"
                        alt="Authentication image" />
                </div>
            </div>
        </main>
        <script src="{{ asset('assets/admin/js/vendors/alpinejs.min.js') }}" defer></script>
    </body>
</html>
