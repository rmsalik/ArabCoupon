

@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<div class="content-bg-gray">
    <!-- Hero Section Start -->
    <section class="hero-sec m-3 m-sm-0">
        <div class="container position-relative">
            <div class="hro-overlay"></div>
            <div>
              <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($latest_brands as $index => $lbdata)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}" 
                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                    aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach($latest_brands as $index => $lbdata)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img class="img-fluid banne-image" src="{{ asset($lbdata->profile_image_url) }}" 
                        class="d-block w-100" alt="...">
                        <div class="carousel-caption text-center text-md-start px-3 px-md-l-0">
                            <h5 class="hero-content-frnt">{{trim($lbdata['coupons'][0]->description)}}</h5>
                            <h1 class="fw-bold hero-content-frnt">Save {{$lbdata['coupons'][0]->percentage}}% with {{$lbdata->name}}</h1>
                            <div>
                                <button class="shop-now"><a href="{{$lbdata['coupons'][0]->url_link}}" style="text-decoration:none;color:inherit;" target="_blank">Shop Now</a></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" 
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" 
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div>
</div>
</section>
<!-- Hero Section End -->

<!-- Stores Section start -->
<section class="stores-main-sec">
    <div class="container">
        <div class="d-flex mt-5 mb-3 align-items-center justify-content-between">
            <h3 class="fw-bold lrg-srn-text" id="brand_count">({{$brandCount}}) Stores</h3>
            <!-- <div class="d-flex align-items-center gap-3">
                <a href="javascript:void(0)"><img class="img-fluid" src="{{asset('frontend/images/dashboard-icon.png')}}" alt=""></a>
                <a href="javascript:void(0)"><img class="img-fluid" src="{{asset('frontend/images/burger-lines.png')}}" alt=""></a>
            </div> -->
        </div>
        <div class="row g-3 g-sm-4" id="brandContainer">
            @foreach($brands as $bdata)
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                <div class="mini-cards bg-white">
                    <a class="text-decoration-none" href="{{ route('brand.offers', ['id' => $bdata->id, 'country_id' => $bdata->country_id]) }}" style=" color:inherit" target="_blank">
                        <div class="imni-card-image">
                            <img class="img-fluid" src="{{ asset($bdata->profile_image_url) }}"  alt="">
                        </div>
                        <h5 class="fw-bold text-center my-3 black-color mob-head">{{ $bdata->name }}</h5>
                    </a>
                    <div class="text-center py-1">
                        <span class="persentage">
                            <!-- <img class="img-fluid me-1" src="{{ asset('frontend/images/persentage-sign.png') }}" alt=""> -->
                            <svg class="me-1" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1_1769)">
                                    <path d="M4.80732 12.2601C5.17671 12.2601 5.36141 12.2601 5.52967 12.3225C5.55304 12.3311 5.57607 12.3407 5.59873 12.3511C5.76186 12.4259 5.89246 12.5565 6.15366 12.8177C6.75487 13.4189 7.05544 13.7195 7.42531 13.7472C7.475 13.7509 7.525 13.7509 7.57469 13.7472C7.94456 13.7195 8.24519 13.4189 8.84631 12.8177C9.10756 12.5565 9.23812 12.4259 9.40125 12.3511C9.42394 12.3407 9.44694 12.3311 9.47031 12.3225C9.63862 12.2601 9.82331 12.2601 10.1927 12.2601H10.2608C11.2032 12.2601 11.6745 12.2601 11.9672 11.9672C12.2601 11.6745 12.2601 11.2032 12.2601 10.2608V10.1927C12.2601 9.82331 12.2601 9.63862 12.3225 9.47031C12.3311 9.44694 12.3407 9.42394 12.3511 9.40125C12.4259 9.23812 12.5565 9.10756 12.8177 8.84631C13.4189 8.24519 13.7195 7.94456 13.7472 7.57469C13.7509 7.525 13.7509 7.475 13.7472 7.42531C13.7195 7.05544 13.4189 6.75487 12.8177 6.15366C12.5565 5.89246 12.4259 5.76186 12.3511 5.59873C12.3407 5.57607 12.3311 5.55304 12.3225 5.52967C12.2601 5.36141 12.2601 5.17671 12.2601 4.80732V4.73918C12.2601 3.79674 12.2601 3.32552 11.9672 3.03274C11.6745 2.73996 11.2032 2.73996 10.2608 2.73996H10.1927C9.82331 2.73996 9.63862 2.73996 9.47031 2.67753C9.44694 2.66886 9.42394 2.65932 9.40125 2.64892C9.23812 2.57409 9.10756 2.44349 8.84631 2.18229C8.24519 1.58111 7.94456 1.28051 7.57469 1.25279C7.525 1.24907 7.475 1.24907 7.42531 1.25279C7.05544 1.28051 6.75487 1.58111 6.15366 2.18229C5.89246 2.44349 5.76186 2.57409 5.59873 2.64892C5.57607 2.65932 5.55304 2.66886 5.52967 2.67753C5.36141 2.73996 5.17671 2.73996 4.80732 2.73996H4.73918C3.79674 2.73996 3.32552 2.73996 3.03274 3.03274C2.73996 3.32552 2.73996 3.79674 2.73996 4.73918V4.80732C2.73996 5.17671 2.73996 5.36141 2.67753 5.52967C2.66886 5.55304 2.65932 5.57607 2.64892 5.59873C2.57409 5.76186 2.44349 5.89246 2.18229 6.15366C1.58111 6.75487 1.28051 7.05544 1.25279 7.42531C1.24907 7.475 1.24907 7.525 1.25279 7.57469C1.28051 7.94456 1.58111 8.24519 2.18229 8.84631C2.44349 9.10756 2.57409 9.23812 2.64892 9.40125C2.65932 9.42394 2.66886 9.44694 2.67753 9.47031C2.73996 9.63862 2.73996 9.82331 2.73996 10.1927V10.2608C2.73996 11.2032 2.73996 11.6745 3.03274 11.9672C3.32552 12.2601 3.79674 12.2601 4.73918 12.2601H4.80732Z" stroke="white" stroke-width="1.5"/>
                                    <path d="M9.375 5.625L5.625 9.375" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.375 9.375H9.36825M5.63173 5.625H5.625" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_1_1769">
                                        <rect width="15" height="15" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            {{ $bdata->percentage }}%
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="text-center">
            <button class="see-all-btn my-5" id="view_all" onclick="redirectToAllCoupons()">View all stores</button>
        </div>
    </div>
