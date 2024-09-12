@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.partials.page-title', ['backbutton' => true])
    <!-- Page content -->
    <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">

        <!-- Content -->
        <div>
            {{--  <div class="mb-3">

            </div> --}}


            <!-- Meta -->


            @include('admin.product.partials.product-details-offer-display')

            <!-- Image -->
            @include('admin.product.components.product-details-images', ['productData' => $productData])

            <!-- Product content -->
            @include('admin.product.partials.product-details-description')

            <hr class="my-6 border-t border-slate-200" />

            <!-- Reviews -->

            @include('admin.product.partials.product-details-review')


            <!-- Related -->




        </div>

        <!-- Sidebar -->
        @include('admin.product.partials.product-details-rightbar')


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
@endpush
