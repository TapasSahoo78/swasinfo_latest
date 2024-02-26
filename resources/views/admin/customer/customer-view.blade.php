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
    <a href="#" class="nav-link custom-cumb">{{ __('Users View') }}</a>
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
                    <h1 class="m-0 text-dark">View Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-4 right_btn">
                    <a class="btn btn-primary" href="{{ route('admin.trainer.list') }}">
                        <span><i class="fa fa-list" aria-hidden="true"></i></span>
                        View Users
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
                <!-- <form method="post" action="{{ route('admin.trainer.edit',$user->uuid) }}" id="customerForm" enctype="multipart/form-data">
                    @csrf -->
                {{-- <input type="hidden" name="id" value="{{isset($data)?$data->id:''}}"> --}}
                <div class="row cards_box">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Name<sup></sup></label>
                            {{ $user->first_name }}

                            @error('name')
                            <span class="text-sm text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Email<sup></sup></label>
                            {{ $user->email }}
                            @error('email')
                            <span class="text-sm text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone<sup></sup></label>
                            {{ $user->mobile_number  }}
                            @error('mobile_number')
                            <span class="text-sm text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Introduction<sup></sup></label>
                            {{ $user->trainerProfile?->introduction }}
                            @error('mobile_number')
                            <span class="text-sm text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="">
                            <label class="block text-sm font-medium mb-1">Current Image</label>
                            <img class="ml-1 img_circle" src="{{ $user->customer_picture }}" width="75" height="60" alt="Icon 01" />
                        </div>
                    </div>

                </div>

                <br></br>
                <?php if ($user->fitness) : ?>

                    <h5>Fitness Details</h5>
                    @forelse($user->fitness as $fitness)
                    <div class="row cards_box">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title<sup></sup></label>
                                {{$fitness->title}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Title<sup></sup></label>
                                {{$fitness->sub_title}}
                            </div>
                        </div>

                    </div>
                    @empty
                    <!-- You can add any HTML or text you want to be displayed when the fitness data is empty. For example: -->
                    <p>No fitness data found.</p>
                    @endforelse
                <?php endif; ?>
                <br></br>

                <?php if ($user->physicalCondition) : ?>
                    <h5>Physical Conditions Details</h5>

                    @forelse($user->physicalCondition as $physicalCondition)
                    <div class="row cards_box">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Title<sup></sup></label>
                                {{$physicalCondition->title}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sub Title<sup></sup></label>
                                {{$physicalCondition->sub_title}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Description<sup></sup></label>
                                {{$physicalCondition->description}}
                            </div>
                        </div>


                    </div>
                    @empty
                    <!-- You can add any HTML or text you want to be displayed when the fitness data is empty. For example: -->
                    <p>No Physical Conditions found.</p>
                    @endforelse
                <?php endif; ?>
                <br></br>

                <?php if ($user->userHealthScreenOneDetails) : ?>
                    <h5>Physical Health Schedule.</h5>

                    <div class="row cards_box">
                        @if(isset($user->userHealthScreenOneDetails->sleep_schedule) && !empty($user->userHealthScreenOneDetails->sleep_schedule))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sleep Schedule<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->sleep_schedule }}

                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->total_sleep_hours) && !empty($user->userHealthScreenOneDetails->total_sleep_hours))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Sleep Hours<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->total_sleep_hours }}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->is_followed_diet_plan) && !empty($user->userHealthScreenOneDetails->is_followed_diet_plan))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Follow Diet Plan<sup></sup></label>
                                <?php if ($user->userHealthScreenOneDetails->is_followed_diet_plan == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenOneDetails->is_followed_diet_plan == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->diet_plan_last_time) && !empty($user->userHealthScreenOneDetails->diet_plan_last_time))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Diet Plan Last Time<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->diet_plan_last_time }}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->is_followed_exercise_plan) && !empty($user->userHealthScreenOneDetails->is_followed_exercise_plan))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Followed Exercise Plan<sup></sup></label>
                                <?php if ($user->userHealthScreenOneDetails->is_followed_exercise_plan == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenOneDetails->is_followed_exercise_plan == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->exercise_plan_last_time) && !empty($user->userHealthScreenOneDetails->exercise_plan_last_time))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Exercise Plan Last Time<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->exercise_plan_last_time }}
                            </div>
                        </div>
                        @endif

                    </div>

                    <div class="row cards_box">
                        @if(isset($user->userHealthScreenOneDetails->any_physical_movement) && !empty($user->userHealthScreenOneDetails->any_physical_movement))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Any Physical Movement<sup></sup></label>
                                <?php if ($user->userHealthScreenOneDetails->any_physical_movement == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenOneDetails->any_physical_movement == 1) {
                                    echo "Yes";
                                } ?>

                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->physical_movement_last_time) && !empty($user->userHealthScreenOneDetails->physical_movement_last_time))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Physical Movement Last Time<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->physical_movement_last_time }}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenOneDetails->water_intake_last_time) && !empty($user->userHealthScreenOneDetails->water_intake_last_time))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Water Intake Last Time<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->water_intake_last_time }}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenTwoDetails->do_you_get_tired_during_the_day) && !empty($user->userHealthScreenTwoDetails->do_you_get_tired_during_the_day))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Do You Get Tired During The Day<sup></sup></label>
                                <?php if ($user->userHealthScreenTwoDetails->do_you_get_tired_during_the_day == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenTwoDetails->do_you_get_tired_during_the_day == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenTwoDetails->feel_drizzing_when_you_wakeup) && !empty($user->userHealthScreenTwoDetails->feel_drizzing_when_you_wakeup))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Feel Drizzing When You Wakeup<sup></sup></label>
                                <?php if ($user->userHealthScreenTwoDetails->feel_drizzing_when_you_wakeup == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenTwoDetails->feel_drizzing_when_you_wakeup == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenTwoDetails->how_much_do_you_smoke_in_a_day) && !empty($user->userHealthScreenTwoDetails->how_much_do_you_smoke_in_a_day))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>How Much Do You Smoke in a day<sup></sup></label>
                                {{ $user->userHealthScreenTwoDetails->how_much_do_you_smoke_in_a_day }}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->userHealthScreenTwoDetails->how_often_do_you_drink) && !empty($user->userHealthScreenTwoDetails->how_often_do_you_drink))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>How often do you drink<sup></sup></label>
                                {{ $user->userHealthScreenTwoDetails->how_often_do_you_drink }}
                            </div>
                        </div>
                        @endif

                        @if(isset($user->userHealthScreenTwoDetails->what_do_you_usually_drink) && !empty($user->userHealthScreenTwoDetails->what_do_you_usually_drink))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>What do you usually drink<sup></sup></label>
                                {{ $user->userHealthScreenTwoDetails->what_do_you_usually_drink }}
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="row cards_box">
                        @if(isset($user->userHealthScreenThreeDetails->do_you_take_any_medication) && !empty($user->userHealthScreenThreeDetails->do_you_take_any_medication))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Do you take any medication<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->do_you_take_any_medication == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->do_you_take_any_medication == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                        @endif
                        

                        @if(isset($user->userHealthScreenOneDetails->medication_name) && !empty($user->userHealthScreenOneDetails->medication_name))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Medication Name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->medication_name }}
                            </div>
                        </div>
                        @endif


                        <div class="col-md-4">
                            <div class="">
                                <label class="block text-sm font-medium mb-1">Medication Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_medication }}" width="90" height="60" alt="Icon 01" />
                            </div>

                        </div>
                    </div>
                    <div class="row cards_box">
                        <!-------------------------------------------------------->
                      
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Have you been recently hospitalized<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->have_you_been_recently_hospitalized == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->have_you_been_recently_hospitalized == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                       


                        @if(isset($user->userHealthScreenOneDetails->prescription_name) && !empty($user->userHealthScreenOneDetails->prescription_name))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>prescription name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->prescription_name }}
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="block text-sm font-medium mb-1">Prescription Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_prescription }}" width="90" height="60" alt="Icon 01" />
                            </div>
                        </div>
                    </div>
                    <div class="row cards_box">
                        <!---------------------------------------------------------------->
                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>do you suffer from asthma<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->do_you_suffer_from_asthma == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->do_you_suffer_from_asthma == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                       


                        @if(isset($user->userHealthScreenOneDetails->asthma_name) && !empty($user->userHealthScreenOneDetails->asthma_name))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Asthma Name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->asthma_name }}
                            </div>
                        </div>
                        @endif


                        <div class="col-md-4">
                            <div class="">
                                <label class="block text-sm font-medium mb-1">Asthma Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_asthma }}" width="90" height="60" alt="Icon 01" />
                            </div>

                        </div>
                    </div>
                    <!----------------------------------------------------------------------------->
                    <div class="row cards_box">
                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>do you have high uric acid<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->do_you_have_high_uric_acid == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->do_you_suffer_from_asthma == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                       


                        @if(isset($user->userHealthScreenOneDetails->uric_acid_name) && !empty($user->userHealthScreenOneDetails->uric_acid_name))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Uric Acid Name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->uric_acid_name }}
                            </div>
                        </div>
                        @endif


                        <div class="col-md-3">
                            <div class="">
                                <label class="block text-sm font-medium mb-1">Uric Acid Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_uricacid }}" width="90" height="60" alt="Icon 01" />
                            </div>
                        </div>
                    </div>
                    <div class="row cards_box">
                        <!--------------------------------------------------------->
                     
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>do you have diabities<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->do_you_have_diabities == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->do_you_have_diabities == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                      


                     
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Diabities Name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->diabities_name }}
                            </div>
                        </div>
                        


                        <div class="col-md-4">
                            <div class="">
                                <label class="block text-sm font-medium mb-1">Diabities Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_hiabitiesprescription }}" width="90" height="60" alt="Icon 01" />
                            </div>
                        </div>
                    </div>
                    <div class="row cards_box">
                        <!-------------------------------------------------->
                      
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>do you have high cholesterol<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->do_you_have_high_cholesterol == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->do_you_have_high_cholesterol == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                       


                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>High cholesterol name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->high_cholesterol_name }}
                            </div>
                        </div>
                        


                        <div class="col-md-4">
                            <div class="">
                                <label class="block text-sm font-medium mb-1">High cholesterol Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_highcholesterol }}" width="90" height="60" alt="Icon 01" />
                            </div>
                        </div>
                    </div>
                    <div class="row cards_box">
                        <!--------------------------------------------------------------->
                      
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>do you suffer from asthma<sup></sup></label>
                                <?php if ($user->userHealthScreenThreeDetails->do_you_suffer_from_high_or_low_blood_pressure == 0) {
                                    echo "No";
                                } else if ($user->userHealthScreenThreeDetails->do_you_suffer_from_high_or_low_blood_pressure == 1) {
                                    echo "Yes";
                                } ?>
                            </div>
                        </div>
                       


                        @if(isset($user->userHealthScreenOneDetails->low_blood_pressure_name) && !empty($user->userHealthScreenOneDetails->low_blood_pressure_name))
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Low Blood Pressure Name<sup></sup></label>
                                {{ $user->userHealthScreenOneDetails->low_blood_pressure_name }}
                            </div>
                        </div>
                        @endif


                        <div class="col-md-4">
                            <div class="">
                                <label class="block text-sm font-medium mb-1">Low Blood Images</label>
                                <img class="ml-1 img_circle" src="{{ $user->customer_lowblood }}" width="90" height="60" alt="Icon 01" />
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
                <br></br>

                <?php if ($user->profile) : ?>
                    <h5>Profile Details</h5>

                    <div class="row cards_box">
                        @if(isset($user->profile->gender) && !empty($user->profile->gender))

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Gender<sup></sup></label>
                                {{$user->profile->gender}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile->age) && !empty($user->profile->age))

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Age<sup></sup></label>
                                {{$user->profile->age}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile->height) && !empty($user->profile->height))

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Height<sup></sup></label>
                                {{$user->profile->height}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile->weight) && !empty($user->profile->weight))

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Weight<sup></sup></label>
                                {{$user->profile->weight}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile->height_type) && !empty($user->profile->height_type))

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Height Type<sup></sup></label>
                                {{$user->profile->height_type}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile->weight_type) && !empty($user->profile->weight_type))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Weight Type<sup></sup></label>
                                {{$user->profile->weight_type}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile_other_details->do_you_have_any_allergies) && !empty($user->profile_other_details->do_you_have_any_allergies))

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Do You Have Any Allergies<sup></sup></label>
                                {{$user->profile_other_details->do_you_have_any_allergies}}
                            </div>
                        </div>
                        @endif
                        @if(isset($user->profile_other_details->do_you_have_any_medical_condition) && !empty($user->profile_other_details->do_you_have_any_medical_condition))


                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Any Medical Condition<sup></sup></label>
                                {{$profile_other_details->do_you_have_any_medical_condition}}
                            </div>
                        </div>
                        @endif

                    </div>
                <?php endif; ?>
                <br></br>
                <d class="row">
                    <div class="col-md-12">
                        <h4>Track List</h4>
                        <table style="width:100%">
                            <tr>
                                <th>IMEI Number- @forelse($track as $tracks) {{ $tracks->imiei }} <?php echo ","; ?> @empty No IMEI Number found.@endforelse</th>
                            </tr>

                        </table>
                    </div>
            </div>
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