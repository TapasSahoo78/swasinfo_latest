@extends('vendor.layouts.app')
@section('pagetitlesection')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Total Stock:
                            {{ !empty($listProductss) ? $listProductss->count() : 0 }}
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-3">
                        <button class="model-slide-btn" id="addbranch-btn"
                            onclick="window.location='{{ route('vendor.other.stock.add') }}'">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Add Stock
                        </button>
                    </div><!-- /.col -->
                    {{-- <div class="col-sm-3">
                        <button class="model-slide-btn" id="addbranch-btn" data-toggle="modal"
                            data-target="#staticBackdrop">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Import
                        </button>
                    </div> --}}
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


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
                                            <th>Description</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($listProductss as $product)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No
                                                    Data Yet</td>
                                            </tr>
                                        @endforelse
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
