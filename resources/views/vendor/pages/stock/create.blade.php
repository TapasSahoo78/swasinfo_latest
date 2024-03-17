@extends('vendor.layouts.app')
@push('style')
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
            {{-- <form action="{{ route('vendor.registraion') }}" method="get"> --}}

            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12 mt-1 mb-5">
                                <div class="input-group mb-3">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select Product</option>
                                        <option value="1">Product 1</option>
                                        <option value="2">Product 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-1 mb-5">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter Stock"
                                        aria-label="Enter Stock" aria-describedby="button-addon2">
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-1 mb-5">
                            <button type="submit" class="btn btn-primary">Save</button>
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


            {{-- </form> --}}
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
