<nav class="navbar navbar-light navbar-expand rounded-pill mb-3 ms-3 me-3 fixed-bottom d-lg-none shadow"
    style="background: #38a3a5;">
    <ul class="nav nav-justified w-100" id="myTab" role="tablist">
        <!-- Home -->
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">
                <span><i class="bi bi-house-fill"></i></span>
            </button>
        </li>
         <!-- Cart -->
         <li class="nav-item" role="presentation">
            <button class="nav-link" id="cart-tab" data-bs-toggle="tab" data-bs-target="#cart" type="button"
                role="tab" aria-controls="cart" aria-selected="false">
                <span><i class="bi bi-bag-fill"></i></span>
            </button>
        </li>
        <!-- Search -->
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button"
                role="tab" aria-controls="search" aria-selected="false">
                <span><i class="bi bi-search"></i></span>
            </button>
        </li>
        <!-- Transactions -->
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button"
                role="tab" aria-controls="transactions" aria-selected="false">
                <span><i class="bi bi-receipt-cutoff"></i></span>
            </button>
        </li>
        <!-- User -->
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button"
                role="tab" aria-controls="user" aria-selected="false">
                <span><i class="bi bi-person-circle"></i></span>
            </button>
        </li>
    </ul>
</nav>


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

</style>