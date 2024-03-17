 <!-- Sidebar Menu -->
 <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.home')); ?>" class="nav-link">
                 <p>
                     DASHBOARD
                 </p>
             </a>
         </li>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['role'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.role.list')); ?>" class="nav-link">
                 <p>
                     Manage Roles
                 </p>
             </a>
         </li>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-admin-user','edit-admin-user','delete-admin-user','view-admin-user'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.user.list')); ?>" class="nav-link">
                 <p>
                     Manage Admin Users
                 </p>
             </a>
         </li>
         <?php endif; ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['list-customers-user','view-customers-user'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.customer.list')); ?>" class="nav-link">
                 <p>
                     Manage Customers
                 </p>
             </a>
         </li>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-trainers-dietitian','list-trainers-dietitian','edit-trainers-dietitian','delete-trainers-dietitian'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.trainer.list')); ?>" class="nav-link">
                 <p>
                     Manage Trainers & Dietitian
                 </p>
             </a>
         </li>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-doctor','list-doctor','edit-doctor','delete-doctor'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.doctor.list')); ?>" class="nav-link">
                 <p>
                     Manage Doctor List
                 </p>
             </a>
         </li>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-sales-manager','list-sales-manager','edit-sales-manager','delete-sales-manager'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.sales.list')); ?>" class="nav-link">
                 <p>
                     Manage Sales Manager 
                 </p>
             </a>
         </li>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-agent-manager','list-agent-manager','edit-agent-manager','delete-agent-manager'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.agent.list')); ?>" class="nav-link">
                 <p>
                     Manage Sales Agent 
                 </p>
             </a>
         </li>
         <?php endif; ?> 
        <?php 
            if(auth()->user()->id != 1){
              $userId = auth()->user()->uuid;
        ?>
         <li class="nav-item has-treeview">
             <a href=" <?php echo e(route('admin.agent.reporttotal',$userId)); ?>" class="nav-link">
                 <p>
                     Report 
                 </p>
             </a>
         </li>
        <?php } ?>
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-workout','list-workout','edit-workout','delete-workout'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.workout.list')); ?>" class="nav-link">
                 <p>
                     Manage Workouts
                 </p>
             </a>
         </li>
         <?php endif; ?> 
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-diet','edit-diet','delete-diet','add-food','edit-food','delete-food'])): ?>
         <li class="nav-item has-treeview <?php echo e(slide_down(['admin.diet.*'])); ?>">
             <a href="javascript:void(0)" class="nav-link <?php echo e(sidebar_open(['admin.diet.*'])); ?>">
                 <p>
                     <?php echo e(__('Diet Plan')); ?>

                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 

                 <li class="nav-item  <?php echo e(sidebar_open(['admin.diet.food.*'])); ?> ">

                     <a class="nav-items-title nav-link" href="<?php echo e(route('admin.diet.food.list')); ?>">
                         <?php if(!empty(sidebar_open(['admin.diet.food.*']))): ?>
                         <i class="fa fa-square" aria-hidden="true"></i>
                         <?php endif; ?> <b>Food</b>
                     </a>

                 </li>
                 <li class="nav-item  <?php echo e(sidebar_open(['admin.diet.plan.*'])); ?> ">

                     <a class="nav-items-title nav-link" href="<?php echo e(route('admin.diet.plan.list')); ?>">
                         <?php if(!empty(sidebar_open(['admin.diet.plan.*']))): ?>
                         <i class="fa fa-square" aria-hidden="true"></i>
                         <?php endif; ?> <b>Diet Plan</b>
                     </a>

                 </li>
                 
                 

     </ul>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-courses','list-courses','edit-courses','delete-courses','add-plans','list-plans','edit-plans','delete-plans'])): ?>
     <li class="nav-item has-treeview <?php echo e(slide_down(['admin.subscription.*'])); ?>">
         <a href="javascript:void(0)" class="nav-link <?php echo e(sidebar_open(['admin.subscription.*'])); ?>">
             <p>
                 <?php echo e(__('Subscription Plan')); ?>

                 <i class="fa fa-plus" aria-hidden="true"></i>
             </p>
         </a>
         <ul class="nav nav-treeview">
             
             
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.course.*'])); ?> ">

                 <a class="nav-items-title nav-link" href="<?php echo e(route('admin.subscription.course.list')); ?>">
                     <?php if(!empty(sidebar_open(['admin.subscription.course.*']))): ?>
                     <i class="fa fa-square" aria-hidden="true"></i>
                     <?php endif; ?> <b>Course</b>
                 </a>

             </li>
             <li class="nav-item  <?php echo e(sidebar_open(['admin.subscription.plan.*'])); ?> ">

                 <a class="nav-items-title nav-link" href="<?php echo e(route('admin.subscription.plan.list')); ?>">
                     <?php if(!empty(sidebar_open(['admin.subscription.plan.*']))): ?>
                     <i class="fa fa-square" aria-hidden="true"></i>
                     <?php endif; ?> <b>Plan</b>
                 </a>

             </li>
             
             

     </ul>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['faq'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.cms.faq')); ?>" class="nav-link">
             <p>
                 Manage FAQS
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['update-privacy-policy'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.cms.privacy.policy')); ?>" class="nav-link">
             <p>
                 Manage Privacy policy
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['term-and-condition'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.cms.term.and.condition')); ?>" class="nav-link">
             <p>
                 Manage term and condition
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['contact-us'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.cms.contact.us')); ?>" class="nav-link">
             <p>
                 Manage Contact-us
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['help-and-support'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.cms.helps.support')); ?>" class="nav-link">
             <p>
                 Manage Help And Support
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-rewards','list-rewards','edit-rewards','delete-rewards'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.reward.list')); ?>" class="nav-link">
             <p>
                 Manage Rewards
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['list-transaction'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.customer.transaction')); ?>" class="nav-link">
             <p>
                 Manage Transaction List
             </p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['live-session'])): ?>
     <li class="nav-item has-treeview">
         <a href="<?php echo e(route('admin.customer.livesession')); ?>" class="nav-link">
             <p>
                 Live Session
             </p>
         </a>
     </li>
     <?php endif; ?>
     

     <li class="nav-item has-treeview">
         <a href="#" class="nav-link">
             <p>
                 E- Commerce Section
                 <i class="fa fa-plus" aria-hidden="true"></i>
             </p>
         </a>
        
         <ul class="nav nav-treeview">
         <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['bannerlist'])): ?>
            <li class="nav-item">
                 <a href="<?php echo e(route('admin.product.bannerlist')); ?>" class="nav-link">
                     <p>MANAGE Banner</p>

                 </a>
             </li>
        <?php endif; ?>   
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['category'])): ?>
         <li class="nav-item">
                 <a href="<?php echo e(route('admin.product.category.list')); ?>" class="nav-link">
                     <p>MANAGE Category</p>

                 </a>
             </li>
             <?php endif; ?> 
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['product'])): ?>  
             <li class="nav-item">
                 <a href="<?php echo e(route('admin.product.list')); ?>" class="nav-link">

                     <p>MANAGE Product</p>
                 </a>
             </li>
             <?php endif; ?> 
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['points'])): ?>  
             <li class="nav-item">
                 <a href="<?php echo e(route('admin.product.points.list')); ?>" class="nav-link">
                     <p>MANAGE Points</p>
                 </a>
             </li>
             <?php endif; ?> 
         </ul>
     </li>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['vendor'])): ?>
         <li class="nav-item has-treeview">
             <a href="<?php echo e(route('admin.vendor.list')); ?>" class="nav-link">
                 <p>
                     Manage Vendor List
                 </p>
             </a>
         </li>
         <?php endif; ?> 

     <!-- catagories -->
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-branch', 'edit-branch', 'delete-branch', 'view-branch', 'add-loan', 'edit-loan', 'view-loan',
     'delete-loan', 'add-occupation', 'edit-occupation', 'view-occupation', 'delete-occupation', 'add-purpose',
     'edit-purpose', 'view-purpose', 'delete-purpose', 'add-user', 'edit-user', 'view-user', 'delete-user',
     'add-roles', 'edit-roles', 'view-roles', 'delete-roles', 'add-accounts', 'edit-accounts', 'view-accounts',
     'delete-accounts'])): ?>
     <li class="nav-item has-treeview">
         <a href="#" class="nav-link active">
             <p>
                 ADMINISTRATION
                 <i class="fa fa-plus" aria-hidden="true"></i>
             </p>
         </a>
         <ul class="nav nav-treeview">
             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-branch', 'edit-branch', 'delete-branch', 'view-branch'])): ?>
             
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-loan', 'edit-loan', 'view-loan', 'delete-loan'])): ?>
     <li class="nav-item">
         <a href="#" class="nav-link">
             <p>Loan</p>

         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-occupation', 'edit-occupation', 'view-occupation', 'delete-occupation'])): ?>
     <li class="nav-item">
         <a href="#" class="nav-link">

             <p>Occupation</p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-purpose', 'edit-purpose', 'view-purpose', 'delete-purpose'])): ?>
     <li class="nav-item">
         <a href="#" class="nav-link">

             <p>Purpose</p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-user', 'edit-user', 'view-user', 'delete-user'])): ?>
     <li class="nav-item">
         <a href="#" class="nav-link">

             <p>User</p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-roles', 'edit-roles', 'view-roles', 'delete-roles'])): ?>
     <li class="nav-item">
         <a href="#" class="nav-link">

             <p>Roles</p>
         </a>
     </li>
     <?php endif; ?>
     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['add-accounts', 'edit-accounts', 'view-accounts', 'delete-accounts'])): ?>
     <li class="nav-item">
         <a href="#" class="nav-link">

             <p>Accounts</p>
         </a>
     </li>
     <?php endif; ?>
     </ul>
     </li>
     <?php endif; ?>
     <!--
         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     CRM
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item">

                     <p class="nav-items-title"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></p>

                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <p>Loan</p>

                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Occupation</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Purpose</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Roles</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Accounts</p>
                     </a>
                 </li>
             </ul>
         </li>


         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     CUSTOMERS
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item">

                     <p class="nav-items-title"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></p>

                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <p>Loan</p>

                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Occupation</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Purpose</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Roles</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Accounts</p>
                     </a>
                 </li>
             </ul>
         </li>

         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     DISBURSEMENT
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item">

                     <p class="nav-items-title"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></p>

                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <p>Loan</p>

                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Occupation</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Purpose</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Roles</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Accounts</p>
                     </a>
                 </li>
             </ul>
         </li>

         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     RECOVERY
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item">

                     <p class="nav-items-title"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></p>

                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <p>Loan</p>

                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Occupation</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Purpose</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Roles</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Accounts</p>
                     </a>
                 </li>
             </ul>
         </li>


         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     LEDGER
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item">

                     <p class="nav-items-title"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></p>

                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <p>Loan</p>

                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Occupation</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Purpose</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Roles</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Accounts</p>
                     </a>
                 </li>
             </ul>
         </li>


         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     MIS
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item">

                     <p class="nav-items-title"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></p>

                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <p>Loan</p>

                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Occupation</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Purpose</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>User</p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Roles</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="#" class="nav-link">

                         <p>Accounts</p>
                     </a>
                 </li>
             </ul>
         </li> -->

     <li class="nav-item has-treeview">

         <a href="<?php echo e(route('logout')); ?>" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             <p>
                 Logout
             </p>
         </a>
         <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
             <?php echo e(csrf_field()); ?>

         </form>
     </li>
     </ul>
 </nav>
 <!-- /.sidebar-menu -->
<?php /**PATH /home/u932153640/domains/swasthfit.in/public_html/resources/views/admin/layouts/partials/sidebar.blade.php ENDPATH**/ ?>