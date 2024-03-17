@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.catalog.brand.edit', $brandData->uuid) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-3 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Brand Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name"
                                placeholder="Product Name" value="{{ $brandData->name }}" />
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
                                <option value="1" @if ($brandData->is_popular == 1) selected @endif>Yes</option>
                                <option value="0" @if ($brandData->is_popular == 0) selected @endif>No
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
                </div>
                <div class="grid gap-5 md:grid-cols-1">
                    <div>
                        <label class="block text-sm font-medium mb-2" for="last_name">Description </label>
                        <textarea class="form-input w-full" id="description" name="description" rows="3">{{ $brandData->description }}</textarea>
                        @error('description')
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

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/editor.js') }}"></script>
@endpush
