<div class="container">
    <div class="main-nav">
        <div class="row">
            <div class="col-md-2 col-7">
                <div class="logo"> <a class="navbar-brand" href="{{ route('frontend.home') }}"><img class=""
                            src="{{ asset('frontend/images/logo.png') }}" alt="" title="SwaasthFiit" /></a>
                </div>
            </div>
            <div class="col-md-10 col-5">
                <div id="main-nav" class="stellarnav">
                    <ul>
                        <li><a href="aboutus.html">Features</a></li>
                        <li><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
                        <li><a href="portfolio.html">Sign Up</a></li>
                        <li><a href="{{ route('frontend.ecom') }}" class="loginbtn2">Buy Product</a></li>
                        <li><a href="{{ route('seller.selling.account') }}" class="loginbtn">Selling Account</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