</section>
<!-- Stores Section End -->
</div>


<!-- Modal start -->
<!-- Button trigger modal -->





<!-- Latest coupons Start -->
<section class="latest-coupons-sec my-4 my-md-5 py-0 py-md-4">
    <div class="container">
        <h3 class="fw-bold mb-4 lrg-srn-text">Latest Coupons</h3>
        <div class="row g-3 g-sm-4" id="latest_brands">

            @foreach($latest_brands as $lbdata)
            <div class="col-6 col-sm-6 col-md-6 col-lg-3">

                <div class="mini-cards bg-white drop-shadow">
                    <div class="imni-card-image">
                        @if ($lbdata->coupons->isNotEmpty())
                        <img id="get_code" 
                        data-name="{{ $lbdata->coupons[0]->name }}"
                        data-coupon_id="{{ $lbdata->coupons[0]->id }}"
                        data-description="{{ $lbdata->coupons[0]->description }}"
                        data-coupon_no="{{ $lbdata->coupons[0]->coupon_no }}"
                        data-percentage="{{ $lbdata->coupons[0]->percentage }}"
                        data-profile_image_url="{{ $lbdata->profile_image_url }}"
                        class="img-fluid" 
                        data-bs-toggle="modal" 
                        data-bs-target="#staticBackdrop"
                        src="{{ asset($lbdata->profile_image_url) }}" 
                        data-store_link="{{ $lbdata->coupons[0]->url_link ?? '' }}"
                        style="cursor: pointer;" 
                        alt="">
                        @else
                        <img src="{{ asset('path/to/default/image.png') }}" alt="No Image" class="img-fluid">
                        @endif
                    </div> 

                    <p class="text-center my-3"
                    data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                    id="get_code" 
                    data-name="{{ $lbdata->coupons[0]->name }}"
                    data-coupon_id="{{ $lbdata->coupons[0]->id }}"
                    data-description="{{ $lbdata->coupons[0]->description }}"
                    data-coupon_no="{{ $lbdata->coupons[0]->coupon_no }}"
                    data-percentage="{{ $lbdata->coupons[0]->percentage }}"
                    data-profile_image_url="{{ $lbdata->profile_image_url }}"
                    data-store_link="{{ $lbdata->coupons[0]->url_link ?? '' }}"
                    style="cursor: pointer;">{{ $lbdata->name }} Global coupon code ({{ $lbdata->coupons[0]->coupon_no }}) with best... </p>
                    <div class="text-center py-1">
                        <button class="get-code-btn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#staticBackdrop" 
                        data-coupon_id="{{ $lbdata->coupons[0]->id }}"
                        data-name="{{ $lbdata->coupons->isNotEmpty() ? $lbdata->coupons[0]->name : '' }} "
                        data-description="{{ $lbdata->coupons->isNotEmpty() ? $lbdata->coupons[0]->description : '' }}"
                        data-coupon_no="{{ $lbdata->coupons->isNotEmpty() ? $lbdata->coupons[0]->coupon_no : '' }}"
                        data-store_link="{{ $lbdata->coupons[0]->url_link ?? '' }}"
                        data-percentage="{{ $lbdata->coupons->isNotEmpty() ? $lbdata->coupons[0]->percentage : '' }}"
                        data-profile_image_url="{{ $lbdata->profile_image_url }}">
                        Get Code 
                    </button>
                    <!-- {{$lbdata->coupons[0]->url_link}} -->
                </div>
            </div>

        </div>
        @endforeach

    </div>
</div>
</section>
<!-- Latest coupons End -->




@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all nav links
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        // Add click event listener to each nav link
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove 'active' class from all nav links
                navLinks.forEach(nav => nav.classList.remove('active'));

                // Add 'active' class to the clicked nav link
                this.classList.add('active');
            });
        });
    });
</script>
