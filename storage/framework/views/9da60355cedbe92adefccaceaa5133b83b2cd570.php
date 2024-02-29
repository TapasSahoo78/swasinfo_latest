<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-form">
    <div class="login-header">
        <img src="<?php echo e(asset('assets/img/admin-logo.png')); ?>" alt="logo">
        <h3>Let’s <?php echo e(__('Get Started')); ?></h3>
    </div>
    <form action="<?php echo e(route('login')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <input type="text" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Email address')); ?>" required>
        <div class="password-field">
            <input type="password" id="password-login" name="password" placeholder="<?php echo e(__('Password')); ?>" autocomplete="on" required>
            <span class="et-icon" id="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
        </div>

        <a href="<?php echo e(url('password/reset')); ?>" class="forgt-password"><?php echo e(__('Forget Password')); ?>?</a>

        <input type="submit" value="SIGN IN">
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php echo $__env->make('auth.partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/auth/login.blade.php ENDPATH**/ ?>