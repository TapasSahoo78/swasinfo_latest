 <!-- Sidebar Menu -->
 <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
         <li class="nav-item has-treeview">
             <a href="{{ route('restaurant.home') }}" class="nav-link">
                 <p>
                     DASHBOARD
                 </p>
             </a>
         </li>
         <li class="nav-item has-treeview">
             <a href="{{ route('restaurant.product.list') }}" class="nav-link">
                 <p>
                     Food Item Management
                 </p>
             </a>
         </li>
         <li class="nav-item has-treeview">
             <a href="{{ route('restaurant.order.list') }}" class="nav-link">
                 <p>
                     Order Management
                 </p>
             </a>
         </li>

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
