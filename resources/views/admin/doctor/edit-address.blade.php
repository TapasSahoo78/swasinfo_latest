
@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customer.css') }}">
@endpush
@section('content')
@php
    $partitionedAddress= $address->full_address;
@endphp
@include('admin.layouts.partials.page-title',['backbutton'=>true])
<div>
    <div class="border-t border-slate-200">
        <form method="post" action="{{ route('admin.customer.update.address',$address->uuid) }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8 mt-8">
                <div class="form_field">
                    <h2 class="text-xl text-slate-800 font-bold mb-6">Address Details</h2>
                    <div class="grid gap-2 md:grid-cols-2">
                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="country">Name </label>
                                <input id="country" class="form-input w-full" type="text" name="name"
                                    placeholder="Country" value="{{ $address->name ?? '' }}" />
                                @error('name')
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
                                <label class="block text-sm font-medium mb-1" for="last_name">Phone Number</label>
                                <input id="state" class="form-input w-full" type="number" name="phone_number"
                                    placeholder="Phone Number" value="{{ $address->phone_number ?? '' }}" />
                                @error('phone_number')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- End -->
                        </div>
                    </div>
                    <div class="grid gap-3 md:grid-cols-1">
                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="address">Address line one </label>
                                <textarea class="form-control" rows="3" id="address" name="full_address[address_line_one]">
                                    {{ $partitionedAddress['address_line_one'] ?? '' }}
                                </textarea>
                                @error('full_address.address_line_one')
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
                                <label class="block text-sm font-medium mb-1" for="address">Address line two </label>
                                <textarea class="form-control" rows="3" id="address" name="full_address[address_line_two]">
                                    {{ $partitionedAddress['address_line_two'] ?? '' }}
                                </textarea>
                                @error('full_address.address_line_two')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- End -->
                        </div>
                    </div>
                    <div class="grid gap-3 md:grid-cols-3">

                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="country">Country </label>
                                <input id="country" class="form-input w-full" type="text" name="full_address[country]"
                                    placeholder="Country" value="{{ $partitionedAddress['country'] ?? '' }}" />
                                @error('full_address.country')
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
                                <input id="state" class="form-input w-full" type="text" name="full_address[state]"
                                    placeholder="State" value="{{ $partitionedAddress['state'] ?? '' }}" />
                                @error('full_address.state')
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
                                <input id="city" class="form-input w-full" type="text" name="full_address[city]"
                                    value="{{ $partitionedAddress['city'] ?? '' }}" />
                                @error('full_address.city')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                    <div class="grid gap-3 md:grid-cols-3">
                        <div>
                            <!-- Start -->
                            <div>
                                <label class="block text-sm font-medium mb-1" for="zip">Zip Code</label>
                                <input id="zip" class="form-input w-full" type="text" name="zip_code"
                                    placeholder="Zip Code" value="{{ $address->zip_code }}" />
                                @error('zip_code')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- End -->
                        </div>
                        <div>
                            <label for="coupon_type" class="block text-sm font-medium mb-1">Type </label>
                            <select id="coupon_type" class="form-select" name="type">
                                <option value="">Select Type</option>
                                <option value="home" @if ($address->type=='home') selected @endif>Home</option>
                                <option value="office" @if ($address->type=='office') selected @endif>Office</option>
                                <option value="other" @if ($address->type=='other') selected @endif>Other</option>
                            </select>
                            @error('coupon_type')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="coupon_type" class="block text-sm font-medium mb-1">Default Address </label>
                            <select id="coupon_type" class="form-select" name="is_default">
                                <option value="">Select</option>
                                <option value="1" @if ($address->is_default==1) selected @endif>Yes</option>
                                <option value="0" @if ($address->is_default==0) selected @endif>No</option>
                            </select>
                            @error('coupon_type')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <!-- Add Admin button -->
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                        <span class="hidden xs:block">Update Address</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection
@push('scripts')
@endpush
