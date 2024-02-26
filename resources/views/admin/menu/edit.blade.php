@extends('admin.layouts.app')

@push('style')
@endpush
@section('content')
    <div>
        @include('admin.layouts.partials.page-title')
        <div class="border-t border-slate-200">
            <form method="post" action="{{ route('admin.menu.update', $menuData->uuid) }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8 mt-8">
                    <div class="grid gap-5 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Name <span
                                    class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full" type="text" name="name"
                                value="{{ $menuData->name }}" />
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
                                <option value="header" @if ($menuData->is_header) selected @endif>Header</option>
                                <option value="footer" @if ($menuData->is_footer) selected @endif>Footer</option>
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
                                <option value="division-1" @if ($menuData->position == 'division-1') selected @endif>Division-1
                                </option>
                                <option value="division-2" @if ($menuData->position == 'division-2') selected @endif>Division-2
                                </option>
                                <option value="division-3" @if ($menuData->position == 'division-3') selected @endif>Division-3
                                </option>
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
                                <option value="0" @if ($menuData->is_external=='0') selected @endif>Internal</option>
                                <option value="1" @if ($menuData->is_external=='1') selected @endif>External</option>
                            </select>
                            @error('is_external')
                                <div class="text-xs mt-1 text-rose-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="url" class="block text-sm font-medium mb-1">Select Page<span
                                    class="text-rose-500">*</span></label>
                            <select id="url" class="form-select url" name="url">
                                @forelse ($pages as $page)
                                    <option value="{{ $page->slug }}" data-id="{{ $page->uuid }}"
                                        @if ($menuData->page_id == $page->id) selected @endif>{{ $page->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            <input type="hidden" name="external_url" disabled value="{{ $menuData->url }}" class="form-input w-full url-box"/>
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

                            <span class="hidden xs:block ml-2">Edit</span>
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
