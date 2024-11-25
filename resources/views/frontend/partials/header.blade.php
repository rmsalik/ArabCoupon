    @php 

    $country=\App\Models\Country::all();

    @endphp
    <!-- Desktop header Start -->
    <header class="header-main-sec d-none d-sm-block">
        <div class="topbar py-3 py-md-2">
            <div class="container">
                <div class="row align-items-center flex-wrap">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                        <div class="topbar-left-sec d-flex align-items-center gap-2 gap-sm-5">


                            <a class="update-logo" href="{{url('/')}}" style="text-decoration:none; color:inherit;">
                                <img class="img-fluid" width="44px" height="44px" src="{{asset('frontend/images/topbar-logo.png')}}" alt="">
                            </a>

                         <!--    <a href="{{url('/')}}" style="text-decoration:none;color:inherit">
                                <img class="img-fluid" src="{{asset('frontend/images/topbar-logo.png')}}" alt="">
                            </a> -->

                            <div class="topbar-serch-sec position-relative w-100 d-none d-sm-block">
                                <i class="fa fa-search position-absolute top-2 left-5"></i>
                                <input type="text" class="form-control" id="coupons_search"
                                placeholder="Store, offer, category">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 d-none d-sm-block">
                        <div
                        class="topbar-right-sec d-flex align-items-center gap-3 mt-3 mt-md-0 flex-wrap justify-content-center">
                        <div class="countary-sec d-flex align-items-center gap-sm-2">
                         <div class="d-flex align-items-center gap-sm-2 countary-main-sec">
                            <button class="btn dropdown-toggle text-white countary-btn" id="countryDropdown" aria-expanded="false">
                                <img id="selectedFlag" src="{{ asset($country[0]->image_url) }}" alt="Flag" style="display: inline;">
                                <span id="selectedCountry">{{ $country[0]->name }}</span>
                            </button>

                            <ul class="dropdown-menu" id="countryMenu">
                                @foreach ($country as $index => $c)
                                <li class="country-option" data-country-id="{{ $c->id }}" data-country="{{ $c->name }}" data-flag="{{ asset($c->image_url) }}">
                                    <img src="{{ asset($c->image_url) }}" alt="{{ $c->name }} Flag"> {{ $c->name }}
                                </li>
                                @if (!$loop->last)
                                <hr style="background-color: rgb(163 162 162); margin: 0 !important;">
                                @endif
                                @endforeach
                            </ul>
                        </div>


                        <!-- Selected country display at the bottom -->
                        <div class="mt-4">
                            <div class="selected-country">
                                <img class="img-fluid" id="selectedFlag"
                                src="https://cdn.countryflags.com/thumbs/kuwait/flag-400.png"
                                alt="Selected Country">
                                <span id="selectedCountry">Kuwait</span>
                            </div>
                        </div>
                    </div>
                    <div class="language-sec">
                        <div class="language-icon d-flex align-items-center gap-2">
                            <i class="bi bi-globe2" style="color:white; font-size:20px;"></i>
                            <div class="language-sec d-flex align-items-center gap-sm-2">
                                <button class="language-head border-0 bg-transparent dropdown-toggle text-white" id="languageDropdown" aria-expanded="false">
                                    <span id="selectedLanguage">English</span>
                                </button>
                                <ul class="dropdown-menu" id="languageMenu" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc; padding: 10px;">
                                    <li class="select-language" data-language="English">English</li>
                                    <li class="select-language" data-language="Arabic">Arabic</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 mx-auto d-none d-sm-block">
                <div
                class="iphons-btn-sec d-flex align-items-center gap-3 mt-3 flex-wrap flex-lg-nowrap mt-lg-0 justify-content-center justify-content-lg-end">
                <button><a style="text-decoration: none;color: inherit;" href="https://apps.apple.com/sa/app/arab-coupon-promo-codes/id6446092637" target="_blank"><i class="fa fa-apple" style="font-size: 20px; color: black;"></i>IPhone</a></button>
                <button><a style="text-decoration: none;color: inherit;" href="https://play.google.com/store/apps/datasafety?id=app.arabcoupon&pli=1" target="_blank"><i class="fa fa-android" style="font-size: 22px; color: black;"></i>Android</a></button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</header>
<!-- Desktop header End -->





