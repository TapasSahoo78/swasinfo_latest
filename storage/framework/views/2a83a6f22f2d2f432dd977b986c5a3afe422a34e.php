<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
            

            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-12 mt-1 mb-5">
                                <div class="input-group mb-3">
                                    <select name="" id="" class="form-control">
                                        <option value="">Select Product</option>
                                        <option value="1">Product 1</option>
                                        <option value="2">Product 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-1 mb-5">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter Stock"
                                        aria-label="Enter Stock" aria-describedby="button-addon2">
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-1 mb-5">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                <div class="col-2 p-8">
                    <img src="<?php echo e(asset('assets/images/office.jpg')); ?>" alt="">
                    <br><br><br>
                    <img src="<?php echo e(asset('assets/images/office.jpg')); ?>" alt="">
                    <br><br><br>
                    <img src="<?php echo e(asset('assets/images/office.jpg')); ?>" alt="">
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
    <script src="<?php echo e(asset('assets/admin/js/editor.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('vendor.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/vendor/pages/stock/create.blade.php ENDPATH**/ ?>