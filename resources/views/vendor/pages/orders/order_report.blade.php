@extends('vendor.layouts.app')
@section('pagetitlesection', __('Dashboard'))
@section('content')
    <div class="container-fluid pt-4 px-4">
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Orders</a></li>
            <li>Manage Order</li>
        </ul>
        <!-- Inventory Section Start -->
        <div class="inventory-section">
            <div class="orderreport">
                <h4>Order Report</h4>
                <a href="#" class="print"><img class="" src="img/print-icon.png" alt=""></a>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="bg-white text-left border rounded overflow-hidden recentsales py-4 px-3 mb-3">
                        <div class="orderstop">
                            <h5>Orders ID: #6743</h5>
                            <p class="processing-text">Processing</p>
                        </div>
                        <div class="changesatus-card">
                            <p><i class="fa" aria-hidden="true"><img class="" src="img/calendar.png"
                                        alt=""></i> Feb 16,2024 - Feb 20,2024</p>
                            <select class="form-select">
                                <option selected="">Change Satus</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="billingaddress-card">
                                    <div class="billingaddres-sect">
                                        <div class="billingaddress-icon"><img class="" src="img/bag_handle.png"
                                                alt=""></div>
                                        <div class="billingaddress-cardtext">
                                            <h4>Billing Address</h4>
                                            <p>Shipping: Next express
                                                Payment Method: Paypal
                                                Status: Pending
                                            </p>
                                        </div>
                                    </div>
                                    <a href="#" class="download-info">Download info</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="billingaddress-card">
                                    <div class="billingaddres-sect">
                                        <div class="billingaddress-icon"><img class="" src="img/bag_handle.png"
                                                alt=""></div>
                                        <div class="billingaddress-cardtext">
                                            <h4>Deliver Address</h4>
                                            <p>Address: Santa Ana, illinois 85342 2345 Westheimer Rd. Block 9A
                                            </p>
                                        </div>
                                    </div>
                                    <a href="#" class="download-info">Download info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white text-left border rounded overflow-hidden recentsales mb-3">
                        <div class="product-text">
                            <h5>Order List</h5>
                            <p class="delivered-text">+2 Orders</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">Product</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="tb-text">
                                                <div class="tb-textimg"> <img class="" src="img/Product-Img01.png"
                                                        alt=""></div>
                                                <div class="tbtext">
                                                    <h6>Logic+ Wireless Mouse<br> <span>Black</span></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#">302011</a></td>
                                        <td>
                                            <p>1 pcs</p>
                                        </td>
                                        <td>
                                            <p>$121.00</p>
                                        </td>
                                        <td>
                                            <p>$121.00</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="tb-text">
                                                <div class="tb-textimg"> <img class="" src="img/tb-Img03.png"
                                                        alt=""></div>
                                                <div class="tbtext">
                                                    <h6>Smartwatch E2<br> <span>Black</span></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="#">302011</a></td>
                                        <td>
                                            <p>1 pcs</p>
                                        </td>
                                        <td>
                                            <p>$590.00</p>
                                        </td>
                                        <td>
                                            <p>$590.00</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="bg-white text-left border rounded overflow-hidden pricecard py-4 px-3 mb-3">
                        <h5>Price</h5>
                        <div class="pricecard-text">
                            <p>Subtotal </p>
                            <p>$711.00</p>
                        </div>
                        <div class="pricecard-text">
                            <p>VAT(0)% </p>
                            <p>$0.00</p>
                        </div>
                        <div class="pricecard-text">
                            <p>Shipping Rate</p>
                            <p>$20.00</p>
                        </div>
                        <div class="pricecard-text">
                            <p><b>Total</b></p>
                            <p><b>$731.00</b></p>
                        </div>
                    </div>
                    <div class="bg-white text-left border rounded overflow-hidden pricecard py-4 px-3 mb-3">
                        <h5>Order Summary</h5>
                        <div class="pricecard-text">
                            <p>Order Date</p>
                            <p>04/05/2024</p>
                        </div>
                        <div class="pricecard-text">
                            <p>Payment Method</p>
                            <p>Online</p>
                        </div>
                        <div class="pricecard-text">
                            <p>Shipping Method</p>
                            <p>Cash On Delivery</p>
                        </div>
                    </div>
                    <div class="bg-white text-left border rounded overflow-hidden pricecard py-4 px-3 mb-3">
                        <h5>Invoice</h5>
                        <div class="pricecard-text">
                            <p>Invoice No</p>
                            <p class="">#5355619</p>
                        </div>
                        <div class="pricecard-text">
                            <p>Seller GST</p>
                            <p>12HY87072641Z0</p>
                        </div>
                        <div class="pricecard-text">
                            <p>Purchase GST</p>
                            <p>22HG9838964Z1</p>
                        </div>
                        <a href="#" class="download-info">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inventory Section End -->
    </div>
@endsection