<!-- Mobile header Start -->
<header class="header-main-sec d-sm-none">
    <div class="topbar py-2 ">
        <div class="container">
            <div class="row align-items-center flex-wrap">
                <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                    <div class="topbar-left-sec d-flex align-items-center gap-2 gap-sm-5">


                      <a class="update-logo" href="{{url('/')}}" style="text-decoration:none; color:inherit;">
                        <img class="img-fluid" width="44px" height="44px" src="{{asset('frontend/images/topbar-logo.png')}}" alt="">
                    </a>


                           <!--  <a href="{{url('/')}}" style="text-decoration:none;color:inherit">
                                <img class="img-fluid" src="{{asset('frontend/images/topbar-logo.png')}}" alt="">
                            </a> -->




                         <!--  <div class="topbar-serch-sec mobile-input position-relative w-100 d-sm-none">
                                <i class="fa fa-search position-absolute top-2 left-5 insid-search-icon"></i>
                                <input type="search" class=" mbl-control" id="coupons_search" placeholder="Store, offer, category">
                            </div>
                            <i class="mobile-search fa fa-search left-5 text-white"></i>
                        -->

                        <div class="topbar-serch-sec mobile-input position-relative w-100">
                            <i class="fa fa-search position-absolute top-2 left-5 insid-search-icon"></i>
                            <input type="text" class="form-control coupons_search" id="coupons_search_mobile"
                            placeholder="Store, offer, category">

                        </div>
                        <i class="mobile-search fa fa-search left-5 text-white"></i>

                        <div class="topbar-serch-sec position-relative d-flex align-items-center justify-content-end gap-3 d-sm-none">
                            <!-- <i class="fa fa-search left-5 text-white"></i> -->
                            <header class="mobile-header">
                                <button class="btn border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_443_120)">
                                            <path d="M3.125 10H16.875" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M3.125 5H16.875" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M3.125 15H16.875" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_443_120">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                </button>
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                    <div class="offcanvas-header px-4 py-3 align-items-center justify-content-between">
                                        <button type="button" class="text-reset m-0 border-0 bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.1693 9.99528L14.748 6.42469C15.0743 6.09833 15.0743 5.56919 14.748 5.24282C14.4216 4.91646 13.8925 4.91646 13.5662 5.24282L9.99585 8.82173L6.42552 5.24282C6.09918 4.91646 5.57008 4.91646 5.24374 5.24282C4.91739 5.56919 4.91739 6.09833 5.24374 6.42469L8.82239 9.99528L5.24374 13.5659C5.08618 13.7221 4.99756 13.9349 4.99756 14.1568C4.99756 14.3787 5.08618 14.5915 5.24374 14.7477C5.4 14.9053 5.61272 14.9939 5.83463 14.9939C6.05654 14.9939 6.26926 14.9053 6.42552 14.7477L9.99585 11.1688L13.5662 14.7477C13.7225 14.9053 13.9352 14.9939 14.1571 14.9939C14.379 14.9939 14.5917 14.9053 14.748 14.7477C14.9055 14.5915 14.9942 14.3787 14.9942 14.1568C14.9942 13.9349 14.9055 13.7221 14.748 13.5659L11.1693 9.99528Z" fill="white" />
                                            </svg>
                                        </button>
                                        <p class="mb-0 menu-head ">Menu</p>

                                        <button type="button" class="text-reset m-0 border-0 bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa fa-search left-5 text-white mobile-search"></i></button>
                                    </div>
                                    <div class="offcanvas-body p-0">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center gap-2  {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="{{url('/')}}">

                                                    <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_582_12037)">
                                                            <path d="M9.99999 11.3335C9.46699 11.7484 8.76685 12.0002 7.99999 12.0002C7.23319 12.0002 6.53302 11.7484 6 11.3335" stroke="#F61A38" stroke-width="1.5" stroke-linecap="round" />
                                                            <path d="M1.56727 8.80867C1.33192 7.27714 1.21425 6.51143 1.50379 5.83259C1.79332 5.15375 2.43569 4.68929 3.72043 3.76038L4.68033 3.06634C6.27853 1.91079 7.07766 1.33301 7.99966 1.33301C8.92173 1.33301 9.72079 1.91079 11.319 3.06634L12.2789 3.76038C13.5637 4.68929 14.2061 5.15375 14.4956 5.83259C14.7851 6.51143 14.6675 7.27714 14.4321 8.80867L14.2314 10.1146C13.8978 12.2856 13.7309 13.3711 12.9523 14.0187C12.1737 14.6663 11.0355 14.6663 8.75886 14.6663H7.24046C4.9639 14.6663 3.82561 14.6663 3.04701 14.0187C2.2684 13.3711 2.10159 12.2856 1.76796 10.1146L1.56727 8.80867Z" stroke="#F61A38" stroke-width="1.5" stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_582_12037">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    Home
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link d-flex align-items-center justify-content-between gap-2 {{ Request::is('allcoupons*') ? 'active' : '' }}" href="http://arabcoupons.leadconcept.online/allcoupons?country_id=1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_582_12126)">
                                                                <path d="M3 8.72461V13.5002H13V8.72461" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M3.375 2.5H12.625C12.7336 2.50002 12.8393 2.53541 12.926 2.60081C13.0127 2.66621 13.0758 2.75807 13.1056 2.8625L14 6H2L2.89625 2.8625C2.92603 2.75838 2.98881 2.66675 3.07514 2.60137C3.16148 2.536 3.26671 2.50043 3.375 2.5Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M6 6V7C6 7.53043 5.78929 8.03914 5.41421 8.41421C5.03914 8.78929 4.53043 9 4 9C3.46957 9 2.96086 8.78929 2.58579 8.41421C2.21071 8.03914 2 7.53043 2 7V6" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M10 6V7C10 7.53043 9.78929 8.03914 9.41421 8.41421C9.03914 8.78929 8.53043 9 8 9C7.46957 9 6.96086 8.78929 6.58579 8.41421C6.21071 8.03914 6 7.53043 6 7V6" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M14 6V7C14 7.53043 13.7893 8.03914 13.4142 8.41421C13.0391 8.78929 12.5304 9 12 9C11.4696 9 10.9609 8.78929 10.5858 8.41421C10.2107 8.03914 10 7.53043 10 7V6" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_582_12126">
                                                                    <rect width="16" height="16" fill="white" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg>

                                                        All Stores
                                                    </div>
                                                    <img class="img-fluid ms-1 chevron-right" src="{{asset('frontend/images/mobile-chevron-right.png')}}" alt="">
                                                </a>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link d-flex align-items-center justify-content-between dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="d-flex align-items-center gap-2">

                                                    <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_582_12135)">
                                                            <path d="M2.5 8H13.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.5 4H13.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.5 12H13.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_582_12135">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    Categories
                                                </div>
                                                <img class="img-fluid ms-1 chevron-right" src="{{asset('frontend/images/mobile-chevron-right.png')}}" alt="">
                                                <img class="img-fluid ms-1 dropdown-after d-none" src="{{asset('frontend/images/dropdown-affter.png')}}" alt="">
                                            </a>
                                            <div class="dropdown-menu dropdown-mega-menu prodduct-dropmenu"
                                            aria-labelledby="dropdownMenuButton1">
                                            <div class="container">
                                                @foreach($categories as $category)
                                                <div>
                                                    <a class="brand_category text-decoration-none" data-category_id="{{$category->id}}">
                                                        <h6 class="mega-links mt-1">{{$category->name}}</h6>
                                                    </a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link d-flex align-items-center justify-content-between dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="d-flex align-items-center gap-2">

                                            <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_582_12142)">
                                                    <path d="M14 12.5V13C14 13.5304 13.7893 14.0391 13.4142 14.4142C13.0391 14.7893 12.5304 15 12 15H8.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M14 8H12C11.7348 8 11.4804 8.10536 11.2929 8.29289C11.1054 8.48043 11 8.73478 11 9V11.5C11 11.7652 11.1054 12.0196 11.2929 12.2071C11.4804 12.3946 11.7348 12.5 12 12.5H14V8ZM14 8C14 7.21207 13.8448 6.43185 13.5433 5.7039C13.2417 4.97595 12.7998 4.31451 12.2426 3.75736C11.6855 3.20021 11.0241 2.75825 10.2961 2.45672C9.56815 2.15519 8.78793 2 8 2C7.21207 2 6.43185 2.15519 5.7039 2.45672C4.97595 2.75825 4.31451 3.20021 3.75736 3.75736C3.20021 4.31451 2.75825 4.97595 2.45672 5.7039C2.15519 6.43185 2 7.21207 2 8M2 8V11.5C2 11.7652 2.10536 12.0196 2.29289 12.2071C2.48043 12.3946 2.73478 12.5 3 12.5H4C4.26522 12.5 4.51957 12.3946 4.70711 12.2071C4.89464 12.0196 5 11.7652 5 11.5V9C5 8.73478 4.89464 8.48043 4.70711 8.29289C4.51957 8.10536 4.26522 8 4 8H2Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_582_12142">
                                                        <rect width="16" height="16" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            Support
                                        </div>
                                        <img class="img-fluid ms-1 chevron-right" src="{{asset('frontend/images/mobile-chevron-right.png')}}" alt="">
                                        <img class="img-fluid ms-1 dropdown-after d-none" src="{{asset('frontend/images/dropdown-affter.png')}}" alt="">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li class="me-0">
                                            <a class="dropdown-item d-flex gap-2 align-items-center" href="mailto:support@arab-coupon.net" style="color:black">
                                                <!-- <i class="fa fa-envelope"></i> -->
                                                <img src="{{asset('frontend/images/mails-img.png')}}" width="33px" height="auto" alt="maile">Email</a>
                                            </li>
                                            <li class="me-0">
                                                <a class="dropdown-item d-flex gap-2 align-items-center" href="https://wa.me/966508738543" style="color:black">
                                                    <!-- <i class="fa fa-whatsapp"></i> -->
                                                    <img src="{{asset('frontend/images/whatsapp-img.png')}}" width="33px" height="auto" alt="whatsapp">Whatsapp</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link d-flex align-items-center justify-content-between dropdown-toggle" href="#" data-bs-toggle="modal" data-bs-target="#submitCoupon">
                                                <div class="d-flex align-items-center gap-2">

                                                    <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_582_12148)">
                                                            <path d="M3.40375 12.5962C2.82875 12.0212 3.21 10.8131 2.9175 10.1056C2.61375 9.375 1.5 8.78125 1.5 8C1.5 7.21875 2.61375 6.625 2.9175 5.89437C3.21 5.1875 2.82875 3.97875 3.40375 3.40375C3.97875 2.82875 5.1875 3.21 5.89437 2.9175C6.62812 2.61375 7.21875 1.5 8 1.5C8.78125 1.5 9.375 2.61375 10.1056 2.9175C10.8131 3.21 12.0212 2.82875 12.5962 3.40375C13.1712 3.97875 12.79 5.18687 13.0825 5.89437C13.3863 6.62812 14.5 7.21875 14.5 8C14.5 8.78125 13.3863 9.375 13.0825 10.1056C12.79 10.8131 13.1712 12.0212 12.5962 12.5962C12.0212 13.1712 10.8131 12.79 10.1056 13.0825C9.375 13.3863 8.78125 14.5 8 14.5C7.21875 14.5 6.625 13.3863 5.89437 13.0825C5.1875 12.79 3.97875 13.1712 3.40375 12.5962Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M6 7C6.55228 7 7 6.55228 7 6C7 5.44772 6.55228 5 6 5C5.44772 5 5 5.44772 5 6C5 6.55228 5.44772 7 6 7Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M10 11C10.5523 11 11 10.5523 11 10C11 9.44772 10.5523 9 10 9C9.44772 9 9 9.44772 9 10C9 10.5523 9.44772 11 10 11Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M5.5 10.5L10.5 5.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_582_12148">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    Submit Coupon
                                                </div>
                                                <img class="img-fluid ms-1" src="{{asset('frontend/images/mobile-chevron-right.png')}}" alt="">
                                                <!-- <img class="img-fluid ms-1 dropdown-after d-none" src="{{asset('frontend/images/dropdown-affter.png')}}" alt=""> -->
                                            </a>

                                        </li>
                                        <li class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#countarypick" style="cursor: pointer;">
                                            <div class="countary-sec d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">

                                                    <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_582_12215)">
                                                            <path d="M2 8H14" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M10.5 8C10.5 12 8 14 8 14C8 14 5.5 12 5.5 8C5.5 4 8 2 8 2C8 2 10.5 4 10.5 8Z" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_582_12215">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    Country
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end w-100">
                                                    <div class="d-flex align-items-center gap-sm-2 countary-main-sec">
                                                        <button class="btn dropdown-toggle px-0 w-100 countary-btn" id="countryDropdown" aria-expanded="false">

                                                            <span id="selectedCountry" class="selectedCountry">{{ $country[0]->name }}</span>
                                                            <img class="img-fluid ms-2 chevron-right" src="{{asset('frontend/images/mobile-chevron-right.png')}}" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Selected country display at the bottom -->
                                                <div class="mt-4">
                                                    <div class="selected-country">
                                                        <img class="img-fluid" id="selectedFlag"
                                                        src="https://cdn.countryflags.com/thumbs/kuwait/flag-400.png"
                                                        alt="Selected Country">
                                                        <span id="selectedCountry">Kuwait</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>


                                        <li class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#languageSelect" style="cursor: pointer;">
                                            <div class="countary-sec d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">

                                                    <svg class="link-icons-sec" width="30" height="30" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_582_12170)">
                                                            <path d="M15 13.5L11.5 6.5L8 13.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M9 11.5H14" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M6 2V3.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2 3.5H10" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M8 3.5C8 5.0913 7.36786 6.61742 6.24264 7.74264C5.11742 8.86786 3.5913 9.5 2 9.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M4.3418 5.5C4.75546 6.67001 5.52173 7.68297 6.53507 8.39935C7.5484 9.11572 8.75894 9.50026 9.99992 9.5" stroke="#F61A38" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_582_12170">
                                                                <rect width="16" height="16" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    Language
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end w-100">
                                                    <div class="d-flex align-items-center gap-sm-2 countary-main-sec">
                                                        <button class="btn dropdown-toggle px-0 w-100 countary-btn" id="langDropdown" aria-expanded="false">
                                                         
                                                            <span>English</span>
                                                            <img class="img-fluid ms-2 chevron-right" src="{{asset('frontend/images/mobile-chevron-right.png')}}" alt="" />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                    <div>
                                        <h5 class="app-head px-4 mt-3">Get the app</h5>
                                        <div class=" d-flex align-items-center gap-3 mx-4 mt-3">
                                            <button class="mbl-app-btn mb-3">
                                                <a style="text-decoration: none;color: inherit;" href="https://apps.apple.com/sa/app/arab-coupon-promo-codes/id6446092637" target="_blank">
                                                    <i class="fa fa-apple" style="font-size: 20px; color: black;"></i>
                                                    iPhone
                                                </a>
                                            </button> 
                                            <button class="mbl-app-btn mb-3">
                                                <a style="text-decoration: none;color: inherit;" href="https://play.google.com/store/apps/datasafety?id=app.arabcoupon&amp;pli=1" target="_blank">
                                                    <i class="fa fa-android" style="font-size: 22px; color: black;"></i>
                                                    Android
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</header>
<!-- Mobile header End -->

