@extends('admin.layouts.app')

@push('style')

@endpush
@section('content')
@include('admin.layouts.partials.page-title',['html'=>['route'=>route('admin.menu.add'),'text'=>'Add Menu']])
<!-- Table -->
<div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">{{ $pageTitle }} <span class="text-slate-400 font-medium">({{ $listMenus->count() }})</span></h2>
    </header>
    <div x-data="handleSelect">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-slate-200 customdatatable">
                <!-- Table header -->
                <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                    <tr>
                        {{-- <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <div class="flex items-center">
                                <label class="inline-flex">
                                    <span class="sr-only">Select all</span>
                                    <input id="parent-checkbox" class="form-checkbox" type="checkbox" @click="toggleAll" />
                                </label>
                            </div>
                        </th> --}}
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Name</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Position</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Section(footer)</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Status</div>
                        </th>
                        <th class="text-center px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                            <div class="font-semibold">Action</div>
                        </th>
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm" x-data="{ open: false }">
                    @php
                        $i= 0;
                    @endphp
                    @forelse ($listMenus as $menu)
                    <!-- Row -->
                    <tr>
                        {{-- <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <div class="flex items-center">
                                <label class="inline-flex">
                                    <span class="sr-only">Select</span>
                                    <input class="table-item form-checkbox" type="checkbox" @click="uncheckParent" />
                                </label>
                            </div>
                        </td> --}}
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div>{{ $menu->name ?? '--' }}</div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">
                                {{ $menu->is_header ? 'header' : 'footer' }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">
                                {{-- {{ $menu->parent ? $menu->parent->name : '--' }} --}}
                                {{ $menu->position ?? '--' }} {{-- for php 8 --}}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            @switch($menu->status)
                                @case(1)
                                    <a href="javascript:void(0)" data-value="0" data-table="menus" data-message="inactive" data-uuid="{{ $menu->uuid }}" class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeStatus">Active</a>
                                    @break
                                @case(0)
                                    <a href="javascript:void(0)" data-value="1" data-uuid="{{ $menu->uuid }}" data-table="menus" data-message="active" class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeStatus">Inactive</a>
                                    @break
                                @default
                                    <a href="javascript:void(0)" class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Deleted</a>
                            @endswitch
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                            <div class="flex items-center text-center">
                                <div class="m-1.5">
                                    <!-- Start -->
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600" href="{{ route('admin.menu.edit', $menu->uuid) }}">
                                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                            <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                        </svg>
                                        <span class="ml-2">Edit</span>
                                    </a>
                                    <!-- End -->
                                </div>
                                <div class="m-1.5">
                                    <!-- Start -->
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 deleteData" data-table="menus"  data-uuid="{{ $menu->uuid }}" href="javascript:void(0)">
                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                        </svg>
                                        <span class="ml-2">Delete</span>
                                    </a>
                                    <!-- End -->
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-2 first:pl-5 last:pr-5 py-3 text-center whitespace-nowrap">No Data Yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.layouts.paginate',['paginatedCollection'=>$listMenus])

@endsection
@push('scripts')

@endpush
