<?php $__env->startPush('style'); ?>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('pagetitlesection'); ?>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link custom-cumb"><?php echo e(__('Dashboard')); ?></a>
    </li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-dashboard'])): ?>
            <div class="row">

                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                    <span>
                            <img src="<?php echo e(asset('assets/img/icon4.svg')); ?>" alt="">
                        </span>
                        <h3><?php echo e($totaluser); ?></h3>
                        <p>Total Users</p>
                        <img src="<?php echo e(asset('assets/img/icon5.svg')); ?>" alt="">
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                        <span>
                            <img src="<?php echo e(asset('assets/img/icon4.svg')); ?>" alt="">
                        </span>
                        <h3><?php echo e($totalcustomer); ?></h3>
                        <p>Total Customers</p>
                        <img src="<?php echo e(asset('assets/img/icon5.svg')); ?>" alt="">
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                    <span>
                            <img src="<?php echo e(asset('assets/img/icon4.svg')); ?>" alt="">
                        </span>
                        <h3><?php echo e($totaldoctor); ?></h3>
                        <p>Total Doctor</p>
                        <img src="<?php echo e(asset('assets/img/icon5.svg')); ?>" alt="">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 dashcard_mob">
                    <div class="custom-dasboard-card">
                    <span>
                            <img src="<?php echo e(asset('assets/img/icon4.svg')); ?>" alt="">
                        </span>
                        <h3><?php echo e($totaltrainers); ?></h3>
                        <p>Total Manage Trainers & Dietitian</p>
                        <img src="<?php echo e(asset('assets/img/icon5.svg')); ?>" alt="">
                    </div>
                </div>

            </div>
            <?php endif; ?>
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u932153640/domains/swasthfit.in/public_html/resources/views/admin/dashboard/dashboard.blade.php ENDPATH**/ ?>