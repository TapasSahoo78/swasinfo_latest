@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.catalog.brand.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-2 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Brand Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name"
                                placeholder="Brand Name" value="{{ old('name') }}" />
                            @error('name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="is_featured" class="block text-sm font-medium mb-1">Is Popular <span
                                    class="text-rose-500">*</span></label>
                            <select id="is_popular" class="form-select" name="is_popular">
                                <option value="">Select Popularity</option>
                                <option value="1">Yes</option>
                                <option value="0">No
                                </option>
                            </select>
                            @error('is_popular')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="brand_image" class="block text-sm font-medium mb-1">Brand Image</label>
                            <input type="file" class="form-control" id="brand_image" name="brand_image"
                                accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('brand_image')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium mb-2" for="last_name">Description </label>
                            <textarea class="form-input w-full" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
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
    <script src="{{ asset('assets/admin/js/editor.js') }}"></script>
@endpush
