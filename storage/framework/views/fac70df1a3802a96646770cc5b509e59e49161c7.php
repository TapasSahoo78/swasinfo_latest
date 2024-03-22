<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<?php echo $__env->make('admin.layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body class="hold-transition sidebar-mini">
    <?php echo $__env->make('admin.layouts.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="wrapper">

        <?php echo $__env->make('admin.layouts.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo e(route('admin.home')); ?>" class="brand-link">
                <img src="<?php echo e(asset('assets/img/admin-logo.png')); ?>" alt="" class="brand-image">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
             <?php echo $__env->make('admin.layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            </div>
            <!-- /.sidebar -->
        </aside>

        <?php echo $__env->yieldContent('content'); ?>



    </div>


    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->

    <?php echo $__env->make('admin.layouts.partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php echo $__env->yieldPushContent('scripts'); ?>



</body>

</html>
<?php /**PATH C:\xampp\htdocs\webalizer\swasinfo_latest\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>