<?php
    $success = Session::get('success');
    $errors = Session::get('error');
    $info = Session::get('info');
    $warnings = Session::get('warning');
?>

<?php if($success): ?>
    <?php $__currentLoopData = $success; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="flashstatus d-none">SUCCESS</span>
        <span class="flashmessage d-none"><?php echo e($value); ?></span>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(session('status')): ?>
    <span class="flashstatus d-none">SUCCESS</span>
    <span class="flashmessage d-none"><?php echo e(session('status')); ?></span>
<?php endif; ?>


<?php if($errors): ?>
	<?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="flashstatus d-none">ERROR</span>
        <span class="flashmessage d-none"><?php echo e($value); ?></span>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($info): ?>
	<?php $__currentLoopData = $info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="flashstatus d-none">INFORMATION</span>
        <span class="flashmessage d-none"><?php echo e($value); ?></span>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($warnings): ?>
	<?php $__currentLoopData = $warnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="flashstatus d-none">WARNING</span>
        <span class="flashmessage d-none"><?php echo e($value); ?></span>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home/u932153640/domains/swasthfit.in/public_html/resources/views/admin/layouts/partials/flash.blade.php ENDPATH**/ ?>