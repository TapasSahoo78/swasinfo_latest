@extends('admin.layouts.app')

@section('content')
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Attribute </h1>
        </div>
        <!-- Right: Actions -->
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

            <!-- Delete button -->
            <div class="table-items-action hidden">
                <div class="flex items-center">
                    <div class="hidden xl:block text-sm italic mr-2 whitespace-nowrap"><span class="table-items-count"></span>
                        items selected</div>
                    <button
                        class="btn bg-white border-slate-200 hover:border-slate-300 text-rose-500 hover:text-rose-600">Delete</button>
                </div>
            </div>

            <!-- Add customer button -->
            <a class="btn bg-indigo-500 hover:bg-indigo-600 text-white" href="{{ route('admin.catalog.attribute.add') }}">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="hidden xs:block ml-2">Add Attribute</span>
            </a>

        </div>
    </div>
    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
        <header class="px-5 py-4">
            <h2 class="font-semibold text-slate-800">{{ $pageTitle }} <span
                    class="text-slate-400 font-medium">({{ $listAttributes->count() }})</span></h2>
        </header>
        <div x-data="handleSelect">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full divide-y divide-slate-200 customdatatable">
                    <!-- Table header -->
                    <thead class="text-xs uppercase text-slate-500 bg-slate-50 border-t border-slate-200">
                        <tr>
                            <th class="px-2 first:pl-5 last:pr-3 py-3 whitespace-nowrap text-center">
                                <div class="font-semibold text-left">SR. NO</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                <div class="font-semibold text-left">Name</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                <div class="font-semibold text-left">Status</div>
                            </th>
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                <div class="font-semibold">Action</div>
                            </th>
                        </tr>
                    </thead>
                    @php
                        $i = 0;
                    @endphp
                    <!-- Table body -->
                    <tbody class="text-sm" x-data="{ open: false }">
                        @forelse ($listAttributes as $attribute)
                            <!-- Row -->
                            <tr>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center text-slate-800">
                                        <div
                                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3">
                                            <div class="font-medium text-sky-500">#{{ ++$i }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                                    <div>{{ $attribute->name }}</div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @switch($attribute->is_active)
                                        @case(1)
                                            <a href="javascript:void(0)" data-value="0" data-table="attributes"
                                                data-message="inactive" data-uuid="{{ $attribute->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeStatus">Active</a>
                                        @break

                                        @case(0)
                                            <a href="javascript:void(0)" data-value="1" data-uuid="{{ $attribute->uuid }}"
                                                data-table="attributes" data-message="active"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeStatus">Inactive</a>
                                        @break

                                        @default
                                            <a href="javascript:void(0)"
                                                class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Deleted</a>
                                    @endswitch
                                </td>
                                <td
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap flex items-center justify-content-center">
                                    <div class="flex items-center text-center">
                                        <div class="m-1.5">
                                            <!-- Start -->
                                            <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                                href="{{ route('admin.catalog.attribute.edit', $attribute->uuid) }}">
                                                <svg class="w-4 h-4 fill-current text-slate-500 shrink-0"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                                </svg>
                                                <span class="ml-2">Edit</span>
                                            </a>
                                            <!-- End -->
                                        </div>
                                        <div class="m-1.5">
                                            <!-- Start -->
                                            <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 deleteData"
                                                data-table="attributes" data-uuid="{{ $attribute->uuid }}"
                                                href="javascript:void(0)">
                                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
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
                                    <td colspan="3" class="px-2 first:pl-5 last:pr-5 py-3 text-center whitespace-nowrap">No
                                        Data Yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('admin.layouts.paginate', ['paginatedCollection' => $listAttributes])

        <!-- Modal -->
        <div class="modal" id="valueModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Attribute Value</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3"method="post" action="{{ route('admin.catalog.attribute.value.add') }}"
                            name="attributeForm">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">Value</label>
                                <input type="hidden" value="" name="attribute_id" id="attribute_id">
                                <input type="text" class="form-control" id="value" name="value"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="col-md-12 pt-2 text-center">
                                <button type="submit" class="btn btn-primary btn-md btn-block">Add Value</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
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
        <script>
            function openModal(id) {
                $('#attribute_id').val('');
                $('#attribute_id').val(id);
                $('#valueModal').modal('show')
                // alert(id);
            }

            function viewModal(data) {
                console.log(data);
                var options = new Array();
                $.each(data, function(key, value) {
                    options.push('<tr><td>' + key + '</td><td>' + value + '</option>');
                });
                $('#appendValues').append(options);
                $('#viewValues').modal('show');
            }
        </script>
    @endpush
