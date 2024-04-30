@extends('vendor.layouts.app')
@section('pagetitlesection', __('Dashboard'))
@section('content')
    <div class="container-fluid pt-4 px-4">
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li>Advertising</li>
        </ul>
        <!-- Tab Start -->
        <!-- Sale & Revenue Start -->
        <div class="container-fluid advertising-page">
            <div class="row">
                <div class="advertising-header">
                    <from>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Ad type</label>
                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected="">Slider 1</option>
                                        <option value="1">Slider 2</option>
                                        <option value="2">Slider 3</option>
                                        <option value="3">Slider 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check col-lg-3 ">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Front banners (8)
                                </label>
                            </div>
                            <div class="form-check col-lg-3">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2" checked="">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Short square banners (8)
                                </label>
                            </div>
                        </div>
                    </from>
                </div>
            </div>
            <!-- Sale & Revenue End -->
            <div class="bg-white rounded p-3 mb-3">
                <div class="show-exp">
                    <p><a href="#">Show Example</a></p>
                </div>
                <form class="category-form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                            <label for="" class="form-label">Select Category</label>
                            <div class="addcategcard">
                                <select class="form-select">
                                    <option selected="">Select a category</option>
                                </select>

                                <a href="#" class="addcateg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add
                                    Category</a>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 mb-2">
                            <label for="" class="form-label">Select Products</label>
                            <div class="addcategcard">
                                <select class="form-select">
                                    <option selected="">Select a category</option>
                                </select>
                                <a href="#" class="addcateg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add
                                    More</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="photocard-box">
                                <div class="photocard-header">
                                    <h5> Photo </h5>
                                </div>
                                <div class="photocard">
                                    <div class="photocard-icon"><img src="img/photocard-icon.png" alt=""></div>
                                    <p>Drag and drop image here, or click add image</p>
                                    <a href="#" class="addimage-btn">Import File <input type="file" id="myFile"
                                            name="filename2"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="photocard-box">
                                <div class="photocard-header">
                                    <h5> Video </h5>
                                </div>
                                <div class="photocard">
                                    <div class="photocard-icon"><img src="img/photocard-icon.png" alt=""></div>
                                    <p>Drag and drop image here, or click add image</p>
                                    <a href="#" class="addimage-btn">Import File <input type="file" id="myFile"
                                            name="filename2"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <label>Campaign Start Date</label>
                            <div id="datepicker" class="input-group">
                                <input type="date" class="form-control" id="exampleInputEmail1" placeholder="">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <label>Campaign End Date</label>
                            <div id="datepicker" class="input-group">
                                <input type="date" class="form-control" id="exampleInputEmail1" placeholder="">
                            </div>
                        </div>

                        <!-- <div class="col-lg-6 col-md-6 col-12">
                       <label>Select Date: </label>
                       <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                          <input class="form-control" type="text" readonly />
                          <span class="input-group-addon"><i class="fa-light fa-calendar-days"></i></span>
                       </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                       <label>Select Date: </label>
                       <div id="datepicker2" class="input-group date" data-date-format="mm-dd-yyyy">
                          <input class="form-control" type="text" readonly />
                          <span class="input-group-addon"><i class="fa-light fa-calendar-days"></i></span>
                       </div>
                    </div> -->
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <label for="exampleInputEmail1" class="form-label">Bid Price</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Starting from ₹1">
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="alert alert-danger" role="alert">
                                Min. Bid Range from 500 Rs
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md- col-12 form-check">
                            <div class="acceptd-text">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">I have read and accepted the
                                    terms and conditions of the <a href="#">Swaasthfiit Services Business
                                        Solutions
                                        Agreement</a></label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="invioce-row">
                            <div class="bg-white text-left border rounded overflow-hidden pricecard py-4 px-3 mb-3">
                                <h5>Invoice</h5>
                                <div class="pricecard-text">
                                    <p>Invoice No </p>
                                    <p class="red-text-colr">#5355619</p>
                                </div>
                                <div class="pricecard-text">
                                    <p>Price</p>
                                    <p>20,000</p>
                                </div>
                                <div class="pricecard-text">
                                    <p>GST</p>
                                    <p>GST</p>
                                </div>
                                <div class="pricecard-text">
                                    <p><b>Total Amount</b></p>
                                    <p><b>20,500</b></p>
                                </div>
                            </div>
                        </div>
                        <br clear="all">
                        <a href="#" class="make-pay">Make Payment</a>
                    </div>
                </div>
                <!-- Tab Start End -->
            </div>
            <!-- Sale & Revenue End -->
        </div>
    </div>
@endsection
