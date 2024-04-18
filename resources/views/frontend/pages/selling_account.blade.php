@extends('frontend.layouts.main')
@section('content')
    <!-- Connect with Section -->
    <div class="connectwith-section">
        <div class="container">
            <h3>Selling Account</h3>
            {{-- <p>Got a question or feedback? Reach out to us through our 'Contact Us' page. We're here to help!</p> --}}

            @include('frontend.pages.include.message')

            <form method="post" class="connectwith-form" action="{{ route('seller.selling.account') }}" id="customerForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="first">Name*</label>
                            <input id="name" class="form-control" type="text" name="name" placeholder="Name"
                                value="{{ old('name') }}" />
                            @error('name')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="mobile">Mobile*</label>
                            <input id="mobile_number" class="form-control" type="text" name="mobile_number"
                                placeholder="Phone" value="{{ old('mobile_number') }}" />
                            @error('mobile_number')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="email">Email Address*</label>
                            <input id="email" class="form-control" type="text" name="email" placeholder="Email"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Profile Image</label>
                            <input id="trainer_image" class="form-control" type="file" name="trainer_image"
                                accept="image/jpeg,image/png,image/jpg,image/gif" />
                            @error('trainer_image')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="agent">Product Category*</label>
                            <select class="form-control" id="sel1">
                                <option>Become An Agent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="agent">City*</label>
                            <select class="form-control" id="sel1">
                                <option>Become An Agent</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="email">Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password"
                                id="email">
                            @error('password')
                                <span class="text-sm text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>


            </form>

        </div>
    </div>
    <!-- Connect with Section End -->
@endsection
