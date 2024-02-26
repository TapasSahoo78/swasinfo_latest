@extends('admin.layouts.app')

@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title')
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name"
                                value="{{ old('name') }}" />
                            @error('name')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="menu_position" class="block text-sm font-medium mb-1">Select Menu Position <span
                                    class="text-rose-500">*</span></label>
                            <select id="menu_position" class="form-select menu_position" name="menu_position">
                                <option value="header">Header</option>
                                <option value="footer">Footer</option>
                            </select>
                            @error('menu_position')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-medium mb-1">Select Footer Position</label>
                            <select id="position" class="form-select position" name="position" disabled>
                                <option value="">Select division</option>
                                <option value="division-1">Division-1</option>
                                <option value="division-2">Division-2</option>
                                <option value="division-3">Division-3</option>
                            </select>
                            @error('position')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="is_external" class="block text-sm font-medium mb-1">External/Internal<span
                                    class="text-rose-500">*</span></label>
                            <select id="is_external" class="form-select is_external" name="is_external">
                                <option value="0">Internal</option>
                                <option value="1">External</option>
                            </select>
                            @error('is_external')
                                <div class="text-xs mt-1 text-rose-500">
                                   {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="url" class="block text-sm font-medium mb-1 urlLabel">Select Page<span
                                    class="text-rose-500">*</span></label>
                            <select id="url" class="form-select url" name="url">
                                @forelse ($pages as $page)
                                    <option value="{{ $page->slug }}" data-id="{{ $page->uuid }}">{{ $page->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            <input type="hidden" name="external_url" disabled value="{{ old('url') }}" class="form-input w-full url-box"/>
                            @error('url')
                                <div class="text-xs mt-1 text-rose-500">
                                    Please Select a page to link with the menu
                                </div>
                            @enderror
                            @error('external_url')
                                <div class="text-xs mt-1 text-rose-500">
                                    Please Select a page to link with the menu
                                </div>
                            @enderror
                        </div>

                        <input type="hidden" name="page_id" class="page_id" value="">
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
        {{-- @include('errors.all') --}}
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/menu.js') }}"></script>
@endpush
