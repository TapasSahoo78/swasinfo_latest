 <!-- Sidebar Menu -->
 <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
         <li class="nav-item has-treeview">
             <a href="{{ route('admin.home') }}" class="nav-link">
                 <p>
                     DASHBOARD
                 </p>
             </a>
         </li>
         @canany(['role'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.role.list') }}" class="nav-link">
                     <p>
                         Manage Roles
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-admin-user', 'edit-admin-user', 'delete-admin-user', 'view-admin-user'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.user.list') }}" class="nav-link">
                     <p>
                         Manage Admin Users
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['list-customers-user', 'view-customers-user'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.customer.list') }}" class="nav-link">
                     <p>
                         Manage Customers
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-trainers-dietitian', 'list-trainers-dietitian', 'edit-trainers-dietitian',
             'delete-trainers-dietitian'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.trainer.list') }}" class="nav-link">
                     <p>
                         Manage Trainers & Dietitian
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-doctor', 'list-doctor', 'edit-doctor', 'delete-doctor'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.doctor.list') }}" class="nav-link">
                     <p>
                         Manage Doctor List
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-sales-manager', 'list-sales-manager', 'edit-sales-manager', 'delete-sales-manager'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.sales.list') }}" class="nav-link">
                     <p>
                         Manage Sales Manager
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-agent-manager', 'list-agent-manager', 'edit-agent-manager', 'delete-agent-manager'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.agent.list') }}" class="nav-link">
                     <p>
                         Manage Sales Agent
                     </p>
                 </a>
             </li>
         @endcanany
         <?php
            if(auth()->user()->id != 1){
              $userId = auth()->user()->uuid;
        ?>
         <li class="nav-item has-treeview">
             <a href=" {{ route('admin.agent.reporttotal', $userId) }}" class="nav-link">
                 <p>
                     Report
                 </p>
             </a>
         </li>
         <?php } ?>
         @canany(['add-workout', 'list-workout', 'edit-workout', 'delete-workout'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.workout.list') }}" class="nav-link">
                     <p>
                         Manage Workouts
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-diet', 'edit-diet', 'delete-diet', 'add-food', 'edit-food', 'delete-food'])
             <li class="nav-item has-treeview {{ slide_down(['admin.diet.*']) }}">
                 <a href="javascript:void(0)" class="nav-link {{ sidebar_open(['admin.diet.*']) }}">
                     <p>
                         {{ __('Diet Plan') }}
                         <i class="fa fa-plus" aria-hidden="true"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview">
                     {{-- @canany(['add-leads', 'edit-leads', 'view-leads', 'delete-leads']) --}}

                     <li class="nav-item  {{ sidebar_open(['admin.diet.food.*']) }} ">

                         <a class="nav-items-title nav-link" href="{{ route('admin.diet.food.list') }}">
                             @if (!empty(sidebar_open(['admin.diet.food.*'])))
                                 <i class="fa fa-square" aria-hidden="true"></i>
                             @endif <b>Food</b>
                         </a>

                     </li>
                     <li class="nav-item  {{ sidebar_open(['admin.diet.plan.*']) }} ">

                         <a class="nav-items-title nav-link" href="{{ route('admin.diet.plan.list') }}">
                             @if (!empty(sidebar_open(['admin.diet.plan.*'])))
                                 <i class="fa fa-square" aria-hidden="true"></i>
                             @endif <b>Diet Plan</b>
                         </a>

                     </li>
                     {{-- @endcanany --}}
                     {{-- @canany(['add-enquiries', 'edit-enquiries', 'view-enquiries', 'delete-enquiries'])
                        <li class="nav-item  {{ sidebar_open(['mfi.crm.enquiry.*']) }} ">

                 <a class="nav-items-title nav-link " href="{{ route('mfi.crm.enquiry.list', ['slug' => $code]) }}">
                     @if (!empty(sidebar_open(['mfi.crm.enquiry.*'])))
                     <i class="fa fa-square" aria-hidden="true"></i>
                     @endif <b>ENQUIRY</b>
                 </a>

         </li>

         @endcanany --}}

                 </ul>
             </li>
         @endcanany
         @canany(['add-courses', 'list-courses', 'edit-courses', 'delete-courses', 'add-plans', 'list-plans',
             'edit-plans', 'delete-plans'])
             <li class="nav-item has-treeview {{ slide_down(['admin.subscription.*']) }}">
                 <a href="javascript:void(0)" class="nav-link {{ sidebar_open(['admin.subscription.*']) }}">
                     <p>
                         {{ __('Subscription Plan') }}
                         <i class="fa fa-plus" aria-hidden="true"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview">
                     {{-- @canany(['add-leads', 'edit-leads', 'view-leads', 'delete-leads']) --}}
                     {{-- <li class="nav-item  {{ sidebar_open(['admin.subscription.category.*']) }} ">

                 <a class="nav-items-title nav-link " href="{{ route('admin.subscription.category.list') }}">
                     @if (!empty(sidebar_open(['admin.subscription.category.*'])))
                     <i class="fa fa-square" aria-hidden="true"></i>
                     @endif <b>category</b>
                 </a>

             </li> --}}
                     <li class="nav-item  {{ sidebar_open(['admin.subscription.course.*']) }} ">

                         <a class="nav-items-title nav-link" href="{{ route('admin.subscription.course.list') }}">
                             @if (!empty(sidebar_open(['admin.subscription.course.*'])))
                                 <i class="fa fa-square" aria-hidden="true"></i>
                             @endif <b>Course</b>
                         </a>

                     </li>
                     <li class="nav-item  {{ sidebar_open(['admin.subscription.plan.*']) }} ">

                         <a class="nav-items-title nav-link" href="{{ route('admin.subscription.plan.list') }}">
                             @if (!empty(sidebar_open(['admin.subscription.plan.*'])))
                                 <i class="fa fa-square" aria-hidden="true"></i>
                             @endif <b>Plan</b>
                         </a>

                     </li>
                     {{-- @endcanany --}}
                     {{-- @canany(['add-enquiries', 'edit-enquiries', 'view-enquiries', 'delete-enquiries'])
                        <li class="nav-item  {{ sidebar_open(['mfi.crm.enquiry.*']) }} ">

             <a class="nav-items-title nav-link " href="{{ route('mfi.crm.enquiry.list', ['slug' => $code]) }}">
                 @if (!empty(sidebar_open(['mfi.crm.enquiry.*'])))
                 <i class="fa fa-square" aria-hidden="true"></i>
                 @endif <b>ENQUIRY</b>
             </a>

     </li>
     @endcanany --}}

                 </ul>
             </li>
         @endcanany
         @canany(['faq'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.cms.faq') }}" class="nav-link">
                     <p>
                         Manage FAQS
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['update-privacy-policy'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.cms.privacy.policy') }}" class="nav-link">
                     <p>
                         Manage Privacy policy
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['term-and-condition'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.cms.term.and.condition') }}" class="nav-link">
                     <p>
                         Manage term and condition
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['contact-us'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.cms.contact.us') }}" class="nav-link">
                     <p>
                         Manage Contact-us
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['help-and-support'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.cms.helps.support') }}" class="nav-link">
                     <p>
                         Manage Help And Support
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['add-rewards', 'list-rewards', 'edit-rewards', 'delete-rewards'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.reward.list') }}" class="nav-link">
                     <p>
                         Manage Rewards
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['list-transaction'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.customer.transaction') }}" class="nav-link">
                     <p>
                         Manage Transaction List
                     </p>
                 </a>
             </li>
         @endcanany
         @canany(['live-session'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.customer.livesession') }}" class="nav-link">
                     <p>
                         Live Session
                     </p>
                 </a>
             </li>
         @endcanany
         {{-- <li class="nav-item has-treeview">
             <a href="{{route('admin.customer.list')}}" class="nav-link">
     <p>
         Manage Trainner
     </p>
     </a>
     </li> --}}

         <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
                 <p>
                     E- Commerce Section
                     <i class="fa fa-plus" aria-hidden="true"></i>
                 </p>
             </a>

             <ul class="nav nav-treeview">
                @canany(['category'])
                <li class="nav-item">
                    <a href="{{ route('admin.product.brand.list') }}" class="nav-link">
                        <p>MANAGE Brand</p>
                    </a>
                </li>
            @endcanany
                 @canany(['category'])
                     <li class="nav-item">
                         <a href="{{ route('admin.product.category.list') }}" class="nav-link">
                             <p>MANAGE Category</p>

                         </a>
                     </li>

                     <li class="nav-item">
                        <a href="{{ route('admin.subcategory.list') }}" class="nav-link">
                            <p>MANAGE Commision</p>

                        </a>
                    </li>

                 @endcanany
                 @canany(['product'])
                     <li class="nav-item">
                         <a href="{{ route('admin.product.list') }}" class="nav-link">

                             <p>MANAGE Product</p>
                         </a>
                     </li>
                 @endcanany
                 @canany(['points'])
                     <li class="nav-item">
                         <a href="{{ route('admin.product.points.list') }}" class="nav-link">
                             <p>MANAGE Variants</p>
                         </a>
                     </li>
                 @endcanany
                 @canany(['category'])
                     <li class="nav-item">
                         <a href="{{ route('admin.product.category.list') }}" class="nav-link">
                             <p>MANAGE Order</p>
                         </a>
                     </li>
                 @endcanany

             </ul>
         </li>
         @canany(['vendor'])
             <li class="nav-item has-treeview">
                 <a href="{{ route('admin.vendor.list') }}" class="nav-link">
                     <p>
                         Manage Vendor List
                     </p>
                 </a>
             </li>
         @endcanany

         <!-- catagories -->
         @canany(['add-branch', 'edit-branch', 'delete-branch', 'view-branch', 'add-loan', 'edit-loan', 'view-loan',
             'delete-loan', 'add-occupation', 'edit-occupation', 'view-occupation', 'delete-occupation', 'add-purpose',
             'edit-purpose', 'view-purpose', 'delete-purpose', 'add-user', 'edit-user', 'view-user', 'delete-user',
             'add-roles', 'edit-roles', 'view-roles', 'delete-roles', 'add-accounts', 'edit-accounts', 'view-accounts',
             'delete-accounts'])
             <li class="nav-item has-treeview">
                 <a href="#" class="nav-link active">
                     <p>
                         ADMINISTRATION
                         <i class="fa fa-plus" aria-hidden="true"></i>
                     </p>
                 </a>
                 <ul class="nav nav-treeview">
                     @canany(['add-branch', 'edit-branch', 'delete-branch', 'view-branch'])
                         {{-- <li class="nav-item">

                     <a class="nav-items-title" href="{{ route('admin.branch.list') }}"><i class="fa fa-square" aria-hidden="true"></i><b>Branch</b></a>

     </li> --}}
                     @endcanany
                     @canany(['add-loan', 'edit-loan', 'view-loan', 'delete-loan'])
                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <p>Loan</p>

                             </a>
                         </li>
                     @endcanany
                     @canany(['add-occupation', 'edit-occupation', 'view-occupation', 'delete-occupation'])
                         <li class="nav-item">
                             <a href="#" class="nav-link">

                                 <p>Occupation</p>
                             </a>
                         </li>
                     @endcanany
                     @canany(['add-purpose', 'edit-purpose', 'view-purpose', 'delete-purpose'])
                         <li class="nav-item">
                             <a href="#" class="nav-link">

                                 <p>Purpose</p>
                             </a>
                         </li>
                     @endcanany
                     @canany(['add-user', 'edit-user', 'view-user', 'delete-user'])
                         <li class="nav-item">
                             <a href="#" class="nav-link">

                                 <p>User</p>
                             </a>
                         </li>
                     @endcanany
                     @canany(['add-roles', 'edit-roles', 'view-roles', 'delete-roles'])
                         <li class="nav-item">
                             <a href="#" class="nav-link">

                                 <p>Roles</p>
                             </a>
                         </li>
                     @endcanany
                     @canany(['add-accounts', 'edit-accounts', 'view-accounts', 'delete-accounts'])
                         <li class="nav-item">
                             <a href="#" class="nav-link">

                                 <p>Accounts</p>
                             </a>
                         </li>
                     @endcanany
                 </ul>
             </li>
         @endcanany
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

             <a href="{{ route('logout') }}" class="nav-link"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 <p>
                     Logout
                 </p>
             </a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 {{ csrf_field() }}
             </form>
         </li>
     </ul>
 </nav>
 <!-- /.sidebar-menu -->
