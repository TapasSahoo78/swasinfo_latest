<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('pagetitlesection'); ?>
    <center>
        <li class="nav-item d-none d-sm-inline-block text-light">
            
            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path fill="#27c624"
                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
            </svg> &nbsp; EMAIL ID & GST &nbsp; - &nbsp;
            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path fill="#27c624"
                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
            </svg> &nbsp; PASSWORD CREATION &nbsp; -
            &nbsp;
            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path fill="#27c624"
                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
            </svg> &nbsp; ONBOARDING DASHBOARD
        </li>
    </center>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
            

            <div class="row">
                <div class="col-12">
                    <fieldset>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Mobile Number"
                                    aria-label="Enter Mobile Number" aria-describedby="button-addon1">
                                <button class="btn btn-success" type="button" id="button-addon1">Send</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter Email Address"
                                    aria-label="Enter Email Address" aria-describedby="button-addon2">
                                <button class="btn btn-success" type="button" id="button-addon2">Send</button>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-12">
                    <fieldset>
                        <p>What are you looking to sell on Flipkart?</p>
                        <div class="row gx-3">
                            <div class="col">
                                <button type="button" class="btn btn-secondary w-100 mb-2">All Categories</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary w-100">Only Books(Pan is mandatory)</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter GSTIN"
                                    aria-label="Enter GSTIN" aria-describedby="button-addon3">
                            </div>
                            <p><strong>GSTIN is required to sell products on Flipkart. You can also share it in the final
                                    step.</strong></p>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Enter PAN number"
                                    aria-label="Enter PAN number" aria-describedby="button-addon4">
                            </div>
                            <p><strong>PAN is required to sell books on Flipkart. You can also share it in the final
                                    step.</strong></p>
                        </div>
                    </fieldset>
                </div>

                <div class="col-12">
                    <fieldset>
                        <p>Add Your e-Signature</p>
                        <div class="row gx-3">
                            <div class="col">
                                <button type="button" class="btn btn-secondary w-100 mb-2">Draw Your e-Signature</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary w-100">Choose your signature</button>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-12">
                    <fieldset>
                        <p>Store & Pickup Details</p>
                        <div class="row gx-3">
                            <div class="col">
                                <label for="fullName">Enter Your Full Name</label>
                                <input type="text" name="fullName" class="form-control" id="fullName"
                                    placeholder="Full Name">
                            </div>
                        </div>
                        <div class="row gx-3">
                            <div class="col">
                                <label for="displayName">Enter Display Name</label>
                                <input type="text" name="displayName" class="form-control" id="displayName"
                                    placeholder="Display Name">
                            </div>
                        </div>
                        <div class="row gx-3">
                            <div class="col">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" cols="10" rows="5" class="form-control" placeholder="Address"></textarea>
                            </div>
                        </div>
                        <div class="row gx-3">
                            <div class="col">
                                <label for="pickupPincode">Pickup Pincode</label>
                                <input type="text" name="pickupPincode" class="form-control" id="pickupPincode"
                                    placeholder="Pickup Pincode">
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-12 mt-4">
                    <p>
                        By continuing, I agree to Flipkart’s <a href="#">Terms of Use</a> & <a
                            href="#">Privacy Policy</a>
                    </p>
                </div>
                <div class="col-12 mt-1 mb-5">
                    <button type="submit" class="btn btn-primary">Register & Continue</button>
                </div>
            </div>


            
        </div>

    </div>
    <!-- loan-card -->
    <!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $("#addbranch-btn").click(function() {
                $("#slide-from-right").addClass("show-side-form");
            });

            $("#close-btn").click(function() {
                $("#slide-from-right").removeClass("show-side-form");
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('vendor.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/vendor/pages/registration.blade.php ENDPATH**/ ?>