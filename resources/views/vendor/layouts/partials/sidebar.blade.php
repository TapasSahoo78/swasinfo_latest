<div class="sidebar pb-3">
    <nav class="navbar navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <img src="{{ asset('assets_f/img/logo.png') }}" alt="">
        </a>
        <div class="navbar-nav w-100 pe-3">
            <a href="{{ route('vendor.dashboard') }}" class="nav-item nav-link active"><i class="fa"><img
                        src="{{ asset('assets_f/img/Dashboard.png') }}" alt=""></i> Dashboard</a>
            <a href="{{ route('vendor.catalogue') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Catalogue.png') }}" alt=""></i> Catalogue</a>
            <a href="{{ route('vendor.inventory') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Inventory.png') }}" alt=""></i> Inventory</a>
            <a href="{{ route('vendor.orders') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Orders.png') }}" alt=""></i>
                Orders</a>
            <a href="{{ route('vendor.advertising') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Advertising.png') }}" alt=""></i> Advertising</a>
            <a href="{{ route('vendor.advertising2') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Advertising.png') }}" alt=""></i> Advertising2</a>
            <a href="{{ route('vendor.advertising3') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Advertising.png') }}" alt=""></i> Advertising3</a>

            <a href="{{ route('vendor.settings') }}" class="nav-item nav-link"><i class="fa"><img
                        src="{{ asset('assets_f/img/Settings.png') }}" alt=""></i> Settings</a>
            <a href="sign-out.html" class="nav-item nav-link signcard"><i class="fa"><img
                        src="{{ asset('assets_f/img/Sign-out.png') }}" alt=""></i> Sign-out</a>
        </div>
    </nav>
</div>
