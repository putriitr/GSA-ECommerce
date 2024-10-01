    <!--  Main wrapper -->
    <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light" style="position: fixed; top: 0; width: 77%; height: 60px;">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <a href="#" target="_blank" class="btn btn-primary me-2"><span
                                class="d-none d-md-block">Check Pro Version</span> <span
                                class="d-block d-md-none">Pro</span></a>
                        <a href="#" target="_blank" class="btn btn-success"><span
                                class="d-none d-md-block">Download Free </span> <span
                                class="d-block d-md-none">Free</span></a>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('storage/img/user.png') }}" alt="" width="35"
                                    height="35" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="dropdown-item">My Profile</a>
                                    <a href="javascript:void(0)" class="dropdown-item">My Balance</a>
                                    <a href="javascript:void(0)" class="dropdown-item">Settings</a>
                                    <a href="javascript:void(0)" class="dropdown-item">Lock Screen</a>
                                    <a href="javascript:void(0)" class="dropdown-item">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--  Header End -->
