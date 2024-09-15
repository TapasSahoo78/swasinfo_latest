<?php $__env->startPush('style'); ?>
    

    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");

        :root {
            --primary: #333;
            --secondary: #333;
            --errorColor: red;
            --stepNumber: 6;
            --container-customWidth: 600px;
            --bgColor: #333;
            --inputBorderColor: lightgray;
        }


        ::selection {
            color: #fff;
            background: var(--primary);
        }

        .container-custom {
            background: #fff;
            text-align: center;
            border-radius: 5px;
        }

        .container-custom header {
            font-size: 35px;
            font-weight: 600;
            margin: 0 0 30px 0;
        }

        .container-custom .form-outer {
            width: 100%;
            overflow: hidden;
        }

        .container-custom .form-outer form {
            display: flex;
            width: calc(100% * var(--stepNumber));
        }

        .form-outer form .page {
            width: calc(100% / var(--stepNumber));
            transition: margin-left 0.3s ease-in-out;
        }

        form .page .field button {
            width: 100%;
            height: calc(100% + 5px);
            border: none;
            background: var(--secondary);
            margin-top: -20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.5s ease;
        }

        form .page .field button {
            width: 100%;
            height: calc(100% + 5px);
            border: none;
            background: #f9d95c;
            margin-top: -20px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: 0.5s ease;
            color: #000;
            font-weight: 500;
        }

        form .page .btns button {
            margin-top: -20px !important;
        }

        form .page .btns button.prev {
            margin-right: 3px;
            font-size: 17px;
        }

        form .page .btns button.next {
            margin-left: 3px;
        }

        .container-custom .steps-progress-bar {
            display: flex;
            margin: 40px 0;
            user-select: none;
        }

        .container-custom .steps-progress-bar .step {
            text-align: center;
            width: 100%;
            position: relative;
        }

        .container-custom .steps-progress-bar .step p {
            font-weight: 500;
            font-size: 18px;
            color: #000;
            margin-bottom: 8px;
        }

        .steps-progress-bar .step .bullet {
            height: 30px;
            width: 30px;
            border: 2px solid #000;
            display: inline-block;
            border-radius: 50%;
            position: relative;
            transition: 0.2s;
            font-weight: 500;
            font-size: 17px;
            line-height: 25px;
        }

        .steps-progress-bar .step .bullet.active {
            border-color: #f9d95c;
            background: #f9d95c;
        }

        .steps-progress-bar .step .bullet span {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .steps-progress-bar .step .bullet.active span {
            display: none;
        }

        .steps-progress-bar .step .bullet:before,
        .steps-progress-bar .step .bullet:after {
            position: absolute;
            content: "";
            bottom: 11px;
            right: -102px;
            height: 3px;
            width: 91px;
            background: #262626;
        }

        .steps-progress-bar .step .bullet.active:after {
            background: #f9d95c;
            transform: scaleX(0);
            transform-origin: left;
            animation: animate 0.3s linear forwards;
        }

        .plus_btn {
            display: flex;
            justify-content: flex-end;
        }

        .plus_btn button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }

        @keyframes animate {
            100% {
                transform: scaleX(1);
            }
        }

        .steps-progress-bar .step:last-child .bullet:before,
        .steps-progress-bar .step:last-child .bullet:after {
            display: none;
        }

        .steps-progress-bar .step p.active {
            color: var(--primary);
            transition: 0.2s linear;
        }

        .steps-progress-bar .step .check {
            position: absolute;
            left: 50%;
            top: 70%;
            font-size: 15px;
            transform: translate(-50%, -50%);
            display: none;
        }

        .steps-progress-bar .step .check.active {
            display: block;
            color: #fff;
        }

        @media screen and (max-width: 660px) {

            .steps-progress-bar .step p {
                display: none;
            }

            .steps-progress-bar .step .bullet::after,
            .steps-progress-bar .step .bullet::before {
                display: none;
            }

            .steps-progress-bar .step .bullet {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .steps-progress-bar .step .check {
                position: absolute;
                left: 50%;
                top: 50%;
                font-size: 15px;
                transform: translate(-50%, -50%);
                display: none;
            }

            .step {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }




        .page .single-input label {
            display: block;
            margin: 10px 0px;
        }


        .page .single-input input,
        .page .single-input select {
            margin-bottom: 0px;
        }

        .page .single-input textarea {
            width: 100%;
        }

        .add-more-field {
            border: 1px solid #0000004a;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            margin-bottom: 30px;
        }

        .btns-actions-postion {
            position: absolute;
            bottom: -23px;
            right: 20px;
        }

        .btns-actions-postion button {
            border: 1px solid #f9d95c;
            background: #f9d95c;
            color: #fff;
            border-radius: 50%;
            height: 36px;
            width: 36px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('pagetitlesection'); ?>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link custom-cumb"><?php echo e(__('Product List')); ?></a>
    </li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h1 class="m-0 text-dark">No of Product : <?php echo e(count($listCategories)); ?></h1>
                    </div><!-- /.col -->
                    
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Recent Assets -->
                <div class="row">
                    <div class="col-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <table class="table  text-nowrap custom-data-table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Category Name</th>
                                        <th>Price</th>
                                        <th>Color</th>
                                        <th>Best Sales</th>
                                        <th>Best Deal</th>
                                        <th>Added By</th></th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $listCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($data->title ? $data->title : '---'); ?></td>
                                             <td><?php echo e($data->category->name  ? $data->category->name  : '---'); ?></td>
                                             <td><?php echo e($data->price  ? $data->price  : '---'); ?></td>
                                             <td><?php echo e($data->color  ? $data->color  : '---'); ?></td>
                                             <td>
                                                <?php switch($data->is_sales):
                                                    case (1): ?>
                                                        <a href="javascript:void(0)" data-value="0" data-table="products"
                                                            data-message="inactive" data-uuid="<?php echo e($data->uuid); ?>"
                                                            class="active-status changeSales ">Yes</a>
                                                    <?php break; ?>

                                                    <?php case (0): ?>`
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="<?php echo e($data->uuid); ?>"
                                                            data-table="products" data-message="active"
                                                            class="changeSales ">No</a>
                                                    <?php break; ?>

                                                    <?php default: ?>
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                <?php endswitch; ?>
                                            </td>
                                            <td>
                                                <?php switch($data->is_deal):
                                                    case (1): ?>
                                                        <a href="javascript:void(0)" data-value="0" data-table="products"
                                                            data-message="inactive" data-uuid="<?php echo e($data->uuid); ?>"
                                                            class="active-status changeDeal ">Yes</a>
                                                    <?php break; ?>

                                                    <?php case (0): ?>
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="<?php echo e($data->uuid); ?>"
                                                            data-table="products" data-message="active"
                                                            class="changeDeal ">No</a>
                                                    <?php break; ?>

                                                    <?php default: ?>
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                <?php endswitch; ?>
                                            </td>
                                            <td><?php echo e($data->createdByUser->first_name  ? $data->createdByUser->first_name  : '---'); ?> <?php echo e($data->createdByUser->last_name  ? $data->createdByUser->last_name  : '---'); ?></td>
                                            <td><?php echo e(date('d-m-Y', strtotime($data->created_at))); ?></td>
                                            <td>
                                                <?php switch($data->is_active):
                                                    case (1): ?>
                                                        <a href="javascript:void(0)" data-value="0" data-table="products"
                                                            data-message="inactive" data-uuid="<?php echo e($data->uuid); ?>"
                                                            class="active-status changeStatus ">Active</a>
                                                    <?php break; ?>

                                                    <?php case (0): ?>
                                                        <a href="javascript:void(0)" data-value="1" data-uuid="<?php echo e($data->uuid); ?>"
                                                            data-table="products" data-message="active"
                                                            class="inactive-status changeStatus ">Inactive</a>
                                                    <?php break; ?>

                                                    <?php default: ?>
                                                        <a href="javascript:void(0)"
                                                            class="badge badge-danger text-dark">Deleted</a>
                                                <?php endswitch; ?>
                                            </td>
                                            
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <img src="<?php echo e(asset('assets/img/three-dot-btn.png')); ?>"
                                                            alt="">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="<?php echo e(route('admin.product.edit', $data->uuid)); ?>">Edit</a>
                                                            <a class="dropdown-item deleteData" data-table="plan_categories"
                                                                data-uuid="<?php echo e($data->uuid); ?>"
                                                                href="javascript:void(0)">Delete</a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No
                                                    Data Yet</td>
                                            </tr>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
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

        <!-- add baranch form -->




        <!-- add baranch form-end-->

        <!-- /.content-wrapper -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('scripts'); ?>
        
        
        
        

        <script src="<?php echo e(asset('assets/admin/js/datatableajax.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/admin/js/customer.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/admin/js/customer-kyc-verification.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/admin/js/customer-kyc-document-verification.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/admin/product/list.blade.php ENDPATH**/ ?>