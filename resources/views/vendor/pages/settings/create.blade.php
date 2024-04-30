@extends('vendor.layouts.app')
@section('pagetitlesection', __('Dashboard'))
@section('content')
<div class="container-fluid pt-4 px-4">
    <ul class="breadcrumb">
       <li><a href="#">Dashboard</a></li>
       <li>Setting</li>
    </ul>
    <!-- Tab Start -->
    <div class="tabcard">
       <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
             <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-home"
                aria-selected="true">Profile</button>
             <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                data-bs-target="#pills-bank" type="button" role="tab" aria-controls="pills-profile"
                aria-selected="false">Bank Details</button>
             <button class="nav-link" id="pills-tax-tab" data-bs-toggle="pill"
                data-bs-target="#pills-tax" type="button" role="tab" aria-controls="pills-contact"
                aria-selected="false">Tax Details</button>
             <button class="nav-link" id="pills-pickup-tab" data-bs-toggle="pill"
                data-bs-target="#pills-pickup" type="button" role="tab" aria-controls="pills-contact"
                aria-selected="false">Pickup Address</button>
             <button class="nav-link" id="pills-password-tab" data-bs-toggle="pill"
                data-bs-target="#pills-password" type="button" role="tab" aria-controls="pills-contact"
                aria-selected="false">Change Password</button>
          </div>
       </nav>
       <div class="tab-content pt-3" id="pills-tabContent ">
          <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
             aria-labelledby="pills-home-tab">
             <h4>Basic Information</h4>
             <div class="bg-white bg-white rounded p-3 mb-3 setting-page">
                <div class="row">
                   <div class="col-lg-5 col-md-5 col-12">
                      <div class="bg-white-leftPart">
                         <div class="usercard-section">
                            <div class="userbg"><img class="" src="img/userbg.png" alt=""></div>
                            <div class="usercard">
                               <div class="usercardimg"><img class="" src="img/Avatar.png" alt="">
                               </div>
                               <h6>Esther Howard</h6>
                            </div>
                            <div class="customercard-sect">
                               <div class="customercard-icon"><img class="" src="img/Vector-id.png"
                                  alt=""></div>
                               <div class="customercard-text">
                                  <p>Customer ID<br>
                                     <span>ID-011221</span>
                                  </p>
                               </div>
                            </div>
                            <div class="customercard-sect">
                               <div class="customercard-icon"><img class=""
                                  src="img/fi-sr-envelope.png" alt=""></div>
                               <div class="customercard-text">
                                  <p>E-mail<br>
                                     <span>lindablair@mail.com</span>
                                  </p>
                               </div>
                            </div>
                            <div class="customercard-sect">
                               <div class="customercard-icon"><img class=""
                                  src="img/fi-sr-smartphone.png" alt=""></div>
                               <div class="customercard-text">
                                  <p>Phone Number<br>
                                     <span>050 414 8778</span>
                                  </p>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-7 col-md-7 col-12">
                      <div class="bg-white-rightPart">
                         <form>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Frist
                                  Name</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="Frist Name">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Last
                                  Name</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="Last Name">
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-12">
                                  <label for="exampleInputPassword1"
                                     class="form-label">Email</label>
                                  <input type="email" class="form-control"
                                     id="exampleInputPassword1">
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Phone
                                  Number</label>
                                  <input type="number" class="form-control"
                                     id="exampleInputEmail1" aria-describedby="emailHelp"
                                     placeholder="+91 00000000">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1"
                                     class="form-label">Gender</label>
                                  <select class="form-select mb-3"
                                     aria-label="Default select example">
                                     <option selected="">Male</option>
                                     <option value="1">Female</option>
                                  </select>
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-12">
                                  <label for="exampleInputPassword1"
                                     class="form-label">Bio</label>
                                  <textarea class="form-control" placeholder="Bio"
                                     style="height: 100px;">
                                  </textarea>
                               </div>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="tab-pane fade" id="pills-bank" role="tabpanel" aria-labelledby="pills-profile-tab">
             <h4>Bank Information</h4>
             <div class="bg-white bg-white rounded p-3 mb-3 setting-page">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-12">
                      <div class="bg-white-rightPart">
                         <form>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Account
                                  Holders Name</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp"
                                     placeholder="Account Holders Name">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Account
                                  Number</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="Account Number">
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">IFSC
                                  Code</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="IFSC Code">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1"
                                     class="form-label">Country</label>
                                  <select class="form-select mb-3"
                                     aria-label="Default select example">
                                     <option selected="">India</option>
                                     <option value="1">Uk</option>
                                  </select>
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Mobile
                                  Number</label>
                                  <input type="number" class="form-control"
                                     id="exampleInputEmail1" aria-describedby="emailHelp"
                                     placeholder="+91 00000000">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Email
                                  ID</label>
                                  <input type="email" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="Email ID">
                               </div>
                            </div>
                            <div class="footerbtn-section">
                               <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                  aria-hidden="true"></i> Save </a>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="tab-pane fade" id="pills-tax" role="tabpanel" aria-labelledby="pills-contact-tab">
             <h4>GST Information</h4>
             <div class="bg-white bg-white rounded p-3 mb-3 setting-page">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-12">
                      <div class="bg-white-rightPart">
                         <form>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Enter GST
                                  Number</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp"
                                     placeholder="Account Holders Name">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">GST Ref.
                                  ID</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="Account Number">
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Business
                                  Name</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="IFSC Code">
                               </div>
                               <div class="col-lg-6 col-md-6 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Legal
                                  Business Name</label>
                                  <input type="text" class="form-control" id="exampleInputEmail1"
                                     aria-describedby="emailHelp" placeholder="IFSC Code">
                               </div>
                            </div>
                            <div class="footerbtn-section">
                               <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                  aria-hidden="true"></i> Save </a>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="tab-pane fade" id="pills-pickup" role="tabpanel"
             aria-labelledby="pills-contact-tab">
             <h4>Pickup Address</h4>
             <div class="bg-white bg-white rounded p-3 mb-3 setting-page">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-12">
                      <div class="bg-white-rightPart">
                         <form>
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-12">
                                  <label for="exampleInputEmail1" class="form-label">Pickup
                                  Address <span><a href="#"><img src="img/pen.png" alt="pen"></a></span></label>
                                  <textarea class="form-control" placeholder="Pickup Address"
                                     id="floatingTextarea" style="height:200px;"></textarea>
                               </div>
                            </div>
                            <div class="footerbtn-section">
                               <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                  aria-hidden="true"></i> Save </a>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="tab-pane fade" id="pills-password" role="tabpanel"
             aria-labelledby="pills-contact-tab">
             <h4>Security</h4>
             <div class="bg-white bg-white rounded p-3 mb-3 setting-page">
                <div class="row">
                   <div class="col-lg-12 col-md-12 col-12">
                      <div class="bg-white-rightPart">
                         <form>
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-12">
                                  <label for="inputPassword1" class="form-label">Current
                                  Password</label>
                                  <input type="password" class="form-control" id="inputPassword1"
                                     placeholder="*************">
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-12">
                                  <label for="inputPassword2" class="form-label">New
                                  Password</label>
                                  <input type="password" class="form-control" id="inputPassword2"
                                     placeholder="*************">
                               </div>
                            </div>
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-12">
                                  <label for="inputPassword3" class="form-label">Confirm
                                  Password</label>
                                  <input type="password" class="form-control" id="inputPassword3"
                                     placeholder="*************">
                               </div>
                            </div>
                            <div class="footerbtn-section">
                               <a href="#" class="savepro-btn"><i class="fa fa-floppy-o"
                                  aria-hidden="true"></i> Save </a>
                            </div>
                         </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <!-- Tab Start End -->
 </div>
@endsection