<!-- modal countarypick start -->
<div class="modal fade" id="countarypick" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <button type="button" class="border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.0005 5.5L5.00049 19.5M5.00049 5.5L19.0005 19.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button type="button" class="save-btn">
                    Save
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="header-main-sec">
                    <ul class="dropdown-menu border-0 show position-relative" id="countryMenu">
                        @foreach ($country as $index => $c)
                        <li class="country-option justify-content-between" data-country-id="{{ $c->id }}" data-country="{{ $c->name }}" data-flag="{{ asset($c->image_url) }}">
                            <div>
                                <img src="{{ asset($c->image_url) }}" alt="{{ $c->name }} Flag">
                                {{ $c->name }}
                            </div>
                            <input class="form-check-input" type="radio" data-country-id="{{ $c->id }}" name="country" id="flexRadioDefault1" />
                        </li>
                        @if (!$loop->last)
                        <hr style="background-color: rgb(163 162 162); margin: 0 !important;">
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal countarypick start -->




<!-- modal Language Select Start -->
<div class="modal fade" id="languageSelect" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <button type="button" class="border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.0005 5.5L5.00049 19.5M5.00049 5.5L19.0005 19.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button type="button" class="save-btn save-btn-lang">
                    Save
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="header-main-sec">
                    <ul class="dropdown-menu border-0 show position-relative" id="countryMenu">
                        <li class="country-option justify-content-between">
                            <h6 class="mb-0 language">English</h6>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        </li>
                        <hr style="background-color: rgb(163 162 162); margin: 0 !important;">
                        <li class="country-option justify-content-between">
                            <h6 class="mb-0 language">Arabic</h6>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        </li>
                        <hr style="background-color: rgb(163 162 162); margin: 0 !important;">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- modal Language Select Ed -->