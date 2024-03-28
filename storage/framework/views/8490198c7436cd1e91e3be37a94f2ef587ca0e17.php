<?php $__env->startSection('pagetitlesection'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Total Stock:
                            <?php echo e(!empty($listProductss) ? $listProductss->count() : 0); ?>

                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-3">
                        <button class="model-slide-btn" id="addbranch-btn"
                            onclick="window.location='<?php echo e(route('vendor.other.stock.add')); ?>'">
                            <span><i class="fa fa-plus" aria-hidden="true"></i></span>
                            Add Stock
                        </button>
                    </div><!-- /.col -->
                    
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Import Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="" id="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btsssssssn-primary">Upload</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="row">
                    <div class="col-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <div class="table table-responsive" style="height:410px">
                                <table class="table  text-nowrap custom-data-table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Product Image</th>
                                            <th>Category</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Selling Price</th>
                                            <th>Stock</th>
                                            <th>Description</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $listProductss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="10" class="text-center">No
                                                    Data Yet</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/vendor/pages/stock/list.blade.php ENDPATH**/ ?>