<div class="text-sm text-slate-500 italic mb-4">
    <h2 class="font-semibold text-slate-800">All Products <span class="text-slate-400 font-medium">({{ $products->count() }})</span>
    </h2>
</div>
<div>
    <div class="grid grid-cols-12 gap-6">
        @forelse ($products as $product)
            <div
                class="col-span-full md:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200 overflow-hidden customdatatable">
                <div class="flex flex-col h-full">
                    <!-- Image -->
                    <div class="relative">

                        <a title="View" href="{{ route('admin.catalog.product.view.gallery', $product->uuid) }}"><img
                                class="w-full" src="{{ $product->latestImage }}" width="301" height="226"
                                alt="Application 21" /></a>
                        <!-- Like button -->

                        <!-- Special Offer label -->
                        <div class="absolute bottom-0 right-0 mb-4 mr-4">
                            <div class="inline-flex items-center text-xs font-medium text-slate-100 bg-slate-900 bg-opacity-60 rounded-full text-center px-2 py-0.5"
                                style="{{ $product->discount ? 'display: show;' : 'display: none;' }}">
                                <svg class="w-3 h-3 shrink-0 fill-current text-amber-500 mr-1" viewBox="0 0 12 12">
                                    <path
                                        d="M11.953 4.29a.5.5 0 00-.454-.292H6.14L6.984.62A.5.5 0 006.12.173l-6 7a.5.5 0 00.379.825h5.359l-.844 3.38a.5.5 0 00.864.445l6-7a.5.5 0 00.075-.534z" />
                                </svg>
                                <span>{{ $product->discount ? 'Special Discount' : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card Content -->
                    <div class="grow flex flex-col p-3">
                        <!-- Card body -->
                        <div class="grow">
                            <header class="mb-2">
                                <a href="{{ route('admin.catalog.product.view.gallery', $product->uuid) }}" title="View">
                                    <h3 class="text-lg text-slate-800 font-semibold mb-1">{{ $product->name }}</h3>
                                </a>
                                <p>Category : <span
                                        class="text-sm text-slate-800 font-semibold mb-1">{{ $product->category ? $product->category->name : '--' }}</span>
                                </p>

                            </header>
                        </div>

                        <!-- Rating and price -->
                        <div class="flex flex-wrap justify-between items-center">
                            <!-- Rating -->
                            <div class="flex items-center space-x-2 mr-2">
                                <!-- Stars -->
                                <div class="flex space-x-1">
                                    <button>
                                        <span class="sr-only">1 star</span>
                                        <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path
                                                d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                        </svg>
                                    </button>
                                    <button>
                                        <span class="sr-only">2 stars</span>
                                        <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path
                                                d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                        </svg>
                                    </button>
                                    <button>
                                        <span class="sr-only">3 stars</span>
                                        <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path
                                                d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                        </svg>
                                    </button>
                                    <button>
                                        <span class="sr-only">4 stars</span>
                                        <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path
                                                d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                        </svg>
                                    </button>
                                    <button>
                                        <span class="sr-only">5 stars</span>
                                        <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path
                                                d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Rate -->
                                <div class="inline-flex text-sm font-medium text-amber-600">4.7</div>
                            </div><br><br>
                            <!-- Price -->
                            <div>
                                <div
                                    class="inline-flex text-sm font-medium bg-rose-100 text-rose-600 rounded-full text-center px-2 py-0.5">
                                    ${{ $product->price ? number_format($product->price, 2) : '0.00' }}</div>
                            </div>
                            <div class="flex items-center text-center">
                                <div class="m-2">
                                    <!-- Start -->
                                    @switch($product->is_active)
                                        @case(1)
                                            <a href="javascript:void(0)" data-value="0" data-table="products" data-message="inactive"
                                                data-uuid="{{ $product->uuid }}"
                                                class="inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-0.5 changeStatus">Active</a>
                                        @break

                                        @case(0)
                                            <a href="javascript:void(0)" data-value="1" data-table="products" data-message="active"
                                                data-uuid="{{ $product->uuid }}"
                                                class="inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-0.5 changeStatus">Inactive</a>
                                        @break

                                        @default
                                            <a href="javascript:void(0)"
                                                class="inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-0.5">Deleted</a>
                                    @endswitch
                                </div>
                                <div class="m-2">
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                        href="{{ route('admin.catalog.product.edit', $product->uuid) }}">
                                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                                        </svg>

                                    </a>
                                </div>
                                <div class="m-2">
                                    <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-rose-500 deleteData"
                                        data-table="products" data-uuid="{{ $product->uuid }}" href="javascript:void(0)">
                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                                        </svg>

                                    </a>
                                </div>

                            </div>

                            {{--  <div class="flex items-center text-center">
                                <div class="m-1.5">
                                    <!-- Start -->

                                    <!-- End -->
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div>
                <h4 class="px-2 first:pl-5 last:pr-5 py-3 text-center whitespace-nowrap">No
                    Data Found Yet</h4>
            </div>
        @endforelse
    </div>
</div>

