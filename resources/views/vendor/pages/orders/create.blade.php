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
       <h4>Manage Order</h4>
       <div class="manage-nventorycard mb-3">
          <div class="manage-nventoryleft">
             <ul>
                <li><a href="#" class="active">All Time</a></li>
                <li><a href="#">12 Months</a></li>
                <li><a href="#">30 Days</a></li>
                <li><a href="#">7 Days</a></li>
                <li><a href="#">24 Hour</a></li>
             </ul>
          </div>
          <div class="manage-nventoryright">
             <a href="#" class="add-variantbtn"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
             <a href="#" class="cancelpro-btn"><i class="fa" aria-hidden="true"><img src="img/Dates-icon.png" alt=""></i> Select Dates</a>
             <a href="#" class="cancelpro-btn"><i class="fa" aria-hidden="true"><img src="img/Filters-icon.png" alt=""></i> Filters</a>
          </div>
       </div>
       <div class="bg-white text-left border rounded overflow-hidden recentsales">
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
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#302012</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/tb-Img01.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Handmade Pouch</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>1 min ago</p>
                      </td>
                      <td>
                         <div class="tb-text">
                            <div class="tbtext">
                               <h6>John Bushmill<br>
                                  <span>Johnb@mail.com</span>
                               </h6>
                            </div>
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
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#302011</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/tb-Img03.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Smartwatch E2</h6>
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
                         </div>
                      </td>
                      <td>
                         <p>$590.00</p>
                      </td>
                      <td>
                         <p>Visa</p>
                      </td>
                      <td>
                         <p class="processing-text">Processing</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#302002</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img03.png" alt=""></div>
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
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#301900</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img05.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Iphone X</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>2 day ago</p>
                      </td>
                      <td>
                         <div class="tb-text">
                            <div class="tbtext">
                               <h6>Josh Adam<br>
                                  <span>josh_adam@mail.com</span>
                               </h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>$607.00</p>
                      </td>
                      <td>
                         <p>Visa</p>
                      </td>
                      <td>
                         <p class="delivered-text">Delivered</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#301881</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img06.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Puma Shoes</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>5 Jan 2023</p>
                      </td>
                      <td>
                         <div class="tb-text">
                            <div class="tbtext">
                               <h6>Sin Tae<br>
                                  <span>sin_tae@mail.com</span>
                               </h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>$234.00</p>
                      </td>
                      <td>
                         <p>Visa</p>
                      </td>
                      <td>
                         <p class="cancelled-text">Cancelled</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#301643</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img07.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Imac 2024</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>1 Jan 2023</p>
                      </td>
                      <td>
                         <div class="tb-text">
                            <div class="tbtext">
                               <h6>Rajesh Masvidal<br>
                                  <span>rajesh_m@mail.com</span>
                               </h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>$760.00</p>
                      </td>
                      <td>
                         <p>Transfer</p>
                      </td>
                      <td>
                         <p class="shiped-text">Shiped</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#301600</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/NikeShoes.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Nike Shoes</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>24 Dec 2022</p>
                      </td>
                      <td>
                         <div class="tb-text">
                            <div class="tbtext">
                               <h6>Fajar Surya<br>
                                  <span>fsurya@mail.com</span>
                               </h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>$400.00</p>
                      </td>
                      <td>
                         <p>Mastercard</p>
                      </td>
                      <td>
                         <p class="delivered-text">Delivered</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
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
    <!-- Inventory Section End -->
 </div>
@endsection
