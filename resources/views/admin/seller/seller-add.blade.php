@extends('admin.layouts.app')

@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title')
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.seller.save') }}" id="sellerForm" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-3 md:grid-cols-2">
                        <div class="card p-2">
                            <div class="grid gap-2 md:grid-cols-2">
                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1" for="organization_name">Organization Name <span class="text-rose-500">*</span></label>
                                    <input id="organization_name" class="form-input w-full" type="text" name="organization_name" placeholder="Organization Name" value="{{ old('organization_name') }}" />
                                    @error('organization_name')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1" for="designation">Designation <span class="text-rose-500">*</span></label>
                                    <input id="designation" class="form-input w-full" type="text" name="designation" placeholder="Designation" value="{{ old('designation') }}" />
                                    @error('designation')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
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
                                <div class="mb-2">
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
                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1" for="email">Email <span
                                            class="text-rose-500">*</span></label>
                                    <input id="email" class="form-input w-full" type="email" name="email"
                                        value="{{ old('email') }}" autocomplete="off" />
                                    @error('email')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1" for="phone_no">Phone No</label>
                                    <input id="phone_no" class="form-input w-full" type="number" name="mobile_number"
                                        value="{{ old('mobile_number') }}" />
                                    @error('mobile_number')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1" for="new_password">Password <span
                                            class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input id="new_password" class="form-input w-full passwordField" type="password" name="password" autocomplete="off">
                                        <button class="absolute inset-0 left-auto group passwordHideShow" type="button"
                                            aria-label="Search">
                                            <svg class="passwordHidden w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2 mt-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">

                                                <g id="show-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">

                                                    <g id="show-password" fill="black" fill-rule="nonzero">

                                                        <path
                                                            d="M9.952,0 C5.55581964,0.00248628109 1.60850854,2.69365447 0,6.785 C1.60695767,10.8762575 5.5544681,13.5668547 9.95,13.5668547 C14.3455319,13.5668547 18.2930423,10.8762575 19.9,6.785 C18.2920266,2.69501195 14.34672,0.00412882876 9.952,0 Z M9.952,11.309 C7.45401608,11.309 5.429,9.28398392 5.429,6.786 C5.429,4.28801608 7.45401608,2.263 9.952,2.263 C12.4499839,2.263 14.475,4.28801608 14.475,6.786 C14.4738964,9.28352664 12.4495266,11.3078964 9.952,11.309 L9.952,11.309 Z M9.952,4.07099704 C8.45309919,4.07099704 7.238,5.28609919 7.238,6.785 C7.238,8.28390081 8.45309919,9.499 9.952,9.499 C11.4509008,9.499 12.666003,8.28390081 12.666003,6.785 C12.6670637,6.06487688 12.3814668,5.37394216 11.8722623,4.86473767 C11.3630578,4.35553317 10.6721231,4.0699363 9.952,4.07099704 L9.952,4.07099704 Z"
                                                            id="Icon_material-remove-red-eye"></path>

                                                    </g>

                                                </g>

                                            </svg>
                                            <svg class="passwordShowed d-none w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2 mt-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">

                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">

                                                    <g id="hide-password" fill="black" fill-rule="nonzero">

                                                        <path
                                                            d="M8.866,3.2 C11.08314,3.19280434 12.8870792,4.98287049 12.897,7.2 C12.8971449,7.70218532 12.7989648,8.19954059 12.608,8.664 L14.962,10.998 C16.1886907,9.98413194 17.1397143,8.67711934 17.727,7.198 C15.8188493,2.43238406 10.4837828,0.0287989846 5.65,1.757 L7.39,3.485 C7.85947076,3.29724472 8.36037705,3.20052501 8.866,3.2 Z M0.807,1.017 L2.65,2.841 L3.022,3.209 C1.6728609,4.24213925 0.628587991,5.62125678 0,7.2 C1.96162887,12.0841703 7.50193433,14.4643338 12.395,12.525 L12.735,12.861 L15.097,15.195 L16.122,14.178 L1.828,0 L0.807,1.017 Z M5.262,5.436 L6.512,6.674 C6.4711228,6.84366455 6.44998266,7.01748341 6.449,7.192 C6.44898396,7.83147599 6.70417265,8.44451588 7.15794345,8.89509507 C7.61171425,9.34567427 8.22654005,9.59652962 8.866,9.592 C9.04185064,9.59125421 9.21702126,9.57011292 9.388,9.529 L10.638,10.767 C9.39692134,11.3861097 7.92403616,11.3199507 6.74346168,10.5920655 C5.5628872,9.86418028 4.84225588,8.57792282 4.838,7.191 C4.84201959,6.5811201 4.98713971,5.98044602 5.262,5.436 Z M8.736,4.815 L11.276,7.335 L11.292,7.208 C11.292,6.56852401 11.0368273,5.95548412 10.5830565,5.50490493 C10.1292858,5.05432573 9.51445995,4.80347038 8.875,4.808 L8.736,4.815 Z"
                                                            id="Icon_ionic-md-eye-off"></path>

                                                    </g>

                                                </g>

                                            </svg>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-medium mb-1" for="confirm_password">Confirm Password
                                        <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input id="confirm_password" class="form-input w-full passwordField" type="password"
                                            name="confirm_password">
                                        <button class="absolute inset-0 left-auto group passwordHideShow" type="button">
                                            <svg class="passwordHidden w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2 mt-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">

                                                <g id="show-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">

                                                    <g id="show-password" fill="black" fill-rule="nonzero">

                                                        <path
                                                            d="M9.952,0 C5.55581964,0.00248628109 1.60850854,2.69365447 0,6.785 C1.60695767,10.8762575 5.5544681,13.5668547 9.95,13.5668547 C14.3455319,13.5668547 18.2930423,10.8762575 19.9,6.785 C18.2920266,2.69501195 14.34672,0.00412882876 9.952,0 Z M9.952,11.309 C7.45401608,11.309 5.429,9.28398392 5.429,6.786 C5.429,4.28801608 7.45401608,2.263 9.952,2.263 C12.4499839,2.263 14.475,4.28801608 14.475,6.786 C14.4738964,9.28352664 12.4495266,11.3078964 9.952,11.309 L9.952,11.309 Z M9.952,4.07099704 C8.45309919,4.07099704 7.238,5.28609919 7.238,6.785 C7.238,8.28390081 8.45309919,9.499 9.952,9.499 C11.4509008,9.499 12.666003,8.28390081 12.666003,6.785 C12.6670637,6.06487688 12.3814668,5.37394216 11.8722623,4.86473767 C11.3630578,4.35553317 10.6721231,4.0699363 9.952,4.07099704 L9.952,4.07099704 Z"
                                                            id="Icon_material-remove-red-eye"></path>

                                                    </g>

                                                </g>

                                            </svg>
                                            <svg class="passwordShowed d-none w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2 mt-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">

                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">

                                                    <g id="hide-password" fill="black" fill-rule="nonzero">

                                                        <path
                                                            d="M8.866,3.2 C11.08314,3.19280434 12.8870792,4.98287049 12.897,7.2 C12.8971449,7.70218532 12.7989648,8.19954059 12.608,8.664 L14.962,10.998 C16.1886907,9.98413194 17.1397143,8.67711934 17.727,7.198 C15.8188493,2.43238406 10.4837828,0.0287989846 5.65,1.757 L7.39,3.485 C7.85947076,3.29724472 8.36037705,3.20052501 8.866,3.2 Z M0.807,1.017 L2.65,2.841 L3.022,3.209 C1.6728609,4.24213925 0.628587991,5.62125678 0,7.2 C1.96162887,12.0841703 7.50193433,14.4643338 12.395,12.525 L12.735,12.861 L15.097,15.195 L16.122,14.178 L1.828,0 L0.807,1.017 Z M5.262,5.436 L6.512,6.674 C6.4711228,6.84366455 6.44998266,7.01748341 6.449,7.192 C6.44898396,7.83147599 6.70417265,8.44451588 7.15794345,8.89509507 C7.61171425,9.34567427 8.22654005,9.59652962 8.866,9.592 C9.04185064,9.59125421 9.21702126,9.57011292 9.388,9.529 L10.638,10.767 C9.39692134,11.3861097 7.92403616,11.3199507 6.74346168,10.5920655 C5.5628872,9.86418028 4.84225588,8.57792282 4.838,7.191 C4.84201959,6.5811201 4.98713971,5.98044602 5.262,5.436 Z M8.736,4.815 L11.276,7.335 L11.292,7.208 C11.292,6.56852401 11.0368273,5.95548412 10.5830565,5.50490493 C10.1292858,5.05432573 9.51445995,4.80347038 8.875,4.808 L8.736,4.815 Z"
                                                            id="Icon_ionic-md-eye-off"></path>

                                                    </g>

                                                </g>

                                            </svg>
                                        </button>
                                    </div>
                                    @error('confirm_password')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid gap-5 md:grid-cols-1">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="password">Address </label>
                                    <textarea class="form-control" rows="6" id="address" name="address"></textarea>
                                    @error('address')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid gap-2 md:grid-cols-1">
                                <div>
                                    <label for="admin_image" class="block text-sm font-medium mb-1">Profile Image</label>
                                    <input type="file" class="form-control" id="seller_image" name="seller_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif">
                                    @error('seller_image')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card p-2" id="dynamic_field">
                            <div class="grid gap-2 md:grid-cols-1 text-right mb-2">
                                <a href="javascript:void(0);" data-count="1" class="btn btn-primary " id="add_button"
                                    title="Add field"><i class="fa fa-plus pr-3" aria-hidden="true"></i> Add More
                                    Document</a>
                            </div>
                            <div class="grid gap-2 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="document">Document Title</label>
                                    <input id="title" class="form-control form-input w-full validate_error"
                                        type="text" name="document[0][title]" placeholder="Title" />
                                    @error('title')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="password">Document Image </label>
                                    <input type="file" class="form-control validate_error" id="document_file"
                                        name="document[0][file]" accept="image/jpeg,image/png,image/jpg,image/gif">
                                    @error('document_file')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <!-- Add Admin button -->
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white validateForm" type="submit">
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
    <script src="{{ asset('assets/admin/js/seller/seller.js') }}"></script>
@endpush
