<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light topbar_mob">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <?php echo $__env->yieldContent('pagetitlesection'); ?>

    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->
    <ul class="navbar-nav navprofile_mob">




        <li class="nav-item dropdown">
            <a class="nav-link height-unset" data-toggle="dropdown" href="#">
                <div class="profile-box">
                    <div class="img">
                        <img src="<?php echo e(auth()->user()?->profile_picture); ?>" alt="">
                    </div>
                    <p><?php echo e(auth()->user()->username ?? auth()->user()?->first_name); ?></p>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right custom-dropdown">

                <a href="<?php echo e(route('admin.profile')); ?>">
                    Profile
                </a>
                <a href="<?php echo e(route('admin.change.password')); ?>">
                    Change Password
                </a>
                <a href="<?php echo e(route('logout')); ?>"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </div>


            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

            </form>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<?php /**PATH /home/u932153640/domains/swasthfit.in/public_html/resources/views/admin/layouts/partials/navbar.blade.php ENDPATH**/ ?>