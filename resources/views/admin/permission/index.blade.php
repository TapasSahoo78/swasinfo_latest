@extends('admin.layouts.app')
@push('style')
<style>
    /* #permissionTable_filter{
        margin-right: -110px;
        margin-left: 147px;
        margin-bottom: 16px
    }
    #permissionTable_filter input {
        border-radius: 5px;
    } */
</style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
<!-- Page header -->
<div class="sm:flex sm:justify-between sm:items-center mb-8">

    <!-- Left: Title -->
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Roles ✨</h1>
    </div>

    <!-- Right: Actions -->
    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

        <!-- Delete button -->
        <div class="table-items-action hidden">
            <div class="flex items-center">
                <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span class="table-items-count"></span> items selected</div>
                <button class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Delete</button>
            </div>
        </div>

        <!-- Add customer button -->
        <a class="btn bg-indigo-500 hover:bg-indigo-600 text-white" href="{{ route('admin.permission.add') }}">
            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
            </svg>
            <span class="hidden xs:block ml-2">Add Permission</span>
        </a>

    </div>

</div>

<!-- Table -->
<div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">All Permissions {{-- <span class="text-slate-400 font-medium">442</span> --}}</h2>
    </header>
    <div x-data="handleSelect">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full divide-y divide-slate-200" id="permissionTable">
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
                            <div class="font-semibold text-left">Sr. No</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Name</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Slug</div>
                        </th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/datatableajax.js')}}"></script>
<script>
    // A basic demo function to handle "select all" functionality
    document.addEventListener('alpine:init', () => {
        Alpine.data('handleSelect', () => ({
            selectall: false,
            selectAction() {
                countEl = document.querySelector('.table-items-action');
                if (!countEl) return;
                checkboxes = document.querySelectorAll('input.table-item:checked');
                document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                if (checkboxes.length > 0) {
                    countEl.classList.remove('hidden');
                } else {
                    countEl.classList.add('hidden');
                }
            },
            toggleAll() {
                this.selectall = !this.selectall;
                checkboxes = document.querySelectorAll('input.table-item');
                [...checkboxes].map((el) => {
                    el.checked = this.selectall;
                });
                this.selectAction();
            },
            uncheckParent() {
                this.selectall = false;
                document.getElementById('parent-checkbox').checked = false;
                this.selectAction();
            }
        }))
    })
</script>
@endpush



