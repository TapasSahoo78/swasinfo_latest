@php
    $code = Auth::user()->mfi->code;
@endphp
<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
        @can('view-dashboard')
            <li class="nav-item has-treeview">
                <a href="{{ route('mfi.home', ['slug' => $code]) }}" class="nav-link">
                    <p>
                        DASHBOARD
                    </p>
                </a>
            </li>
        @endcan


        <!-- catagories -->

        <!-- catagories -->
        @canany(['add-branch', 'edit-branch', 'delete-branch', 'view-branch', 'add-loan', 'edit-loan', 'view-loan',
            'delete-loan', 'add-occupation', 'edit-occupation', 'view-occupation', 'delete-occupation', 'add-purpose',
            'edit-purpose', 'view-purpose', 'delete-purpose', 'add-user', 'edit-user', 'view-user', 'delete-user',
            'add-roles', 'edit-roles', 'view-roles', 'delete-roles', 'add-accounts', 'edit-accounts', 'view-accounts',
            'delete-accounts', 'penalty-setting', 'add-enquiries', 'edit-enquiries', 'view-enquiries', 'delete-enquiries',
            'add-leads', 'edit-leads', 'view-leads', 'delete-leads', 'add-customer', 'edit-customer', 'view-customer',
            'delete-customer', 'add-demand', 'edit-demand', 'view-demand', 'delete-demand', 'add-group', 'edit-group',
            'view-group', 'delete-group'])



            <!-- catagories -->



            <li class="nav-item has-treeview {{ slide_down(['mfi.administrator.*']) }}">
                <a href="javascript:void(0)" class="nav-link {{ sidebar_open(['mfi.administrator.*']) }}">
                    <p>
                        ADMINISTRATION
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @canany(['add-branch', 'edit-branch', 'delete-branch', 'view-branch'])
                        <li class="nav-item  {{ sidebar_open(['mfi.administrator.branch.*']) }} ">

                            <a class="nav-items-title nav-link "
                                href="{{ route('mfi.administrator.branch.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.administrator.branch.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>Branch</b>
                            </a>

                        </li>
                    @endcanany
                    @canany(['add-loan', 'edit-loan', 'view-loan', 'delete-loan'])
                        <li class="nav-item  {{ sidebar_open(['mfi.administrator.loan.*']) }} ">

                            <a class="nav-items-title nav-link "
                                href="{{ route('mfi.administrator.loan.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.administrator.loan.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif
                                <p>Loan Products</p>
                            </a>

                        </li>
                    @endcanany
                    @canany(['add-occupation', 'edit-occupation', 'view-occupation', 'delete-occupation'])
                        <li class="nav-item {{ sidebar_open(['mfi.administrator.occupation.*']) }} ">
                            <a href="{{ route('mfi.administrator.occupation.list', ['slug' => $code]) }}" class="nav-link">

                                <p>Occupation</p>
                            </a>
                        </li>
                    @endcanany
                    @canany(['add-purpose', 'edit-purpose', 'view-purpose', 'delete-purpose'])
                        <li class="nav-item {{ sidebar_open(['mfi.administrator.purpose.*']) }}">
                            <a href="{{ route('mfi.administrator.purpose.list', ['slug' => $code]) }}"
                                class="nav-items-title nav-link">
                                @if (!empty(sidebar_open(['mfi.administrator.purpose.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif
                                <p>Purpose</p>
                            </a>
                        </li>
                    @endcanany
                    @canany(['add-user', 'edit-user', 'view-user', 'delete-user'])
                        <li class="nav-item {{ sidebar_open(['mfi.administrator.user.*']) }}">
                            <a href="{{ route('mfi.administrator.user.list', ['slug' => $code]) }}"
                                class="nav-items-title nav-link">
                                @if (!empty(sidebar_open(['mfi.administrator.user.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif

                                <p>User</p>
                            </a>
                        </li>
                    @endcanany
                    @canany(['add-roles', 'edit-roles', 'view-roles', 'delete-roles'])
                        <li class="nav-item {{ sidebar_open(['mfi.administrator.role.*']) }}">
                            <a href="{{ route('mfi.administrator.role.list', ['slug' => $code]) }}"
                                class="nav-items-title nav-link">
                                @if (!empty(sidebar_open(['mfi.administrator.role.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif
                                <p>Roles</p>
                            </a>
                        </li>
                    @endcanany
                    @canany(['add-accounts', 'edit-accounts', 'view-accounts', 'delete-accounts'])
                        <li class="nav-item {{ sidebar_open(['mfi.administrator.account.*']) }}">
                            <a href="{{ route('mfi.administrator.account.list', ['slug' => $code]) }}" class="nav-link">

                                <p>Accounts</p>
                            </a>
                        </li>
                    @endcanany
                    @canany(['penalty-setting'])
                        <li class="nav-item {{ sidebar_open(['mfi.administrator.penalty-setting.*']) }} ">
                            <a href="{{ route('mfi.administrator.penalty-setting.list', ['slug' => $code]) }}"
                                class="nav-link">

                                <p>Penalty Setting</p>
                            </a>
                        </li>
                    @endcanany
                </ul>
            </li>


            <li class="nav-item has-treeview {{ slide_down(['mfi.crm.*']) }}">
                <a href="javascript:void(0)" class="nav-link {{ sidebar_open(['mfi.crm.*']) }}">
                    <p>
                        {{ __('CRM') }}
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @canany(['add-leads', 'edit-leads', 'view-leads', 'delete-leads'])
                        <li class="nav-item  {{ sidebar_open(['mfi.crm.lead.*']) }} ">

                            <a class="nav-items-title nav-link " href="{{ route('mfi.crm.lead.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.crm.lead.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>LEAD</b>
                            </a>

                        </li>
                    @endcanany
                   {{--  @canany(['add-enquiries', 'edit-enquiries', 'view-enquiries', 'delete-enquiries'])
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

            <li class="nav-item has-treeview {{ slide_down(['mfi.customer.*']) }}">
                <a href="javascript:void(0)" class="nav-link {{ sidebar_open(['mfi.customer.*']) }}">
                    <p>
                        {{ __('CUSTOMER') }}
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @canany(['add-customer', 'edit-customer', 'view-customer', 'delete-customer'])
                        <li class="nav-item  {{ sidebar_open(['mfi.customer.list']) }} ">

                            <a class="nav-items-title nav-link " href="{{ route('mfi.customer.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.customer.list'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>CUSTOMERS </b>
                            </a>
                            {{--  <a class="nav-items-title nav-link " href="{{ route('mfi.customer.demand.list', ['slug' => $code]) }}">
                            @if (!empty(sidebar_open(['mfi.customer.customer.*'])))
                                <i class="fa fa-square" aria-hidden="true"></i>
                            @endif <b>DEMANDS </b>
                        </a>  --}}
                        </li>
                    @endcanany
                    @canany(['add-demand', 'edit-demand', 'view-demand', 'delete-demand'])
                        <li class="nav-item  {{ sidebar_open(['mfi.customer.demand.*']) }} ">

                            <a class="nav-items-title nav-link "
                                href="{{ route('mfi.customer.demand.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.customer.demand*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>DEMANDS </b>
                            </a>
                            <a class="nav-items-title nav-link "
                                href="{{ route('mfi.customer.disbursement.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.customer.disbursement*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>DISBURSEMENTS </b>
                            </a>
                            {{--  <a class="nav-items-title nav-link " href="{{ route('mfi.customer.demand.list', ['slug' => $code]) }}">
                            @if (!empty(sidebar_open(['mfi.customer.customer.*'])))
                                <i class="fa fa-square" aria-hidden="true"></i>
                            @endif <b>DEMANDS </b>
                        </a>  --}}
                        </li>
                    @endcanany
                    {{--   @canany(['add-enquiries', 'edit-enquiries', 'view-enquiries', 'delete-enquiries'])
                        <li class="nav-item  {{ sidebar_open(['mfi.crm.enquiry.*']) }} ">

                            <a class="nav-items-title nav-link "
                                href="{{ route('mfi.crm.enquiry.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.crm.enquiry.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>ENQUIRY</b>
                            </a>

                        </li>
                    @endcanany  --}}

                </ul>
            </li>
            <li class="nav-item has-treeview {{ slide_down(['mfi.group.*']) }}">
                <a href="javascript:void(0)" class="nav-link {{ sidebar_open(['mfi.group.*']) }}">
                    <p>
                        {{ __('GROUP') }}
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @canany(['add-group', 'edit-group', 'view-group', 'delete-group'])
                        <li class="nav-item  {{ sidebar_open(['mfi.group.*']) }} ">

                            <a class="nav-items-title nav-link " href="{{ route('mfi.group.list', ['slug' => $code]) }}">
                                @if (!empty(sidebar_open(['mfi.group.*'])))
                                    <i class="fa fa-square" aria-hidden="true"></i>
                                @endif <b>GROUP LIST</b>
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

        {{--   <li class="nav-item has-treeview">

            <a href="{{ route('logout') }}" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <p>
                    Logout
                </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>  --}}
    </ul>
</nav>
<!-- /.sidebar-menu -->
