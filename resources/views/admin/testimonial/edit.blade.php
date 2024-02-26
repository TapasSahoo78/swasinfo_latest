@extends('admin.layouts.app')
@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title', ['backbutton' => true])
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.testimonial.edit', $testimonial->uuid) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="order" class="block text-sm font-medium mb-1">Select User <span
                                    class="text-rose-500">*</span></label>
                            <select id="user" class="form-select" name="user_id">
                                <option value="0">Select User
                                </option>
                                @forelse ($listUsers as $listUser)
                                    <option value="{{ $listUser->uuid }}" data-id="{{ $listUser->uuid }}"
                                        @if ($testimonial->user_id == $listUser->id) selected @endif>
                                        {{ !empty($listUser->full_name) ? $listUser->full_name : $listUser->email }}
                                    </option>
                                @empty
                                    <option value="" data-id="">{{ 'No User Available' }}
                                    </option>
                                @endforelse
                            </select>
                            @error('user_id')
                                <div class="text-xs mt-1 text-rose-500">
                                    Please Select a User
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="order" class="block text-sm font-medium mb-1">Select Rating <span
                                    class="text-rose-500">*</span></label>
                            <select id="overall_rating" class="form-select" name="overall_rating">
                                <option value="">Select Rating</option>
                                <option value="1"@if ($testimonial->overall_rating == '1.0') selected @endif>1</option>
                                <option value="2"@if ($testimonial->overall_rating == '2.0') selected @endif>2</option>
                                <option value="3"@if ($testimonial->overall_rating == '3.0') selected @endif>3</option>
                                <option value="4"@if ($testimonial->overall_rating == '4.0') selected @endif>4</option>
                                <option value="5"@if ($testimonial->overall_rating == '5.0') selected @endif>5</option>
                            </select>
                            @error('overall_rating')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-1">
                        <div>
                            <label for="description" class="block text-sm font-medium mb-1">Description <span
                                    class="text-rose-500">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3">
                            {{ $testimonial->description }}
                        </textarea>
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
