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
    <a href="#" class="nav-link custom-cumb">{{ __('Food') }}</a>
</li>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h1 class="m-0 text-dark">Add Food</h1>
                </div><!-- /.col -->
                <div class="col-sm-4 right_btn">
                    <a class="btn btn-primary" href="{{ route('admin.diet.food.list') }}">
                        <span><i class="fa fa-list" aria-hidden="true"></i></span>
                        Food List
                    </a>
                </div><!-- /.col -->
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
                <form method="post" action="{{ route('admin.diet.food.add') }}" id="customerForm" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="id" value="{{isset($data)?$data->id:''}}"> --}}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Name<sup>*</sup></label>
                                <input id="name" class="form-control" type="text" name="name" placeholder="Food" value="{{ old('name') }}" />
                                @error('name')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Food Type Veg/Non Veg<sup>*</sup></label>
                                <select id="food_type" class="form-control" name="food_type_option">
                                    <option value="">Select Type</option>
                                    <option value="veg" <?php echo 'veg' == old('food_type_option') ? 'selected' : ''; ?>> Veg</option>
                                    <option value="non_veg" <?php echo 'non_veg' == old('food_type_option') ? 'selected' : ''; ?>>Non Veg</option>
                                   
                                </select>
                                @error('food_type_option')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Food Type<sup>*</sup></label>
                                <select id="food_type" class="form-control" name="food_type">
                                    <option value="">Select Type</option>
                                    <option value="breakfast" <?php echo 'breakfast' == old('food_type') ? 'selected' : ''; ?>> Breakfast</option>
                                    <option value="lunch" <?php echo 'lunch' == old('food_type') ? 'selected' : ''; ?>> Lunch</option>
                                    <option value="dinner" <?php echo 'dinner' == old('food_type') ? 'selected' : ''; ?>> Dinner</option>
                                    <option value="snack" <?php echo 'snack' == old('food_type') ? 'selected' : ''; ?>> Snack</option>
                                </select>
                                @error('food_type')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity<sup>*</sup></label>
                                <input id="quantity" class="form-control" type="text" name="quantity" placeholder="quantity" value="{{ old('quantity') }}" />
                                @error('quantity')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Food suffix<sup>*</sup></label>
                                <select id="food_type" class="form-control" name="food_suffix">
                                    <option value="">Select Type</option>
                                    <option value="gram" <?php echo 'gm' == old('food_suffix') ? 'selected' : ''; ?>> Gram</option>
                                    <option value="pic" <?php echo 'pic' == old('food_suffix') ? 'selected' : ''; ?>> Pic</option>
                                    <option value="liter" <?php echo 'liter' == old('food_suffix') ? 'selected' : ''; ?>> Liter</option>
                                  
                                </select>
                                @error('food_suffix')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Food Make<sup>*</sup></label>
                                <select id="food_type" class="form-control" name="food_make">
                                    <option value="">Select Type</option>
                                    <option value="Homemade" <?php echo 'Homemade' == old('food_make') ? 'selected' : ''; ?>> Homemade</option>
                                    <option value="Restaurant" <?php echo 'Restaurant' == old('food_make') ? 'selected' : ''; ?>> Restaurant</option>
                                    <option value="Other" <?php echo 'Other' == old('food_make') ? 'selected' : ''; ?>> Other</option>
                                   
                                </select>
                                @error('food_make')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Is Optional<sup>*</sup></label>
                                <select id="is_optional" class="form-control" name="is_optional">
                                    <option value="">Is Optional</option>
                                    <option value="0" <?php echo '0' == old('is_optional') ? 'selected' : ''; ?>> No</option>
                                    <option value="1" <?php echo '1' == old('is_optional') ? 'selected' : ''; ?>> Yes</option>
                                </select>
                                @error('is_optional')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Food Image<sup>*</sup></label>
                                <input id="food_image" class="form-control" type="file" name="food_image" accept="image/jpeg,image/png,image/jpg,image/gif" />
                                @error('food_image')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Breakfast Callories</label>
                                <input id="breakfast_callories" class="form-control" type="text" name="breakfast_callories" placeholder="Breakfast Callories" value="{{ old('breakfast_callories') }}" />
                                @error('breakfast_callories')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lunch Callories</label>
                                <input id="lunch_callories" class="form-control" type="text" name="lunch_callories" placeholder="Lunch Callories" value="{{ old('lunch_callories') }}" />
                                @error('lunch_callories')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dinner Callories</label>
                                <input id="dinner_callories" class="form-control" type="text" name="dinner_callories" placeholder="Dinner Callories" value="{{ old('dinner_callories') }}" />
                                @error('dinner_callories')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Snack Callories</label>
                                <input id="snack_callories" class="form-control" type="text" name="snack_callories" placeholder="Snack Callories" value="{{ old('snack_callories') }}" />
                                @error('snack_callories')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CARBS</label>
                                <input id="carbs" class="form-control" type="text" name="carbs" placeholder="Breakfast Callories" value="{{ old('carbs') }}" />
                                @error('carbs')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>PROTEINS</label>
                                <input id="proteins" class="form-control" type="text" name="proteins" placeholder="PROTEINS" value="{{ old('proteins') }}" />
                                @error('proteins')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>FATS</label>
                                <input id="fats" class="form-control" type="text" name="fats" placeholder="FATS" value="{{ old('fats') }}" />
                                @error('fats')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>FIBRE</label>
                                <input id="fibre" class="form-control" type="text" name="fibre" placeholder="FIBRE" value="{{ old('fibre') }}" />
                                @error('fibre')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
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