@extends('vendor.layouts.app')
@section('pagetitlesection', __('Dashboard'))
@section('content')
    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-white rounded d-flex align-items-center justify-content-start gap-1 p-4">
                    <div class="icon-01"><img src="{{ asset('assets_f/img/icon-01.png') }}" alt="">
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">34,945</h4>
                        <p class="mb-2">Total Sales</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-white rounded d-flex align-items-center justify-content-start p-4">
                    <div class="icon-02"><img src="{{ asset('assets_f/img/icon-02.png') }}" alt="">
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">$37,802</h4>
                        <p class="mb-2">Total Income</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-white rounded d-flex align-items-center justify-content-start p-4">
                    <div class="icon-03"><img src="{{ asset('assets_f/img/icon-03.png') }}" alt="">
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">34,945</h4>
                        <p class="mb-2">Orders Paid</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-white rounded d-flex align-items-center justify-content-start p-4">
                    <div class="icon-04"><img src="{{ asset('assets_f/img/icon-04.png') }}" alt="">
                    </div>
                    <div class="ms-3">
                        <h4 class="mb-0">34,945</h4>
                        <p class="mb-2">Total Visitor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->
    <!-- Statistic Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-white text-left rounded p-4 recentsales">
            <div class="mb-4">
                <h6 class="mb-0 w-100">Statistic</h6>
                <p class="mb-0 w-100"><small>Revenue and Sales</small></p>
            </div>
            <canvas id="line-chart"></canvas>
        </div>
    </div>
    <!-- Statistic Sales End -->
    <!-- Statistic Sales Start -->
    <!-- <div class="container-fluid pt-4 px-4">
         <div class="bg-white text-left rounded p-4 recentsales">
             <div class="mb-4">
                 <h6 class="mb-0 w-100">Statistic</h6>
                 <p class="mb-0 w-100"><small>Revenue and Sales</small></p>
             </div>

             <div class="statisticimg">
                 <img src="{{ asset('assets_f/img/statisticimg01.png') }}" alt="">
             </div>


         </div>
         </div> -->
    <!-- Statistic Sales End -->
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-white text-center rounded recentsales">
            <div class="recentorder-card">
                <h6>Recent Orders</h6>
                <div class="recentorder-cardright">
                    <a href="#" class="cancelpro-btn"><i class="fa" aria-hidden="true"><img
                                src="{{ asset('assets_f/img/Filters-icon.png') }}" alt=""></i>
                        Filters</a>
                    <a href="#" class="savepro-btn">See More</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col"><input class="form-check-input" type="checkbox"> Order ID</th>
                            <th scope="col">Product</th>
                            <th scope="col">Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"> <a href="#">#302012</a>
                            </td>
                            <td>
                                <div class="tb-text">
                                    <div class="tb-textimg"><img class=""
                                            src="{{ asset('assets_f/img/tb-Img01.png') }}" alt=""></div>
                                    <div class="tbtext">
                                        <h6>Handmade Pouch<br>
                                            <span> +3 other products</span>
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>1 min ago</p>
                            </td>
                            <td>
                                <div class="tb-text">
                                    <div class="tbtext">
                                        <h6> John Bushmill<br>
                                            <span>Johnb@mail.com</span>
                                        </h6>
                                    </div>
                            </td>
                            <td>
                                <p>$121.00</p>
                            </td>
                            <td>
                                <p>Mastercard</p>
                            </td>
                            <td>
                                <p class="processing-text">Processing</p>
                            </td>
                            <td>
                                <div class="action-card"><a class="#" href=""><img class=""
                                            src="{{ asset('assets_f/img/e-icon.png') }}" alt=""> </a>
                                    <a class="#" href=""><img class=""
                                            src="{{ asset('assets_f/img/pen.png') }}" alt=""> </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"> <a href="#">#302011</a> </td>
                            <td>
                                <div class="tb-text">
                                    <div class="tb-textimg"> <img class=""
                                            src="{{ asset('assets_f/img/tb-Img02.png') }}" alt="">
                                    </div>
                                    <div class="tbtext">
                                        <h6>Smartwatch E2<br>
                                            <span> +1 other products</span>
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>1 min ago</p>
                            </td>
                            <td>
                                <div class="tb-text">
                                    <div class="tbtext">
                                        <h6>Ilham Budi A<br>
                                            <span>ilahmbudi@mail.com</span>
                                        </h6>
                                    </div>
                            </td>
                            <td>
                                <p>$590.00</p>
                            </td>
                            <td>
                                <p>Visa</p>
                            </td>
                            <td>
                                <p class="delivered-text">Delivered</p>
                            </td>
                            <td>
                                <div class="action-card"><a class="#" href=""><img class=""
                                            src="{{ asset('assets_f/img/e-icon.png') }}" alt=""> </a>
                                    <a class="#" href=""><img class=""
                                            src="{{ asset('assets_f/img/pen.png') }}" alt=""> </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"> <a href="#">#302002</a> </td>
                            <td>
                                <div class="tb-text">
                                    <div class="tb-textimg"> <img class=""
                                            src="{{ asset('assets_f/img/tb-Img03.png') }}" alt="">
                                    </div>
                                    <div class="tbtext">
                                        <h6>Smartwatch E1</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>5 hour ago</p>
                            </td>
                            <td>
                                <div class="tb-text">
                                    <div class="tbtext">
                                        <h6>Mohammad Karim<br>
                                            <span>m_karim@mail.com</span>
                                        </h6>
                                    </div>
                            </td>
                            <td>
                                <p>$125.00</p>
                            </td>
                            <td>
                                <p>Transfer</p>
                            </td>
                            <td>
                                <p class="shiped-text">Shiped</p>
                            </td>
                            <td>
                                <div class="action-card"><a class="#" href=""><img class=""
                                            src="{{ asset('assets_f/img/e-icon.png') }}" alt=""> </a>
                                    <a class="#" href=""><img class=""
                                            src="{{ asset('assets_f/img/pen.png') }}" alt=""> </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="paginationcard py-3 px-3">
                <p>Showing 1-10 from 100</p>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->
@endsection
