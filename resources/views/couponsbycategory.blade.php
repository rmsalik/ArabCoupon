@extends('layouts.app')
@section('title', 'Brands Category')

@section('content')
<div class="content-bg-gray">
    <!-- Hero Section Start -->

<!-- All Coupons Section start -->
<section class="stores-main-sec">
    <div class="container">
        <div class="d-flex mt-5 mb-3 align-items-center justify-content-between">
            <h3 class="fw-bold lrg-srn-text" id="brand_count">({{$brandCount}}) Stores</h3>
            <!-- <div class="d-flex align-items-center gap-3">
                <a href="javascript:void(0)"><img class="img-fluid" src="{{asset('frontend/images/dashboard-icon.png')}}" alt=""></a>
                <a href="javascript:void(0)"><img class="img-fluid" src="{{asset('frontend/images/burger-lines.png')}}" alt=""></a>
            </div> -->
        </div>
        <div class="row gy-4" id="brandContainer">
         @if(empty($brands))
    <div class="col-12">
        <p class="text-center my-3">No brand found.</p>
    </div>
@else
    @foreach($brands as $bdata)
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <div class="mini-cards bg-white">
            <a class="text-decoration-none" href="{{ route('brand.offers', ['id' => $bdata->id, 'country_id' => $bdata->country_id]) }}" style="text-emphasis: decoration none;color:inherit" target="_blank">
                <div class="imni-card-image">
                    <img class="img-fluid" src="{{ asset('admin_uploads/' .$bdata->profile_image_url) }}" alt="">
                </div>
                <h5 class="fw-bold text-center my-3 black-color mob-head">{{ $bdata->name }}</h5>
                </a>
                <div class="text-center py-1">
                    <span class="persentage">
                        <img class="img-fluid me-1" src="{{ asset('frontend/images/persentage-sign.png') }}" alt=""> {{ $bdata->percentage }}% off
                    </span>
                </div>
            </div>
        </div>
    @endforeach
@endif

                
                </div>
            
            </div>
        </section>

<!-- All Coupons Section end -->
</div>

@endsection