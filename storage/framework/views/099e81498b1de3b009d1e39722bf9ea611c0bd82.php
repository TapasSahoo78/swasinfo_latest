 <!-- Sidebar Menu -->
 <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
         <div style="padding: 5px;border: 1px solid black;margin: 0px 5px 0px 5px;">
             <li class="nav-item has-treeview">
                 <p>
                     <span>Your onboarding</span>
                     <span>completion status</span>
                 </p>
                 <p style="padding: 2px 0px 3px 10px;">
                     <span>80%</span> &nbsp; <input type="range" id="volume" name="volume" min="0"
                         max="100" value="50" disabled>
                 </p>
             </li>
         </div>

         
         <div
             style="border-width: 0px 1px 1px 1px; border-style: solid; border-color: black;margin: 0px 5px 6px 5px;padding:3px;">
             <li class="nav-item has-treeview <?php echo e(slide_down(['admin.subscription.*'])); ?>">
                 <a href="javascript:void(0)" class="nav-link disabled-link">
                     <p>
                         <?php echo e(__('Mobile & Email Verification')); ?>

                     </p>
                 </a>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.course.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg>
                     <b>Mobile Verification</b>
                 </a>

             </li>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.plan.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>Email Verification</b>
                 </a>

             </li>
             </li>

             <li class="nav-item has-treeview <?php echo e(slide_down(['admin.subscription.*'])); ?>">
                 <a href="javascript:void(0)" class="nav-link disabled-link">
                     <p>
                         <?php echo e(__('ID & Signature Verification')); ?>


                     </p>
                 </a>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.course.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>ID Verification</b>
                 </a>

             </li>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.plan.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>Signature Verification</b>
                 </a>

             </li>
             </li>

             <li class="nav-item has-treeview <?php echo e(slide_down(['admin.subscription.*'])); ?>">
                 <a href="javascript:void(0)" class="nav-link disabled-link">
                     <p>
                         <?php echo e(__('Store & Pickup Details')); ?>


                     </p>
                 </a>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.course.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>Display Name</b>
                 </a>

             </li>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.plan.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>Pickup Address</b>
                 </a>

             </li>
             </li>

             <li class="nav-item has-treeview <?php echo e(slide_down(['admin.subscription.*'])); ?>">
                 <a href="javascript:void(0)" class="nav-link disabled-link">
                     <p>
                         <?php echo e(__('Listing & Stock Availablity')); ?>


                     </p>
                 </a>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.course.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>Listing Created</b>
                 </a>

             </li>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.plan.*'])); ?> ">

                 <a class=" nav-link disabled-link" href="#">
                     <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                         <path fill="#27c624"
                             d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                     </svg> <b>Stock Added</b>
                 </a>

             </li>
             </li>
         </div>
     </ul>
 </nav>
 <!-- /.sidebar-menu -->
<?php /**PATH J:\DECEMBER-2024\SWASINFO(latest)\shyamfuturetech-swasthafit(latest)\resources\views/vendor/layouts/partials/sidebar.blade.php ENDPATH**/ ?>