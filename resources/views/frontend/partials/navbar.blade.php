    <!-- Navigation bar Start -->
    <section class="navigation-bar d-none d-sm-block">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light py-0">
                <a class="navbar-brand d-lg-none" href="#"><img class="img-fluid" width="44px" height="auto" src="{{asset('frontend/images/topbar-logo.png')}}"
                    alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link  {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="{{url('/')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom-links {{ Request::is('allcoupons*') ? 'active' : '' }}" href="http://arabcoupons.leadconcept.online/allcoupons?country_id=1">All Stores</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            All Categories
                            <img class="img-fluid ms-1" src="{{asset('frontend/images/dropdown-affter.png')}}" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-mega-menu prodduct-dropmenu"
                        aria-labelledby="dropdownMenuButton1">
                        <div class="container">
                            <div class="row gy-4">
                                @foreach($categories as $category)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                    <div class=" text-center">
                                        <a class="brand_category" data-category_id="{{$category->id}}">
                                            <img class="img-fluid catagory-images" src="{{asset($category->image_url)}}"
                                            alt=""></a>
                                                <a class="text-decoration-none brand_category" data-category_id="{{$category->id}}">
                                                <h6 class="mega-links mt-1">{{$category->name}}</h6>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link custom-links {{ Request::segment(2)== 25 ? 'active' : '' }}" href="http://arabcoupons.leadconcept.online/brands/25/1">Clothes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-links {{ Request::segment(2)== 32 ? 'active' : '' }}" href="http://arabcoupons.leadconcept.online/brands/32/1">Shoes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-links {{ Request::segment(2)== 38  ? 'active' : '' }}" href="http://arabcoupons.leadconcept.online/brands/38/1">Perfume</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-links {{ Request::segment(2)== 34 ? 'active' : '' }}" href="http://arabcoupons.leadconcept.online/brands/34/1">Electronics</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Support
                        <img class="img-fluid ms-1" src="{{asset('frontend/images/dropdown-affter.png')}}" alt="">
                    </a>
                    <ul class="dropdown-menu"  aria-labelledby="navbarDropdown">
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

                <!-- <li>
                     <div class="dropdown">
                        <button class="btn dropdown-toggle dropdown-contact show" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                            Contact Us
                        </button>
                        <ul class="dropdown-menu show" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 35px);" data-popper-placement="bottom-start">
                            <li><a class="dropdown-item" href="mailto:support@arab-coupon.net" style="color:black"><i class="fa fa-envelope"></i> Email</a></li>
                            <li><a class="dropdown-item" href="https://wa.me/966508738543" style="color:black"><i class="fa fa-whatsapp"></i> Whatsapp</a></li>
                        </ul>
                     </div>
                </li> -->
                <li class="nav-item">
                    <a class="submit-modal nav-link"  data-bs-toggle="modal" data-bs-target="#submitCoupon" href="#">
                        Submit Coupon
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
</section>
<!-- Navigation bar End -->

<!-- modal coupon start -->

<div class="modal fade submit-coupon" id="submitCoupon" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Submit Coupon</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container">
            <div class="col">
               <form id="add-coupon" action="{{ route('add-coupon') }}" method="POST"> <!-- Add your route name -->
                @csrf
                <div class="mb-3">
                    <!-- <select class="form-select" aria-label="Select Brand" id="brandSelect" name="brand_id">
                        <option selected>Select Brand</option>
                        Brands will be populated here based on the selected country
                    </select> -->

                    <!-- newcode -->
                    <input class="form-control" type="text" name="name" placeholder="Name of Brand">
                </div>

                <!-- <div class="mb-3">
                    <select class="form-select" aria-label="Select Category" name="category_id">
                        <option selected>Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                   
               
                </div> -->

                <div class="mb-3">
                    <input type="number" name="percentage" placeholder="Discount Percentage" class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="coupon_no" placeholder="Coupon Code" class="form-control" required>
                </div>

                <div class="mb-3">
                    <div class="">
                        <textarea placeholder="Detail (Optional)" rows="5" id="floatingTextarea" class="form-control" name="detail" ></textarea>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="rounded-pill  btn btn-primary submitcouponbtn">Submit Coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
    <!-- modal coupon start -->