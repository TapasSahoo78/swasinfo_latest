@extends('admin.layouts.app')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"> --}}
    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");

        :root {
            --primary: #333;
            --secondary: #333;
            --errorColor: red;
            --stepNumber: 6;
            --container-customWidth: 600px;
            --bgColor: #333;
            --inputBorderColor: lightgray;
        }

        ::selection {
            color: #fff;
            background: var(--primary);
        }

        .container-custom {
            background: #fff;
            text-align: center;
            border-radius: 5px;
        }

        .container-custom header {
            font-size: 35px;
            font-weight: 600;
            margin: 0 0 30px 0;
        }

        .container-custom .form-outer {
            width: 100%;
            overflow: hidden;
        }

        .container-custom .form-outer form {
            display: flex;
            width: calc(100% * var(--stepNumber));
        }

        .form-outer form .page {
            width: calc(100% / var(--stepNumber));
            transition: margin-left 0.3s ease-in-out;
        }

        form .page .field button {
            width: 100%;
            height: calc(100% + 5px);
            border: none;
            background: var(--secondary);
            margin-top: -20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.5s ease;
        }

        form .page .field button {
            width: 100%;
            height: calc(100% + 5px);
            border: none;
            background: #f9d95c;
            margin-top: -20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.5s ease;
            color: #000;
            font-weight: 500;
        }

        form .page .btns button {
            margin-top: -20px !important;
        }

        form .page .btns button.prev {
            margin-right: 3px;
            font-size: 17px;
        }

        form .page .btns button.next {
            margin-left: 3px;
        }

        .container-custom .steps-progress-bar {
            display: flex;
            margin: 40px 0;
            user-select: none;
        }

        .container-custom .steps-progress-bar .step {
            text-align: center;
            width: 100%;
            position: relative;
        }

        .container-custom .steps-progress-bar .step p {
            font-weight: 500;
            font-size: 18px;
            color: #000;
            margin-bottom: 8px;
        }

        .steps-progress-bar .step .bullet {
            height: 30px;
            width: 30px;
            border: 2px solid #000;
            display: inline-block;
            border-radius: 50%;
            position: relative;
            transition: 0.2s;
            font-weight: 500;
            font-size: 17px;
            line-height: 25px;
        }

        .steps-progress-bar .step .bullet.active {
            border-color: #f9d95c;
            background: #f9d95c;
        }

        .steps-progress-bar .step .bullet span {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .steps-progress-bar .step .bullet.active span {
            display: none;
        }

        .steps-progress-bar .step .bullet:before,
        .steps-progress-bar .step .bullet:after {
            position: absolute;
            content: "";
            bottom: 11px;
            right: -102px;
            height: 3px;
            width: 91px;
            background: #262626;
        }

        .steps-progress-bar .step .bullet.active:after {
            background: #f9d95c;
            transform: scaleX(0);
            transform-origin: left;
            animation: animate 0.3s linear forwards;
        }

        .plus_btn {
            display: flex;
            justify-content: flex-end;
        }

        .plus_btn button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }

        @keyframes animate {
            100% {
                transform: scaleX(1);
            }
        }

        .steps-progress-bar .step:last-child .bullet:before,
        .steps-progress-bar .step:last-child .bullet:after {
            display: none;
        }

        .steps-progress-bar .step p.active {
            color: var(--primary);
            transition: 0.2s linear;
        }

        .steps-progress-bar .step .check {
            position: absolute;
            left: 50%;
            top: 70%;
            font-size: 15px;
            transform: translate(-50%, -50%);
            display: none;
        }

        .steps-progress-bar .step .check.active {
            display: block;
            color: #fff;
        }

        @media screen and (max-width: 660px) {
            .steps-progress-bar .step p {
                display: none;
            }

            .steps-progress-bar .step .bullet::after,
            .steps-progress-bar .step .bullet::before {
                display: none;
            }

            .steps-progress-bar .step .bullet {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .steps-progress-bar .step .check {
                position: absolute;
                left: 50%;
                top: 50%;
                font-size: 15px;
                transform: translate(-50%, -50%);
                display: none;
            }

            .step {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        .page .single-input label {
            display: block;
            margin: 10px 0px;
        }

        .page .single-input input,
        .page .single-input select {
            margin-bottom: 0px;
        }

        .page .single-input textarea {
            width: 100%;
        }

        .add-more-field {
            border: 1px solid #0000004a;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            margin-bottom: 30px;
        }

        .btns-actions-postion {
            position: absolute;
            bottom: -23px;
            right: 20px;
        }

        .btns-actions-postion button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }
    </style>
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb">{{ __('Product') }}</a>
    </li>
@endsection
<style>
    .file_formbox {
        display: flex;
        gap: 20px;
    }
</style>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-3">
                        <h1 class="m-0 text-dark">Add Restaurant</h1>
                    </div><!-- /.col -->
                    @if (session('successs'))
                        <div class="alert alert-success" id="successAlert">
                            {{ session('successs') }}
                        </div>
                    @endif
                    {{-- <div class="col-sm-9 right_btn">
                    <div class="file_importbox">
                        <form action="{{ route('admin.product.addimport',$id) }}" method="POST" name="importform" enctype="multipart/form-data">
                            @csrf
                            <div class="file_formbox">
                                <div class="form-group">
                                    <label for="file">Product Import:</label>
                                    <input id="file" type="file" name="file" class="form-control">
                                </div>
                                <button class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                   
                </div><!-- /.col --> --}}
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="card p-3">
                    <form method="post" action="{{ route('admin.restaurant.add') }}" id="customerForm"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="id" value="{{isset($data)?$data->id:''}}"> --}}
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category<sup>*</sup></label>
                                    <select id="category_id" class="form-control" name="category_id" readonly>
                                        <option value="">Select Category</option>
                                        @forelse ($listCategories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (old('category_id') == $category->id || $productId == $category->id) selected @endif">
                                                {{ $category->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('category_id')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Restaurant Name<sup>*</sup></label>
                                    <input id="name" class="form-control" type="text" name="name"
                                        placeholder="Restaurant Name" value="{{ old('name') }}" />
                                    @error('name')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Restaurant Phone<sup>*</sup></label>
                                    <input id="phone" class="form-control" name="phone" placeholder="Restaurant Phone"
                                        value="{{ old('Phone') }}" />
                                    @error('Phone')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Restaurant Lat<sup>*</sup></label>
                                    <input id="lat" class="form-control" name="lat" placeholder="Restaurant Lat"
                                        value="{{ old('lat') }}" />
                                    @error('lat')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Restaurant Long<sup>*</sup></label>
                                    <input id="long" class="form-control" name="long" placeholder="Restaurant Long"
                                        value="{{ old('Long') }}" />
                                    @error('Long')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Product Color<sup>*</sup></label>
                                    <input id="product_color" class="form-control" name="color"
                                        placeholder="Product Color" value="{{ old('color') }}" />
                                    @error('color')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Restaurant Featured Type<sup>*</sup></label>
                                    <select id="is_featured" class="form-control" name="is_featured">
                                        <option value="">Select Featured</option>
                                        <option value="dinning" @if (old('is_featured') == 'dinning') selected @endif>dinning
                                        </option>
                                        <option value="delivery" @if (old('is_featured') == 'delivery') selected @endif>delivery
                                        </option>
                                        <option value="both" @if (old('is_featured') == 'both') selected @endif>both
                                        </option>
                                        <option value="other" @if (old('is_featured') == 'other') selected @endif>other
                                        </option>
                                    </select>
                                    @error('is_featured')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" id="" class="form-control" cols="30" rows="3" placeholder="Address"></textarea>
                                    @error('address')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Restaurant Image</label>
                                    <input type="file" class="form-control" id="restaurant_image"
                                        name="restaurant_image[]" accept="image/jpeg,image/png,image/jpg,image/gif"
                                        multiple>
                                    @error('restaurant_image')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4>Restaurant Owner Details</h4>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name<sup>*</sup></label>
                                    <input id="first_name" class="form-control" type="text" name="first_name"
                                        placeholder="First Name" value="{{ old('first_name') }}" />
                                    @error('first_name')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name<sup>*</sup></label>
                                    <input id="last_name" class="form-control" type="text" name="last_name"
                                        placeholder="Last Name" value="{{ old('last_name') }}" />
                                    @error('last_name')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- </div> --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email<sup>*</sup></label>
                                    <input id="email" class="form-control" type="text" name="email"
                                        placeholder="Email" value="{{ old('email') }}" />
                                    @error('email')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone<sup>*</sup></label>
                                    <input id="mobile_number" class="form-control" type="text" name="mobile_number"
                                        placeholder="Phone" value="{{ old('mobile_number') }}" />
                                    @error('mobile_number')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row mt-3"> --}}
                        {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Assign Role<sup>*</sup></label>
                                        <select id="role_id" class="form-control" name="role">
                                            <option value="">Select Role</option>
                                            @forelse ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    @if (old('role_id') == $role->id) selected @endif>{{ $role->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('role')
                                            <span class="text-sm text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password<sup>*</sup></label>
                                <input id="password" class="form-control" type="password" name="password"
                                    placeholder="Password" value="{{ old('password') }}" />
                                @error('password')
                                    <span class="text-sm text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- </div> --}}

                        {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stock<sup>*</sup></label>
                                    <input id="price" class="form-control" name="stock" placeholder="Product Stock"
                                        value="{{ old('stock') }}" />
                                    @error('price')
                                        <div class="text-xs mt-1 text-rose-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div> --}}
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- add baranch form -->
    <!-- add baranch form-end-->
    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    {{-- <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  --}}
    {{-- <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script> --}}
    <script src="{{ asset('assets/admin/js/datatableajax.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer-kyc-verification.js') }}"></script>
    <script src="{{ asset('assets/admin/js/customer-kyc-document-verification.js') }}"></script>
@endpush
