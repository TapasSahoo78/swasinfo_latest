<?php $__env->startPush('style'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-5 dash_mob">

        <div class="container-fluid">
            <form action="<?php echo e(route('vendor.other.product.add')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-10">
                        <div class="row">
                            <div class="row col-12">
                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <select name="category" id="" class="form-control">
                                            <?php echo e(getAllCategory('')); ?>

                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter Product Name"
                                            aria-label="Enter Product Name" name="product_name"
                                            aria-describedby="button-addon2">
                                    </div>
                                    <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <select name="unit" id="" class="form-control">
                                            <?php echo e(getAllUnit('')); ?>

                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control float-number" placeholder="Enter Quantity"
                                            aria-label="Enter Quantity" name="quantity" aria-describedby="button-addon2">
                                    </div>
                                    <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="row col-12">
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Price"
                                                aria-label="Enter Price" name="price" aria-describedby="button-addon2">
                                        </div>
                                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Selling Price"
                                                aria-label="Enter Selling Price" name="selling_price"
                                                aria-describedby="button-addon2">
                                        </div>
                                        <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter SKU Number"
                                                aria-label="Enter SKU Number" name="sku_number"
                                                aria-describedby="button-addon2">
                                        </div>
                                        <?php $__errorArgs = ['sku_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="brand"
                                                placeholder="Enter Brand Name" aria-label="Enter Brand Name"
                                                aria-describedby="button-addon2">
                                        </div>
                                        <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="row col-12">
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="product_img[]"
                                                aria-label="Enter Price" aria-describedby="button-addon2" multiple>
                                        </div>
                                        <?php $__errorArgs = ['product_img'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Enter Stock"
                                                aria-label="Enter Stock" name="stock" aria-describedby="button-addon2">
                                        </div>
                                        <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-xs mt-1 text-rose-500 text-danger">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-12">
                                        <textarea name="description" id="" cols="30" rows="5" class="form-control"
                                            placeholder="Enter Description"></textarea>
                                    </div>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-xs mt-1 text-rose-500 text-danger">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-12 mt-1 mb-5">
                                <button type="submit" class="btn btn-primary">Add</button>
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

            </form>
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

<?php echo $__env->make('vendor.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/vendor/pages/product/create.blade.php ENDPATH**/ ?>