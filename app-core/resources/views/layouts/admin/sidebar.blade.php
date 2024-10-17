<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link d-flex justify-content-center align-items-center" style="height: 100%;">
                        <img src="https://gsacommerce.com/assets/frontend/image/gsa-logo.svg" alt="Sneat Logo" class="app-brand-text demo menu-text fw-bolder ms-2" width="180px">
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item">
                        <a href="{{ route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Pages</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Products</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('product.index') }}" class="menu-link">
                                    <div data-i18n="Basic">Manage Product</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('product.categories.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Categories</div>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Transaksi</span>
                    </li>
                    <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-cart"></i> <!-- Use the shopping cart icon -->
                        <div data-i18n="Authentications">Pemesanan
                            @php
                                // Count of unviewed orders
                                $unviewedOrdersCount = \App\Models\Order::where('is_viewed', false)->count();
                            @endphp
                            @if ($unviewedOrdersCount > 0)
                                <span class="badge bg-danger">{{ $unviewedOrdersCount }}</span>
                            @endif
                        </div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('admin.orders.index') }}" class="menu-link">
                                <div data-i18n="Basic">Pemesanan</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-credit-card"></i> <!-- Use the credit card icon -->
                        <div data-i18n="Authentications">Pembayaran
                            @php
                                // Count of unviewed payments
                                $unviewedPaymentsCount = \App\Models\Payment::where('is_viewed', false)->count();
                            @endphp
                            @if ($unviewedPaymentsCount > 0)
                                <span class="badge bg-danger">{{ $unviewedPaymentsCount }}</span>
                            @endif
                        </div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('admin.payments.index') }}" class="menu-link">
                                <div data-i18n="Basic">Bukti Pembayaran</div>
                            </a>
                        </li>
                    </ul>
                </li>
                


                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Banner</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Banner</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.banner-home.banners.index') }}" class="menu-link">
                                    <div data-i18n="Basic">Home</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.banner-micro.banners.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Micro</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Master Data</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Master</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('masterdata.shipping.index') }}" class="menu-link">
                                    <div data-i18n="Basic">Jasa Angkutan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('masterdata.parameters.index') }}" class="menu-link">
                                    <div data-i18n="Notifications">Parameter</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">FAQ</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">FAQ</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.faq.index') }}" class="menu-link">
                                    <div data-i18n="Basic">FAQ</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->


            