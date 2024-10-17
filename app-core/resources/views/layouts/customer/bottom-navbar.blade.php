<nav class="navbar navbar-light navbar-expand rounded-pill mb-3 ms-3 me-3 fixed-bottom d-lg-none shadow"
    style="background: #38a3a5;">
    <ul class="nav nav-justified w-100" id="myTab" role="tablist">
        <!-- Home -->
        <li class="nav-item" role="presentation">
            <a href="{{ route('home') }}" class="nav-link" id="home-tab" role="tab">
                <span><i class="bi bi-house-fill"></i></span>
            </a>
        </li>
         <!-- Cart -->
         <li class="nav-item" role="presentation">
            @if (Auth::check())
                <!-- If the user is logged in, show the link to the cart page -->
                <a href="{{ route('cart.show') }}" class="nav-link" id="cart-tab" role="tab">
                    <span><i class="bi bi-bag-fill"></i></span>
                </a>
            @else
                <!-- If the user is not logged in, show the link to the login page -->
                <a href="{{ route('login.page') }}" class="nav-link" id="cart-tab" role="tab">
                    <span><i class="bi bi-bag-fill"></i></span>
                </a>
            @endif
        </li>
        
        <!-- Search -->
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="search-tab" data-bs-toggle="modal" data-bs-target="#searchModal" type="button"
                role="tab" aria-controls="search" aria-selected="false">
                <span><i class="bi bi-search"></i></span>
            </button>
        </li>

        <!-- Transactions -->
        <li class="nav-item" role="presentation">
            @if (Auth::check())
                <a href="{{ route('customer.orders.index') }}" class="nav-link" id="transactions-tab" role="tab">
                    <span><i class="bi bi-receipt-cutoff"></i></span>
                </a>
            @else
                <a href="{{ route('login.page') }}" class="nav-link" id="transactions-tab" role="tab">
                    <span><i class="bi bi-receipt-cutoff"></i></span>
                </a>
            @endif
        </li>
        
        <!-- User -->
        <li class="nav-item" role="presentation">
            @if (Auth::check())
                <!-- If the user is logged in, show the dropup menu -->
                <div class="dropup">
                    <button class="nav-link" id="user-tab" type="button" role="tab" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="bi bi-person-circle"></i></span>
                    </button>
                    <ul class="dropdown-menu p-3 shadow" aria-labelledby="user-tab">
                        <li class="mb-3 d-flex align-items-center">
                            <img src="{{ Auth::user()->profile_image_url ? Auth::user()->profile_image_url : asset('assets/default/image/user.png') }}" 
                            alt="Profile Image" 
                            class="rounded-circle me-2" 
                            style="width: 40px; height: 40px;">

                            <div>
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile.show') }}">Profil</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- If the user is not logged in, redirect to login page when the button is clicked -->
                <button class="nav-link" id="user-tab" type="button" role="tab" onclick="redirectToLogin()">
                    <span><i class="bi bi-person-circle"></i></span>
                </button>
            @endif
        </li>
        
    </ul>
</nav>



<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <form action="{{ route('shop') }}" method="GET" class="d-flex align-items-center w-75 search-bar-modal" style="background-color: white; border-radius: 50px; padding: 5px;">
                    <!-- Dropdown for Product Categories -->
                    <div class="dropdown me-2">
                        <button class="btn btn-light dropdown-toggle rounded-pill px-3" type="button" id="modalDropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="modalCategoryLabel">{{ $selectedCategoryName ?? 'Semua Produk' }}</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="modalDropdownMenuButton">
                            <li><a class="dropdown-item" href="#" onclick="selectCategoryModal(null, 'Semua Produk')">Semua Produk</a></li>
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="#" onclick="selectCategoryModal({{ $category->id }}, '{{ $category->name }}')">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Hidden input for category -->
                    <input type="hidden" name="category_id" id="modalCategoryInput" value="{{ request()->get('category_id') }}">
                    <!-- Search Input -->
                    <input type="text" class="form-control border-0 rounded-pill px-4 py-2" placeholder="Cari Barang Impian Kamu" name="keyword" value="{{ request()->get('keyword') }}">
                    <!-- Search Button -->
                    <button class="btn" type="submit" style="width: 40px; height: 40px; background: none; border: none;">
                        <i class="fas fa-search text-dark"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->


<style>
    /* Ensure the modal search bar looks clean and matches the design */
.search-bar-modal {
    max-width: 600px;
    border-radius: 50px;
    background-color: #f8f9fa; /* Light background similar to the navbar search */
    padding: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.search-bar-modal .form-control {
    border: none;
    font-size: 14px;
    color: #6c757d;
}

.search-bar-modal .dropdown-toggle {
    font-size: 14px;
    color: #343a40; /* Text color for dropdown */
}

.search-bar-modal .dropdown-menu {
    font-size: 14px;
}

/* Align the search icon */
.search-bar-modal .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    color: #6c757d;
}

/* Ensure the modal is responsive */
@media (max-width: 768px) {
    .search-bar-modal {
        width: 100%;
    }
}

</style>



<script>
    function redirectToLogin() {
        window.location.href = "{{ route('login.page') }}";
    }


    function selectCategoryModal(categoryId, categoryName) {
    document.getElementById('modalCategoryLabel').innerText = categoryName;
    document.getElementById('modalCategoryInput').value = categoryId;
}

</script>


<style>
.nav-link {
    background: none !important;
    color: #ffffff !important; /* Use base color */
    font-weight: bolder;
    border: none !important;
}

.nav-item {
    border: none !important;
}

button {
    border: none !important;
    outline: none !important;
}

.tab-content {
    -ms-overflow-style: none !important; /* IE and Edge */
    scrollbar-width: none !important; /* Firefox */
}

.tab-content::-webkit-scrollbar {
    display: none !important;
}

/* Icons */
.bi {
    color: #ffffff; /* Use base color */
    font-size: 1.7em;
}

/* Hover effect for icons */
.bi:hover {
    color: #203435; /* Darken hover effect for contrast */
    font-size: 1.7em;
}

/* Active icon */
.nav-link.active .bi {
    color: #ffffff; /* Darker active color */
}

/* Ensure bottom bar appears when screen is below 991px */
@media (max-width: 991px) {
    .navbar {
        display: flex !important;
    }
}


/* Styling the user button */
#user-tab {
    background: none;
    border: none;
    color: #ffffff; /* White color */
    padding: 10px;
    cursor: pointer;
}

#user-tab:hover, #user-tab:focus {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

/* Styling the dropup menu */
.dropup .dropdown-menu {
    left: auto; /* Remove the hard alignment */
    right: 0; /* Align to the right edge of the button */
    position: absolute;
    min-width: 220px;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Arrow for the dropup, positioned based on the menu alignment */
.dropup .dropdown-menu::before {
    content: "";
    position: absolute;
    bottom: -5px;
    right: 15px; /* Adjust based on the dropdown alignment */
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent #ffffff transparent;
}

/* Profile info styling */
.dropup .dropdown-menu .d-flex.align-items-center {
    display: flex;
    align-items: center;
}

.dropup .dropdown-menu .d-flex img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* Dropdown item styling */
.dropup .dropdown-menu .dropdown-item {
    padding: 10px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.dropup .dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;
    border-radius: 5px;
}

.dropup .dropdown-menu .dropdown-item.text-danger {
    color: red;
    font-weight: bold;
}

/* Divider */
.dropdown-divider {
    margin: 0.5rem 0;
    border-top: 1px solid #e9ecef;
}

</style>