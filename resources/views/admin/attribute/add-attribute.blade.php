    @extends('admin.layouts.app')
    @push('style')
    @endpush
    @section('content')
        <div>
            @include('admin.layouts.partials.page-title',['backbutton'=>true])
            <div class="border-t border-slate-200">
                <form method="post" action="{{ route('admin.catalog.attribute.add') }}">
                    @csrf
                    <div class="space-y-8 mt-8">
                        <div class="grid gap-5 md:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium mb-1" for="name">Attribute Name <span
                                        class="text-rose-500">*</span></label>
                                <input id="name" class="form-input w-full" type="text" name="name"
                                    placeholder="Attribute Name" value="{{ old('name') }}" />
                                @error('name')
                                    <div class="text-xs mt-1 text-rose-500">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="space-y-8 mt-8">
                        <label class="block text-sm font-medium mb-1" for="name">Select Category <span
                                class="text-rose-500">*</span> </label>
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
                                                        <input type="checkbox" class="form-checkbox" name="category[]" value="{{ $category->id }}" />
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
                                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                    <path
                                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z">
                                    </path>
                                </svg>
                                <span class="hidden xs:block ml-2" id="bulk_add">Add</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    @endsection
    @push('scripts')
    @endpush
