<!DOCTYPE html>
<html lang="en">

<?php echo $__env->make('auth.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>

    <div class="contianer">

        <div class="login-wrapper">
        <?php echo $__env->make('auth.partials.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>

            
        </div>

        <?php echo $__env->make('auth.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>



</body>

</html><?php /**PATH /home/u932153640/domains/swasthfit.in/public_html/resources/views/auth/partials/app.blade.php ENDPATH**/ ?>