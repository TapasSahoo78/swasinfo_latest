@extends('vendor.layouts.app')
@push('style')
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
            <form action="{{ route('vendor.other.product.add') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-10">
                        <div class="row">
                            <div class="row col-12">
                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <select name="category" id="" class="form-control">
                                            {{ getAllCategory('') }}
                                        </select>
                                    </div>
                                    @error('category')
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Product Name"
                                            aria-label="Enter Product Name" name="product_name"
                                            aria-describedby="button-addon2">
                                    </div>
                                    @error('product_name')
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <select name="unit" id="" class="form-control">
                                            {{ getAllUnit('') }}
                                        </select>
                                    </div>
                                    @error('unit')
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control float-number" placeholder="Enter Quantity"
                                            aria-label="Enter Quantity" name="quantity" aria-describedby="button-addon2">
                                    </div>
                                    @error('quantity')
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row col-12">
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Price"
                                                aria-label="Enter Price" name="price" aria-describedby="button-addon2">
                                        </div>
                                        @error('price')
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Selling Price"
                                                aria-label="Enter Selling Price" name="selling_price"
                                                aria-describedby="button-addon2">
                                        </div>
                                        @error('selling_price')
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter SKU Number"
                                                aria-label="Enter SKU Number" name="sku_number"
                                                aria-describedby="button-addon2">
                                        </div>
                                        @error('sku_number')
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="brand"
                                                placeholder="Enter Brand Name" aria-label="Enter Brand Name"
                                                aria-describedby="button-addon2">
                                        </div>
                                        @error('brand')
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="product_img[]"
                                                aria-label="Enter Price" aria-describedby="button-addon2" multiple>
                                        </div>
                                        @error('product_img')
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Stock"
                                                aria-label="Enter Stock" name="stock" aria-describedby="button-addon2">
                                        </div>
                                        @error('stock')
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-12">
                                        <textarea name="description" id="" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Description"></textarea>
                                    </div>
                                    @error('description')
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-1 mb-5">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 p-8">
                        <img src="{{ asset('assets/images/office.jpg') }}" alt="">
                        <br><br><br>
                        <img src="{{ asset('assets/images/office.jpg') }}" alt="">
                        <br><br><br>
                        <img src="{{ asset('assets/images/office.jpg') }}" alt="">
                    </div>
                </div>

            </form>
        </div>

    </div>
    <!-- loan-card -->
    <!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/editor.js') }}"></script>
@endpush
