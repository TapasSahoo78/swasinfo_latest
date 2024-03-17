@extends('vendor.layouts.app')
@section('pagetitlesection')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <h1 class="m-0 text-dark">Total Poducts:
                            {{ !empty($listProductss) ? $listProductss->count() : 0 }}
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-5 align-items-center row">
                        <button class="model-slide-btn" id="addbranch-btn"
                            onclick="window.location='{{ route('vendor.other.product.add') }}'">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Add Product
                        </button>
                        <button class="model-slide-btn" id="addbranch-btn"
                            onclick="window.location='{{ route('vendor.other.stock.add') }}'">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Stock Created
                        </button>
                    </div><!-- /.col -->
                    <div class="col-sm-2 align-items-center">
                        <button class="model-slide-btn" id="addbranch-btn" data-toggle="modal"
                            data-target="#staticBackdrop">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Import
                        </button>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Import Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select name="category" id="" class="form-control mb-2">
                            {{ getAllCategory('') }}
                        </select>
                        <input type="file" class="form-control" name="" id="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btsssssssn-primary">Upload</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="row">
                    <div class="col-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <div class="table table-responsive" style="height:410px">
                                <table class="table  text-nowrap custom-data-table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Product Image</th>
                                            <th>Category</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Selling Price</th>
                                            <th>Stock</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @forelse ($listProductss as $product) --}}
                                        <tr>
                                            <td>1</td>
                                            <td><img src="{{ asset('assets/images/no-logo.jpg') }}" alt=""
                                                    width="40" alt="no img"></td>
                                            <td>Category 1</td>
                                            <td>Product 1</td>
                                            <td>200</td>
                                            <td>140</td>
                                            <td>10
                                                <a href="" data-toggle="modal" data-target="#stockCreated"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></a>
                                            </td>
                                            <td>03-03-2024</td>
                                            <td>
                                                <button>Edit</button>
                                                <button>delete</button>
                                            </td>

                                            <!-- Modal -->
                                            <div class="modal fade" id="stockCreated" data-backdrop="static"
                                                data-keyboard="false" tabindex="-1" aria-labelledby="stockCreatedLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="stockCreatedLabel">edit
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="product_id" id="">
                                                            <input type="text" class="float-number form-control"
                                                                name="" id="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="button"
                                                                class="btn btsssssssn-primary">Upload</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </tr>
                                        {{-- @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No
                                                    Data Yet</td>
                                            </tr>
                                        @endforelse --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection
