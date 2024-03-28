<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Canably - Admin Registration</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet"/>
    <link href="<?php echo e(asset('assets/admin/css/vendors/flatpickr.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/admin/style.css')); ?>" rel="stylesheet">
</head>
<style type="text/css">
    .validationBox{
        margin-top: 10px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
</style>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
    <!-- <h1><?php echo e(config('app.name')); ?></h1> -->
        <h1>CANABLY</h1>
    </div>
    <div class="login-box">
        <form class="login-form register-form" action="<?php echo e(route('register')); ?>" method="POST" role="form">
            <?php echo csrf_field(); ?>
            <h3 class="login-head">SIGN UP</h3>
          
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="email">E-Mail Address</label>
                <input id="email" type="hidden" class="form-control disabled" name="email" >
                <span class="separator"> </span>
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="first_name">Name</label>
                <input type="text" class="o-form-element o-custom-input form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" id="name" value="<?php echo e(old('name')); ?>">
                <span class="separator"> </span>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="first_name">User Name</label>
                <input type="text" class="o-form-element o-custom-input form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username" id="user_name" value="<?php echo e(old('username')); ?>">
                <span class="separator"> </span>
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="password">Password</label>
                <input type="password" class="o-form-element o-custom-input form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" id="password">
                <span class="separator"> </span>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group o-form-wrapper">
                <label class="o-custom-label" for="password_confirmation">Confirm Password</label>
                <input type="password" class="o-form-element o-custom-input form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password_confirmation" id="password_confirmation">
                <span class="separator"> </span>
                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block c-solid-btn"> Sign Up </button>
            </div>
            <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>
        </form>
    </div>

    <div class="validationBox">
        <?php if(session()->has('message')): ?>
            <div class="alert alert-success">
                <?php echo e(session()->get('message')); ?>

            </div>
        <?php endif; ?>
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session()->get('error')); ?>

            </div>
        <?php endif; ?>
    </div>
</section>
<script src="<?php echo e(asset('assets/admin/js/jquery-3.2.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/plugins/pace.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/auth/register.blade.php ENDPATH**/ ?>