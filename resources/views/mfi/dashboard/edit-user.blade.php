@extends('admin.layouts.app')
@push('style')

@endpush
@section('content')
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        @include('admin.layouts.partials.page-title')
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Delete button -->
            <div class="table-items-action">
                <div class="flex items-center">
                    <section>
                        <div class="mr-4">
                            <img class="w-20 h-20 rounded-full" src="{{ $userDetails->profile_picture }}" width="80" height="80" alt="{{ $userDetails->full_name }}" />
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-slate-200">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8 mt-8">
                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email</label>
                        <input type="email" id="email" class="form-input w-full"  name="email" value="{{$userDetails->email }}" readonly disabled/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="phone_no">Phone No</label>
                        <input id="phone_no" class="form-input w-full" type="number" name="mobile_number" value="{{ $userDetails->mobile_number }}" />
                        @error('phone_no')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="first_name">First Name <span class="text-rose-500">*</span></label>
                        <input id="first_name" class="form-input w-full" type="text" name="first_name" placeholder="First Name" value="{{ $userDetails->first_name }}" />
                        @error('first_name')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last Name <span class="text-rose-500">*</span></label>
                        <input id="last_name" class="form-input w-full" type="text" name="last_name" placeholder="Last Name" value="{{ $userDetails->last_name }}" />
                        @error('last_name')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium mb-1">Gender <span class="text-rose-500">*</span></label>
                        <select id="gender" class="form-select" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" @if($userDetails->profile?->gender == 'male') selected @endif>Male</option>
                            <option value="female" @if($userDetails->profile?->gender == 'female') selected @endif>Female</option>
                            <option value="other" @if($userDetails->profile?->gender == 'other') selected @endif>Others</option>
                        </select>
                    </div>
                    <div>
                        <label for="profile_image" class="block text-sm font-medium mb-1">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif">
                        @error('profile_image')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                 <div class="grid gap-5 md:grid-cols-1">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="password">Address </label>
                        <textarea class="form-control" rows="5" id="address" name="address">{{ auth()->user()->profile->address }}
                        </textarea>
                        @error('address')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="space-y-8 mt-8">
                <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                        <span class="hidden xs:block ml-2">Update</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
@push('scripts')

@endpush
