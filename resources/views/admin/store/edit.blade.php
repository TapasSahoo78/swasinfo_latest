@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.store.edit', $store->uuid) }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name" placeholder="Name"
                                value="{{ $store->name }}" />
                            @error('name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="last_name">Phone Number<span
                                    class="text-rose-500">*</span></label>
                            <input id="phone_number" class="form-input w-full" type="number" name="phone_number"
                                placeholder="Phone Number" value="{{ $store->phone_number }}" />
                            @error('phone_number')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label for="full_address" class="block text-sm font-medium mb-1">Address <span
                                    class="text-rose-500">*</span></label>
                            <textarea class="form-control" id="full_address" name="full_address" rows="3">
                            {{ $store->full_address }}
                        </textarea>
                            @error('full_address')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="zip">Zip Code<span
                                    class="text-rose-500">*</span></label>
                            <input id="zip_code" class="form-input w-full" type="text" name="zip_code"
                                placeholder="Zip Code" value="{{ $store->zip_code }}" />
                            @error('zip_code')
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
                            
                            <span class="hidden xs:block ml-2">Update</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/editor.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput.js') }}"></script>
    <script>
        var meta_keyword_values = "<?php echo !empty($seo['meta_keyword']) ? $seo['meta_keyword'] : ''; ?>";
        $('#meta_keyword').tagsinput({
            confirmKeys: [13, 32, 44]
        });
        $('#meta_keyword').tagsinput('add', meta_keyword_values);
    </script>
@endpush
