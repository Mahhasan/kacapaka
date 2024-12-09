<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Rajshahi, Bangladesh</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">kacapaka2017@gmail.com</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <!-- Brand Logo -->
            <a href="/" class="navbar-brand">
                <img src="{{asset('frontend/img/logo/logo-1.png')}}" class="img-fluid" width="175px" height="39px" alt="Logo">
            </a>

            <!-- Navbar Toggler and User Icon in Mobile View -->
            <div class="d-flex">
                <!-- User Icon in Mobile View -->
                <div class="nav-item dropdown no-arrow my-auto ms-2 d-xl-none">
                    <a class="nav-link" href="#" id="userDropdownMobile" role="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user fa-2x"></i>
                    </a>
                    <!-- Dropdown Menu for User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdownMobile">
                        <a class="dropdown-item" href="{{ route('user.profile') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('user.orders') }}">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Orders
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </div>
                <!-- Shopping Cart Icon -->
                <a href="#" class="position-relative me-4 my-auto d-xl-none">
                    <i class="fa fa-shopping-cart fa-2x"></i>
                    <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                </a>
                <!-- Navbar Toggler -->
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>

            </div>

            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="/" class="nav-item nav-link active">Home</a>
                    <a href="{{ route('frontend.shop') }}" class="nav-item nav-link">Shop</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Categories</a>
                        <!-- <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="pickle.html" class="dropdown-item">Pickle</a>
                            <a href="mangobar.html" class="dropdown-item">Mangobar</a>
                            <a href="mango.html" class="dropdown-item">Mango</a>
                            <a href="combo.html" class="dropdown-item">Combo Package</a>
                        </div> -->
                    </div>
                    <a href="#" class="nav-item nav-link">About Us</a>
                    <a href="#" class="nav-item nav-link">Stories</a>
                    <a href="{{ route('frontend.contact') }}" class="nav-item nav-link">Contact</a>
                </div>
                <div class="d-flex m-3 me-0">
                    <!-- Search Button -->
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>

                    <!-- Shopping Cart Icon -->
                    <a href="#" class="position-relative me-4 my-auto d-none d-xl-block">
                        <i class="fa fa-shopping-cart fa-2x"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                    </a>

                    <!-- User Icon with Dropdown Menu for larger screens -->
                    <div class="nav-item dropdown no-arrow d-none d-xl-block">
                        <a class="my-auto nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user fa-2x"></i> <!-- Only User Icon -->
                        </a>
                        <!-- Dropdown Menu for User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('user.orders') }}">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Orders
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
