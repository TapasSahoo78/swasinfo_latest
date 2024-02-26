@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customer.css') }}">
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title',['backbutton'=>true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.customer.save') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="form_field">
                        <h2 class="text-xl text-slate-800 font-bold mb-6">General Info</h2>
                        <div class="grid gap-3 md:grid-cols-2">

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="first_name">First Name <span
                                            class="text-rose-500">*</span></label>
                                    <input id="first_name" class="form-input w-full" type="text" name="first_name"
                                        placeholder="First Name" value="{{ old('first_name') }}" />
                                    @error('first_name')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="last_name">Last Name <span
                                            class="text-rose-500">*</span></label>
                                    <input id="last_name" class="form-input w-full" type="text" name="last_name"
                                        placeholder="Last Name" value="{{ old('last_name') }}" />
                                    @error('last_name')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>





                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="email">Email <span
                                            class="text-rose-500">*</span></label>
                                    <input id="email" class="form-input w-full" type="email" name="email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="phone_no">Phone No<span
                                            class="text-rose-500">*</span></label>
                                    <input id="phone_no" class="form-input w-full" type="number" name="mobile_number"
                                        value="{{ old('mobile_number') }}" />
                                    @error('mobile_number')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>



                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="form_field">
                        <h2 class="text-xl text-slate-800 font-bold mb-6">Additional Info</h2>
                        <div class="grid gap-3 md:grid-cols-3">
                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="country">Country </label>
                                    <input id="country" class="form-input w-full" type="text" name="country"
                                        placeholder="Country" value="{{ old('country') }}" />
                                    @error('country')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="last_name">State</label>
                                    <input id="state" class="form-input w-full" type="text" name="state"
                                        placeholder="State" value="{{ old('state') }}" />
                                    @error('state')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>





                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="city">City </label>
                                    <input id="city" class="form-input w-full" type="text" name="city"
                                        value="{{ old('city') }}" />
                                    @error('city')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>



                        </div><br>
                        <div class="grid gap-3 md:grid-cols-1">

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="address">Address </label>
                                    <textarea class="form-control" rows="6" id="address" name="address"></textarea>
                                    @error('address')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>


                        </div><br>
                        <div class="grid gap-3 md:grid-cols-2">

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="zip">Zip Code</label>
                                    <input id="zip" class="form-input w-full" type="number" name="zipcode"
                                        placeholder="Zip Code" value="{{ old('zipcode') }}" />
                                    @error('zipcode')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>

                            <div>
                                <!-- Start -->
                                <div>
                                    <label for="admin_image" class="block text-sm font-medium mb-1">Profile Image</label>
                                    <input type="file" class="form-control" id="customer_image" name="customer_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif">
                                    @error('customer_image')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>







                        </div>
                    </div>

                    {{-- <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="password">Password <span
                                    class="text-rose-500">*</span></label>
                            <input id="password" class="form-input w-full" type="text" name="password"
                                placeholder="Password" />
                            @error('password')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="password">Confirm Password <span
                                    class="text-rose-500">*</span></label>
                            <div class="input-group">
                                <input id="confirm_password" class="form-control form-input w-full" type="password"
                                    name="confirm_password" placeholder="Confirm Password" />
                                <button class="btn text-dark" type="button" id="button-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z" />
                                    </svg>
                                    <svg class="d-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                                        <path fill="#222"
                                            d="M44 45a2 2 0 0 0-.24-.26l-.7-.82-2.63-3-13.08-15a1.48 1.48 0 0 1-.24-.26l-2.78-3.18-2.63-3-1.35-1.58-.07-.09-.16-.18-8.2-9.41a2 2 0 1 0-3 2.62l6.68 7.66c-5.69 3.38-9.85 7.9-12.71 11-.34.37-.65.72-1 1l-.09.09-.09.11a1.09 1.09 0 0 0-.13.17 1.82 1.82 0 0 0-.16.31 2.78 2.78 0 0 0-.12.38 2 2 0 0 0 0 .8 2.78 2.78 0 0 0 .12.38 1.82 1.82 0 0 0 .16.31 1.09 1.09 0 0 0 .13.17l.09.11.09.09c.3.32.62.66 1 1C7.91 40 17.29 50.16 32 50.16a30.94 30.94 0 0 0 9.79-1.59l6.29 7.21a2 2 0 1 0 3-2.62Zm-12 3.27a16.25 16.25 0 0 1-13.07-25.93l2.71 3.11A12.25 12.25 0 0 0 32 44.27a12 12 0 0 0 5.07-1.12l1.83 2.1.89 1A16.27 16.27 0 0 1 32 48.27Zm13.58-7.43-.12.16a.6.6 0 0 0 .12-.16ZM40.65 29.1a2 2 0 0 0 .2-2.31 10.15 10.15 0 0 0-6.34-4.72 10.42 10.42 0 0 0-5.26 0l-1.43-1.64a11.94 11.94 0 0 1 4.18-.7 4 4 0 0 1 .49 0A12.26 12.26 0 0 1 44.27 32a11.51 11.51 0 0 1-.06 1.18 11.69 11.69 0 0 1-1.36 4.53L32.43 25.76a6.33 6.33 0 0 1 5 3.07 2 2 0 0 0 2.74.7 1.75 1.75 0 0 0 .48-.43ZM62.71 32a1.87 1.87 0 0 1 0 .4 2.78 2.78 0 0 1-.12.38 1.82 1.82 0 0 1-.16.31 1.09 1.09 0 0 1-.13.17l-.09.11-.09.09-.91 1a69.77 69.77 0 0 1-8.65 8.25A37.11 37.11 0 0 1 49.22 45l-2.67-3-.93-1.06A16 16 0 0 0 47.5 37a16.28 16.28 0 0 0-18.3-21 15.26 15.26 0 0 0-4.15 1.34l-1.84-2.12a25.3 25.3 0 0 1 4.41-1 29.9 29.9 0 0 1 4.38-.38c14.71 0 24.09 10.16 29.13 15.66.33.38.65.72.95 1a1.12 1.12 0 0 1 .18.2 1.09 1.09 0 0 1 .13.17v.05a2.1 2.1 0 0 1 .13.26 2.4 2.4 0 0 1 .12.38 1.81 1.81 0 0 1 .07.44Z"
                                            data-name="Hide" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                </div>
                <div class="space-y-8 mt-8">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <!-- Add Admin button -->
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z">
                                </path>
                            </svg>
                            <span class="hidden xs:block ml-2">Add</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection
@push('scripts')
@endpush
