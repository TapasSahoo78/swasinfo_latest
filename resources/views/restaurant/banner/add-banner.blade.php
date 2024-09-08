@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
@include('admin.layouts.partials.page-title', ['backbutton' => true])
{{-- @include('errors.all') --}}
<div class="border-t border-slate-200">
    <form method="post" action="{{ route('admin.banner.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="space-y-8 mt-8">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium mb-1" for="name">Name <span class="text-rose-500">*</span></label>
                    <input id="name" class="form-input w-full" type="text" name="name" value="{{ old('name') }}" />
                    @error('name')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label for="order" class="block text-sm font-medium mb-1">Select Order <span class="text-rose-500">*</span></label>
                    <select id="order" class="form-select" name="order">
                        <option value="" >Select Order</option>
                        @for ($i=1; $i<=10 ; $i++)
                            <option value="{{ $i }}">
                            {{ $i }}</option>
                        @endfor
                    </select>
                    @error('order')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="grid gap-5 md:grid-cols-1">
                <div>
                    <label for="description" class="block text-sm font-medium mb-1">Description <span class="text-rose-500">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="banner_image" class="block text-sm font-medium mb-1">Banner Image <span class="text-rose-500">*</span></label>
                    <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('banner_image')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="alt_text">Alt Tag </label>
                    <input id="alt_text" class="form-input w-full" type="text" name="alt_text" value="{{ old('alt_text') }}" />
                    @error('alt_text')
                    <div class="text-xs mt-1 text-rose-500">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="space-y-8 mt-8">
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Add Admin button -->
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"></path>
                    </svg>
                    <span class="hidden xs:block ml-2">Add</span>
                </button>
            </div>
        </div>

    </form>
</div>
@endsection


@push('scripts')
    <script  src="{{asset('assets/plugins/bootstrap-tagsinput.js')}}"></script>
    <script >
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword'])?$seo['meta_keyword']:''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add',meta_keyword_values);
    </script>
@endpush
