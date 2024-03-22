
<?php $__env->startSection('content'); ?>
    <!-- Connect with Section -->
    <div class="connectwith-section">
        <div class="container">
            <h3>Connect wi th <span>us</span></h3>
            <p>Got a question or feedback? Reach out to us through our 'Contact Us' page. We're here to help!</p>

            
            <form method="post" action="<?php echo e(route('frontend.contact')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                 <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="first">First Name*</label>
                            <input type="first" class="form-control" placeholder="Revon" id="first" name="first">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="last">Last Name*</label>
                            <input type="last" class="form-control" placeholder="Loddy" id="last" name="last">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="agent">Connecting For*</label>
                            <select class="form-control" id="agent" name="agent">
                                <option value="1">Become An Agent</option>                               
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="mobile">Mobile*</label>
                            <input type="mobile" class="form-control" placeholder="Manager" id="mobile" name="mobile">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="email">Email Address*</label>
                            <input type="email" class="form-control" placeholder="Revonloddy@gmail.com " id="email" name="email">
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group">
                            <label for="comment">Any Words*</label>
                            <textarea class="form-control" rows="4" id="comment" name="comment" placeholder="Starts Type here..."></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12 d-flex justify-content-center">
                        <button type="submit" class="send-btn">Send</button>
                    </div>

                </div>


            </form>

        </div>
    </div>
    <!-- Connect with Section End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webalizer\swasinfo_latest\resources\views/frontend/pages/contact_us.blade.php ENDPATH**/ ?>