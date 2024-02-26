@extends('admin.layouts.app')

@push('style')
@endpush
@section('content')
<div>
    @include('admin.layouts.partials.page-title')
    <div class="border-t border-slate-200">
        <form method="post" action="{{ route('admin.seller.edit',$user->uuid) }}" id="sellerForm" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8 mt-8">
                <div class="grid gap-3 md:grid-cols-2">
                    <div class="card p-2">
                        <div class="grid gap-2 md:grid-cols-2">
                            <div class="mb-2">
                                <label class="block text-sm font-medium mb-1" for="organization_name">Organization Name <span class="text-rose-500">*</span></label>
                                <input id="organization_name" class="form-input w-full" type="text" name="organization_name" placeholder="Organization Name" value="{{ $user->profile->organization_name }}" />
                                @error('organization_name')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-medium mb-1" for="designation">Designation <span class="text-rose-500">*</span></label>
                                <input id="designation" class="form-input w-full" type="text" name="designation" placeholder="Designation" value="{{ $user->profile->designation }}" />
                                @error('designation')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-medium mb-1" for="first_name">First Name <span class="text-rose-500">*</span></label>
                                <input id="first_name" class="form-input w-full" type="text" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" />
                                @error('first_name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-medium mb-1" for="last_name">Last Name <span class="text-rose-500">*</span></label>
                                <input id="last_name" class="form-input w-full" type="text" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}" />
                                @error('last_name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-rose-500">*</span></label>
                                <input id="email" class="form-input w-full" type="email" name="email" value="{{ $user->email }}" readonly disabled/>
                                @error('email')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-medium mb-1" for="phone_no">Phone No</label>
                                <input id="phone_no" class="form-input w-full" type="number" name="mobile_number" value="{{ $user->mobile_number }}" />
                                @error('mobile_number')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-5 md:grid-cols-1">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="password">Address </label>
                                <textarea class="form-control" rows="6" id="address" name="address">
                                    {{ !empty($user->profile) ?  $user->profile->address :""}}
                                </textarea>
                                @error('address')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-3 md:grid-cols-2 mt-3">
                            <div>
                                <label for="admin_image" class="block text-sm font-medium mb-1">Profile Image</label>
                                <input type="file" class="form-control" id="seller_image" name="seller_image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                @error('seller_image')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class=" text-right">
                                <label class="block text-sm font-medium mb-1">Current Image</label>
                                <img class="ml-1" src="{{ $user->profile_picture }}" width="75" height="60" alt="Icon 01" />
                            </div>
                        </div>
                    </div>
                    <div class="card p-2" id="dynamic_field">
                        @if($user->document->isNotEmpty())
                            @foreach ($user->document as $value)
                            @php
                                $file=  $value->file ? asset('storage/images/documents/seller/'.$value->file) : asset('assets/images/dummy-user.png');
                            @endphp
                            <div class="grid gap-5 md:grid-cols-1">
                                <div class="grid gap-2 md:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="document">{{ $value->title }}</label>
                                        <img src="{{ $file }}" style="width:50px;height:50px;">
                                    </div>
                                    <div class="flex items-center text-center">
                                        <div class="m-1.5">
                                            <!-- Start -->
                                            <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 deleteDocument" data-table="documents" data-uuid="{{ $value->uuid }}" href="javascript:void(0)">
                                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                                    <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                                </svg>
                                                <span class="ml-2">Delete</span>
                                            </a>
                                            <!-- End -->
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @endif
                        <div class="grid gap-2 md:grid-cols-1 text-right mb-2">
                            <a href="javascript:void(0);" data-count="{{ $user->document->count() }}" class="btn btn-primary " id="add_button" title="Add field"><i class="fa fa-plus pr-3" aria-hidden="true"></i>  Add More Document</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white validateForm" type="submit">
                        <span class="hidden xs:block ml-2">Update</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection
@push('scripts')
<script src="{{asset('assets/admin/js/seller/seller.js')}}"></script>
@endpush

