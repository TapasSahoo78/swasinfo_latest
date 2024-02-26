@extends('admin.layouts.app')

@push('style')
@endpush

@section('content')
@php
    $categoryCollection= collect($coupons->categories->pluck('id'));
@endphp
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.coupon.edit', $coupons->uuid) }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-2 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="title">Title <span
                                    class="text-rose-500">*</span></label>
                            <input id="title" class="form-input w-full" type="text" name="title" value="{{ $coupons->title }}" />
                            @error('title')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="code">Code <span
                                    class="text-rose-500">*</span></label>
                            <input id="code" class="form-input w-full" type="text" name="code"
                                value="{{ $coupons->code }}" />
                            @error('code')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="coupon_type" class="block text-sm font-medium mb-1">Type <span
                                    class="text-rose-500">*</span></label>
                            <select id="coupon_type" class="form-select" name="coupon_type">
                                <option value="">Select Type</option>
                                <option value="flat" @if($coupons->coupon_type=='flat') {{ 'selected' }} @endif>flat</option>
                                <option value="%" @if($coupons->coupon_type=='%') {{ 'selected' }} @endif>%</option>
                            </select>
                            @error('coupon_type')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-medium mb-1">Discount<span
                                    class="text-rose-500">*</span></label>
                            <input id="coupon_discount" class="form-input w-full" type="number" name="coupon_discount"
                                value="{{  $coupons->coupon_discount  }}" oninput="validate(this)" />
                            @error('coupon_discount')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-2 md:grid-cols-2">

                        <div>
                            <label for="usage_per_user" class="block text-sm font-medium mb-1">Usage Per User <span
                                    class="text-rose-500">*</span></label>
                            <input id="usage_per_user" class="form-input w-full" type="number" name="usage_per_user"
                                value="{{  $coupons->usage_per_user  }}" />
                            @error('usage_per_user')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div>
                            <label for="coupon_type" class="block text-sm font-medium mb-1">Usage Of Coupon <span
                                    class="text-rose-500">*</span></label>
                            <input id="usage_of_coupon" class="form-input w-full" type="number" name="usage_of_coupon"
                                value="{{  $coupons->usage_of_coupon  }}" />
                            @error('usage_of_coupon')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-2 md:grid-cols-2">

                        <div>
                            <label for="started_at" class="block text-sm font-medium mb-1">Start Date<span
                                    class="text-rose-500">*</span></label>
                            <input id="started_at" class="form-input w-full" type="date" name="started_at"
                                value="{{  $coupons->started_at  }}" />
                            @error('started_at')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div>
                            <label for="ended_at" class="block text-sm font-medium mb-1">End Date<span
                                    class="text-rose-500">*</span></label>
                            <input id="ended_at" class="form-input w-full" type="date" name="ended_at"
                                value="{{ $coupons->ended_at }}" />
                            @error('ended_at')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                </div>
                <div class="space-y-8 mt-8">
                    <label class="block text-sm font-medium mb-1" for="name">Select Category </label>
                    <div class="grid grid-cols-12 gap-6">
                        <!-- Users cards -->
                        @forelse ($listCategories as $chunk )
                            <!-- Card 1 -->
                            <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white shadow-lg rounded-sm border border-slate-200">
                                <div class="flex flex-col h-full">
                                    <!-- Card top -->
                                    <div class="grow p-3">
                                        @forelse ($chunk as $category )
                                        <div class="text-justify mt-2">
                                            <div class="text-sm">
                                                <label class="flex items-center">
                                                    <input type="checkbox" class="form-checkbox" name="category[]" value="{{ $category->id }}" @if($categoryCollection->contains($category->id))
                                                    checked @endif />
                                                    <span class="text-sm ml-2">
                                                        {{ $category->parent ? $category->parent->name . '->' : ' ' }}
                                                    </span>
                                                    <span class="text-sm ml-2">{{ $category->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        @empty

                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                    @error('category')
                        <div class="text-xs mt-1 text-rose-500">
                            {{ $message }}
                        </div>
                    @enderror
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
        {{-- @include('errors.all') --}}
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/coupon.js') }}"></script>
@endpush
