@extends('admin.layout')
@section('page-section')
<head>
    <link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />
        <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
        <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    </head>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator"> Booking Details </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('booking-crud.index')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="javascript:;" class="m-nav__link">
                                <span class="m-nav__link-text">Booking Details</span>
                            </a>
                        </li>
                    </ul>
                </div>
    </div>
</div>

<!-- END: Subheader -->
<div class="m-content">
    <div class="row">
        <div class="col-lg-12">

            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-progress">

                        <!-- here can place a progress bar-->
                    </div>
                    <div class="m-portlet__head-wrapper">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Booking Details
                                </h3>
                            </div>
                            <div class="m-portlet__head-tools">
                            <a href="{{ url('generate-pdf')}}/{{$data->id}}" class="btn btn-accent m-btn m-btn--icon m-btn--wide m-btn--md m--margin-left-100">
                                <span>
                                    <i class="la la-download"></i>
                                    <span>Download Invoice</span>
                                </span>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form class="m-form m-form--label-align-left- m-form--state-" method="" action="" id="m_form" enctype="multipart/form-data">
                        
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                
                                
                                <div class="col-xl-8 offset-xl-2">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Car Images:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                @foreach($data->item->images as $location)
                                                    <img src="{{ $location->name }}" width="120px" height="100px">
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Customer Name:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->user->full_name}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Car Name</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->item->title}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Car Number</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->item->car_number}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Car Model</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->item->car_model}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Trip Days</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{Carbon\Carbon::createFromFormat('Y-m-d', $data->start_date)->format('F d')}} - {{Carbon\Carbon::createFromFormat('Y-m-d', $data->end_date)->format('F d')}}. {{ ceil(abs(strtotime($data->end_date) - strtotime($data->start_date)) / 86400) }} Days Trip </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Booked Date & Time</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->created_at}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Booking Type</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->location_type}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Pickup Address</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->pickup_location}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Dropoff Location</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->drop_location}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Total Amount</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> ${{$data->price}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Payment Type</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->payment_type}} </p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Status:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <b><p class="form-control m-input"> {{$data->status == 1 ? "Confirmed" : "Cancelled"}} </p></b>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> Before Images:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                @foreach($data->before_image as $location)
                                                    <img src="{{ $location->name }}" width="120px" height="100px">
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label"> After Images:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                @foreach($data->after_image as $location)
                                                    <img src="{{ $location->name }}" width="120px" height="100px">
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!--end::Portlet-->
        </div>
    </div>
</div>
<script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>
@endsection
