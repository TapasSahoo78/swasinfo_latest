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
        <a href="#" class="nav-link custom-cumb">{{ __('Sub Category') }}</a>
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
                        <h1 class="m-0 text-dark">Add Sub Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4 right_btn">
                        <a class="btn btn-primary" href="{{ route('admin.subcategory.list') }}">
                            <span><i class="fa fa-list" aria-hidden="true"></i></span>
                            Sub Category List
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
                    <form method="post" action="{{ route('admin.subcategory.add') }}" id="customerForm"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="id" value="{{isset($data)?$data->id:''}}"> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category<sup>*</sup></label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        {{ getSubCategory(old('category_id') ?? '') }}
                                    </select>
                                    <span id="category-error" class="text-danger"></span>
                                    @error('category_id')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Category Name<sup>*</sup></label>
                                    <input id="sub_category" class="form-control" type="text" name="sub_category"
                                        placeholder="Sub Category" value="{{ old('sub_category') }}" />
                                    <span id="sub-category-error" class="text-danger"></span>
                                    @error('sub_category')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-9" id="commission-fields">
                                <!-- Commission rate fields will be dynamically added here -->
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" id="add-commission-field">Add
                                        Commission Rate</button>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-4">
                                <button class="btn btn-primary" id="submit-form" type="submit">Save</button>
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

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Function to add a new set of commission rate fields
            function addCommissionField() {
                // Create HTML elements for the new commission rate fields
                const commissionFieldHtml = `
                <div class="commission-row row">
            <div class="col-md-3 mb-3">
                <label>Price Range Min<sup>*</sup></label>
                <input class="form-control price-range-min" type="text" name="price_range_min[]" placeholder="Price Range Min" />
                <span class="text-danger min-error-message"></span>
            </div>
            <div class="col-md-3 mb-3">
                <label>Price Range Max <sup>*</sup></label>
                <input class="form-control price-range-max" type="text" name="price_range_max[]" placeholder="Price Range Max" />
                <span class="text-danger max-error-message"></span>
            </div>
            <div class="col-md-3 mb-3">
                <label>Commission Rate<sup>*</sup></label>
                <input class="form-control commission-rate" type="text" name="commission_rate[]" placeholder="Commission Rate" />
                <span class="text-danger rate-error-message"></span>
            </div>
            <div class="col-md-3 mb-3">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm btn-block remove-commission-field" style="width: 150px;">
                  <i class="fas fa-times"></i> <!-- Font Awesome remove icon -->
               </button>
            </div>
        </div>
        `;
                // Append the new commission rate fields to the commission fields container
                $('#commission-fields').append('<div class="row">' + commissionFieldHtml + '</div>');
            }

            // Function to validate commission rate fields
            function validateCommissionFields() {
                let isValid = true;

                $('.commission-row').each(function() {

                    const priceRangeMin = $(this).find('.price-range-min').val();
                    const priceRangeMax = $(this).find('.price-range-max').val();
                    const commissionRate = $(this).find('.commission-rate').val();
                    const minErrorMessage = $(this).find('.min-error-message');
                    const maxErrorMessage = $(this).find('.max-error-message');
                    const rateErrorMessage = $(this).find('.rate-error-message');

                    // Reset error messages
                    minErrorMessage.text('');
                    maxErrorMessage.text('');
                    rateErrorMessage.text('');

                    // Validate price range min
                    if (!priceRangeMin) {
                        minErrorMessage.text('Price Range Min is required.');
                        isValid = false;
                    }

                    // Validate price range max
                    if (!priceRangeMax) {
                        maxErrorMessage.text('Price Range Max is required.');
                        isValid = false;
                    }

                    // Validate commission rate
                    if (!commissionRate) {
                        rateErrorMessage.text('Commission Rate is required.');
                        isValid = false;
                    }
                });

                return isValid;
            }



            // Add commission rate fields when the button is clicked
            $('#add-commission-field').click(function() {
                // addCommissionField();
                if (validateCommissionFields()) {
                    addCommissionField();
                }
            });

            // Remove commission rate fields when the remove button is clicked
            $('#commission-fields').on('click', '.remove-commission-field', function() {
                $(this).closest('.commission-row').remove();
            });

            // Optionally, add some initial commission rate fields when the page loads
            addCommissionField();

            // Validation
            $('#submit-form').click(function() {

                var isValid = true;

                // Validate category
                var category = $('#category_id').val();
                if (!category) {
                    $('#category-error').html('Please select a category.');
                    isValid = false;
                } else {
                    $('#category-error').html('');
                }

                // Validate category
                var subcategory = $('#sub_category').val();
                if (!subcategory) {
                    $('#sub-category-error').html('Please enter sub category.');
                    isValid = false;
                } else {
                    $('#sub-category-error').html('');
                }

                // Validate price range min
                $('input[name^="price_range_min"]').each(function() {
                    if (!$(this).val()) {
                        $(this).next('.text-danger').html('Price Range Min is required.');
                        isValid = false;
                    } else {
                        $(this).next('.text-danger').html('');
                    }
                });

                // Validate price range max
                $('input[name^="price_range_max"]').each(function() {
                    if (!$(this).val()) {
                        $(this).next('.text-danger').html('Price Range Max is required.');
                        isValid = false;
                    } else {
                        $(this).next('.text-danger').html('');
                    }
                });

                // Validate commission rate
                $('input[name^="commission_rate"]').each(function() {
                    var commissionRate = $(this).val();
                    if (!commissionRate) {
                        $(this).next('.text-danger').html('Commission Rate is required.');
                        isValid = false;
                    } else {
                        // Clear previous error message if commission rate is provided
                        $(this).next('.text-danger').html('');

                        // Additional validation logic if needed
                        // Example: Ensure commission rate is a valid number
                        if (isNaN(commissionRate)) {
                            $(this).next('.text-danger').html(
                                'Commission Rate must be a valid number.');
                            isValid = false;
                        }
                    }
                });

                return isValid;
            });

        });
    </script>
@endpush
