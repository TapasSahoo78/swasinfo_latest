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
        <a href="#" class="nav-link custom-cumb">{{ __('DIET PLAN') }}</a>
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
                        <h1 class="m-0 text-dark">Add Diet</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-4 right_btn">
                        <a class="btn btn-primary" href="{{ route('admin.diet.plan.list') }}">
                            <span><i class="fa fa-list" aria-hidden="true"></i></span>
                            Diet List
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
                <div class="card p-3 diet_sec">
                    <form method="post" action="{{ route('admin.diet.plan.add') }}" id="customerForm"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="id" value="{{isset($data)?$data->id:''}}"> --}}
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Gender<sup>*</sup></label><br>
                                    <input type="radio" id="gender1" name="gender" value="male">
                                    <label for="vehicle1"> Male</label>
                                    <input type="radio" id="gender2" name="gender" value="female">
                                    <label for="vehicle2"> Female</label>
                                    @error('gender')
                                        <span class="text-danger text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Age Range<sup>*</sup></label><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="age_from" id="age_from">
                                                <option value="">Select From Age</option>
                                                @forelse ($fromAgeRange as $fromAge)
                                                    <option value="{{ $fromAge }}" <?php echo $fromAge == old('age_from') ? 'selected' : ''; ?>>{{ $fromAge }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('age_from')
                                                <span class="text-danger text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="age_to" id="age_from">
                                                <option value="">Select To Age</option>
                                                @forelse ($toAgeRange as $toAge)
                                                    <option value="{{ $toAge }}" <?php echo $toAge == old('age_to') ? 'selected' : ''; ?>>{{ $toAge }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('age_to')
                                                <span class="text-danger text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Height Range<sup>*</sup></label><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="height_from" id="height_from">
                                                <option value="">From Height</option>
                                                @forelse ($fromHeightRange as $fromHeight)
                                                    <option value="{{ $fromHeight }}" <?php echo $fromHeight == old('height_from') ? 'selected' : ''; ?>>{{ $fromHeight }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('height_from')
                                                <span class="text-danger text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="height_to" id="height_to">
                                                <option value="">To Height</option>
                                                @forelse ($toHeightRange as $toHeight)
                                                    <option value="{{ $toHeight }}" <?php echo $toHeight == old('height_to') ? 'selected' : ''; ?>>{{ $toHeight }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('height_to')
                                                <span class="text-danger text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Weight Range<sup>*</sup></label><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="weight_from" id="weight_from">
                                                <option value=""> Weight From</option>
                                                @forelse ($fromWeightRange as $fromWeight)
                                                    <option value="{{ $fromWeight }}" <?php echo $fromWeight == old('weight_from') ? 'selected' : ''; ?>>{{ $fromWeight }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('weight_from')
                                                <span class="text-danger text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="weight_to" id="weight_to">
                                                <option value="">Weight To</option>
                                                @forelse ($toWeightRange as $toWeight)
                                                    <option value="{{ $toWeight }}" <?php echo $toWeight == old('weight_to') ? 'selected' : ''; ?>>{{ $toWeight }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('weight_to')
                                                <span class="text-danger text-sm">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>BMI<sup>*</sup></label>
                                    <input id="bmi_from" class="form-control" type="text" name="bmi_from"
                                        placeholder="BMI" value="{{ old('bmi_from') }}" />
                                    @error('bmi_from')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Goal<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <select class="form-control" name="goal">
                                            <option value="">Select Goal</option>
                                            <option value="muscle_gain" <?php echo "muscle_gain" == old('goal') ? 'selected' : ''; ?>>MUSCLE GAIN</option>
                                            <option value="fat_loss" <?php echo "fat_loss" == old('goal') ? 'selected' : ''; ?>>FAT LOSS</option>
                                        </select>
                                        @error('goal')
                                            <span class="text-danger text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Diet<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <select class="form-control" name="diet">
                                            <option value="">Select Diet</option>
                                            <option value="veg" <?php echo "veg" == old('diet') ? 'selected' : ''; ?>>VEG</option>
                                            <option value="non_veg" <?php echo "non_veg" == old('diet') ? 'selected' : ''; ?>>NON-VEG</option>
                                        </select>
                                        @error('diet')
                                            <span class="text-danger text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Medical Condition<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <select class="form-control" name="medical_condition">
                                            <option value="">Select Medical Condition</option>
                                            <option value="asthma" <?php echo "asthma" == old('medical_condition') ? 'selected' : ''; ?>>ASTHMA</option>
                                            <option value="bp" <?php echo "bp" == old('medical_condition') ? 'selected' : ''; ?>>BP</option>
                                            <option value="joint" <?php echo "joint" == old('medical_condition') ? 'selected' : ''; ?>>JOINT</option>
                                            <option value="pcos" <?php echo "pcos" == old('medical_condition') ? 'selected' : ''; ?>>PCOS</option>
                                        </select>
                                        @error('medical_condition')
                                            <span class="text-danger text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Allergy<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <select class="form-control" name="allergy">
                                            <option value="">Select Allergy</option>
                                            <option value="gluten" <?php echo "gluten" == old('allergy') ? 'selected' : ''; ?>>GLUTEN</option>
                                            <option value="lactose" <?php echo "lactose" == old('allergy') ? 'selected' : ''; ?>>LACTOSE</option>
                                        </select>
                                        @error('allergy')
                                            <span class="text-danger text-sm">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Breakfast <sup>*</sup></label>

                                    @forelse ($breakfast as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $breakfast)
                                                <input type="checkbox" name="breakfast[]" id=""
                                                    value="{{ $breakfast->id }}"><span
                                                    class="m-2">{{ $breakfast->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('breakfast')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Optional Breakfast <sup>*</sup></label>

                                    @forelse ($breakfastOptional as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $optionalBreakfast)
                                                <input type="checkbox" name="optionalbreakfast[]" id=""
                                                    value="{{ $optionalBreakfast->id }}"><span
                                                    class="m-2">{{ $optionalBreakfast->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('optionalbreakfast')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                  
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Lunch <sup>*</sup></label>

                                    @forelse ($lunch as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $lunch)
                                                <input type="checkbox" name="lunch[]" id=""
                                                    value="{{ $lunch->id }}"><span
                                                    class="m-2">{{ $lunch->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('lunch')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                     
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Optional Lunch <sup>*</sup></label>

                                    @forelse ($lunchOptional as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $lunchOptional)
                                                <input type="checkbox" name="optionallunch[]" id=""
                                                    value="{{ $lunchOptional->id }}"><span
                                                    class="m-2">{{ $lunchOptional->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('optionallunch')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                      
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Dinner <sup>*</sup></label>

                                    @forelse ($dinner as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $dinner)
                                                <input type="checkbox" name="dinner[]" id=""
                                                    value="{{ $dinner->id }}"><span
                                                    class="m-2">{{ $dinner->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('dinner')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                   
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Optional Dinner <sup>*</sup></label>

                                    @forelse ($dinnerOptional as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $dinnerOptional)
                                                <input type="checkbox" name="optionaldinner[]" id=""
                                                    value="{{ $dinnerOptional->id }}"><span
                                                    class="m-2">{{ $dinnerOptional->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('optionaldinner')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                       
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Snack <sup>*</sup></label>

                                    @forelse ($snack as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $snack)
                                                <input type="checkbox" name="snack[]" id=""
                                                    value="{{ $snack->id }}"><span
                                                    class="m-2">{{ $snack->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('dinner')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                  
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label>Select Optional Snack <sup>*</sup></label>

                                    @forelse ($snackOptional as $chunk)
                                        <div class="col-12">
                                            @forelse ($chunk as $snackOptional)
                                                <input type="checkbox" name="optionalsnack[]" id=""
                                                    value="{{ $snackOptional->id }}"><span
                                                    class="m-2">{{ $snackOptional->name }}</span>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    @error('optionalsnack')
                                        <span class="text-sm text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
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
