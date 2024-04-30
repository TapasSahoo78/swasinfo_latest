@extends('vendor.layouts.app')
@section('pagetitlesection', __('Dashboard'))
@section('content')
<div class="container-fluid pt-4 px-4">
    <ul class="breadcrumb">
       <li><a href="#">Dashboard</a></li>
       <li>Manage Inventory</li>
    </ul>
    <!-- Inventory Section Start -->
    <div class="inventory-section">
       <h4>Manage All Inventory</h4>
       <div class="manage-nventorycard mb-3">
          <div class="manage-nventoryleft">
             <div class="search-product">
                <div class="search-icon"><img src="img/search-icon.png" alt=""></div>
                <input class="form-control"  placeholder="Search product. . .">
             </div>
             <a href="#" class="cancelpro-btn"><i class="fa" aria-hidden="true"><img src="img/Dates-icon.png" alt=""></i> Select Dates</a>
             <a href="#" class="cancelpro-btn"><i class="fa" aria-hidden="true"><img src="img/Filters-icon.png" alt=""></i> Filters</a>
          </div>
          <a href="#" class="add-variantbtn"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
       </div>
       <div class="bg-white text-left border rounded overflow-hidden recentsales">
          <div class="table-responsive">
             <table class="table table-hover">
                <thead>
                   <tr class="text-dark">
                      <th scope="col"><input class="form-check-input" type="checkbox"> ID</th>
                      <th scope="col">Product Name</th>
                      <th scope="col">Total QTY</th>
                      <th scope="col">Buy Price</th>
                      <th scope="col">Sell Price</th>
                      <th scope="col">Location</th>
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
                         <p>55</p>
                      </td>
                      <td>
                         <p>$121.00</p>
                      </td>
                      <td>
                         <p>$121.00</p>
                      </td>
                      <td>
                         <p>USA</p>
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
                            <div class="tb-textimg"> <img class="" src="img/tb-Img02.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Smartwatch E2</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>100</p>
                      </td>
                      <td>
                         <p>$590.00</p>
                      </td>
                      <td>
                         <p>$590.00</p>
                      </td>
                      <td>
                         <p>USA</p>
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
                         <p>24</p>
                      </td>
                      <td>
                         <p>$125.00</p>
                      </td>
                      <td>
                         <p>$125.00</p>
                      </td>
                      <td>
                         <p>USA</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#301901</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img04.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Headphone G1 Pro</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>44</p>
                      </td>
                      <td>
                         <p>$348.00</p>
                      </td>
                      <td>
                         <p>$348.00</p>
                      </td>
                      <td>
                         <p>USA</p>
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
                               <h6>Puma Shoes</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>45</p>
                      </td>
                      <td>
                         <p>$234.00</p>
                      </td>
                      <td>
                         <p>$234.00</p>
                      </td>
                      <td>
                         <p>USA</p>
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
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img06.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Imac 2021</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>200</p>
                      </td>
                      <td>
                         <p>$760.00</p>
                      </td>
                      <td>
                         <p>$760.00</p>
                      </td>
                      <td>
                         <p>USA</p>
                      </td>
                      <td>
                         <div class="action-card"><a class="#" href=""><img class="" src="img/e-icon.png" alt="">  </a>
                            <a class="#" href=""><img class="" src="img/pen.png" alt="">  </a>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td><input class="form-check-input" type="checkbox"> <a href="#">#301002</a> </td>
                      <td>
                         <div class="tb-text">
                            <div class="tb-textimg"> <img class="" src="img/Inventory-Img07.png" alt=""></div>
                            <div class="tbtext">
                               <h6>Skincare</h6>
                            </div>
                         </div>
                      </td>
                      <td>
                         <p>350</p>
                      </td>
                      <td>
                         <p>$123.00</p>
                      </td>
                      <td>
                         <p>$123.00</p>
                      </td>
                      <td>
                         <p>USA</p>
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
