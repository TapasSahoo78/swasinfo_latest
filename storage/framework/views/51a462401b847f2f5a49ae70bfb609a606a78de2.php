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
                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="<?php echo e(asset('assets/img/icon4.svg')); ?>" alt="">
                        </span>
                        <h3><?php echo e($totaluser ?? 0); ?></h3>
                        <p>Total Products</p>
                        <img src="<?php echo e(asset('assets/img/icon5.svg')); ?>" alt="">
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="<?php echo e(asset('assets/img/icon4.svg')); ?>" alt="">
                        </span>
                        <h3><?php echo e($totalcustomer ?? 0); ?></h3>
                        <p>Total Stocks</p>
                        <img src="<?php echo e(asset('assets/img/icon5.svg')); ?>" alt="">
                    </div>
                </div>


                

            </div>
            <!-- loan-card -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </div>

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

<?php echo $__env->make('vendor.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/vendor/pages/dashboard.blade.php ENDPATH**/ ?>