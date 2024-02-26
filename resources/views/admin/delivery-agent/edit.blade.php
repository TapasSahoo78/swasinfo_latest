@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customer.css') }}">
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.delivery.agent.edit', $user->uuid) }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="form_field">
                        <h2 class="text-xl text-slate-800 font-bold mb-6">General Info</h2>
                        <div class="grid gap-3 md:grid-cols-2 mb-3">

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="first_name">First Name <span
                                            class="text-rose-500">*</span></label>
                                    <input id="first_name" class="form-input w-full" type="text" name="first_name"
                                        placeholder="First Name" value="{{ $user->first_name  }}" />
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
                                        placeholder="Last Name" value="{{ $user->last_name }}" />
                                    @error('last_name')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- End -->
                            </div>



                        </div>
                        <div class="grid gap-3 md:grid-cols-2">

                             <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="email">Email <span
                                            class="text-rose-500">*</span></label>
                                    <input id="email" class="form-input w-full" type="email" name="email"
                                        value="{{ $user->email }}" autocomplete="off" readonly disabled/>
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
                                        value="{{ $user->mobile_number }}" />
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

                        <div class="grid gap-3 md:grid-cols-1">

                            <div>
                                <!-- Start -->
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="address">Address <span
                                            class="text-rose-500">*</span></label>
                                    <textarea class="form-control" rows="6" id="address" name="address">{{ $user->profile?->address }}</textarea>
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
                                    <label class="block text-sm font-medium mb-1" for="zip">Zip Code<span
                                            class="text-rose-500">*</span></label>
                                    <input id="zip" class="form-input w-full" type="number" name="zipcode"
                                        placeholder="Zip Code" value="{{ $user->profile?->zipcode }}" />
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
                                    <label for="admin_image" class="block text-sm font-medium mb-1">Profile Image<span
                                            class="text-rose-500">*</span></label>
                                    <input type="file" class="form-control" id="agent_image" name="agent_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif">
                                    @error('agent_image')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="">
                                    <label class="block text-sm font-medium mb-1">Current Image</label>
                                    <img class="ml-1" src="{{ $user->customer_picture }}" width="75"
                                        height="60" alt="Icon 01" />
                                </div>
                                <!-- End -->
                            </div>

                        </div>
                        <div class="grid gap-3 md:grid-cols-2">

                            <div>
                                <!-- Start -->
                                <div>
                                    <label for="category_id" class="block text-sm font-medium mb-1">Id Type <span
                                            class="text-rose-500">*</span></label>
                                    <select id="title" class="form-select" name="title">
                                        <option value="">Select Id Type</option>
                                        <option value="Driving Licence"  @if($user->document->first()->title=='Driving Licence') {{ 'selected' }} @endif  >Driving Licence</option>

                                    </select>
                                    {{-- @error('title')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
                                </div>
                                <!-- End -->
                            </div>

                            <div>
                                <!-- Start -->
                                <div>
                                    <label for="admin_image" class="block text-sm font-medium mb-1"> Upload Id<span
                                            class="text-rose-500">*</span></label>
                                    <input type="file" class="form-control" id="document_file" name="document_file"
                                        accept="image/jpeg,image/png,image/jpg,image/gif">
                                    {{-- @error('document_file')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
                                </div>

                                <div class="">
                                    <label class="block text-sm font-medium mb-1">Current Image</label>
                                    <img class="ml-1" src="{{ $user->driving_license }}" width="75"
                                        height="60" alt="Icon 01" />
                                </div>
                                <!-- End -->
                            </div>







                        </div>
                    </div>


                </div>
                <div class="space-y-8 mt-8">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <!-- Add Admin button -->
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">

                            <span class="hidden xs:block ml-2">Update</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection
@push('scripts')
@endpush
