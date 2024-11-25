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
                    <h3 class="m-subheader__title m-subheader__title--separator"> Book Details </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('category-crud.index')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="javascript:;" class="m-nav__link">
                                <span class="m-nav__link-text">Book Details</span>
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
                                    Book Details
                                </h3>
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
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Title:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->name}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Author Name:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input"> {{$data->admin->name}} </p>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Description:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input" style="height: 100%"> {{$data->description}} </p>
                                            </div>
                                        </div>
                                        @if($data->total_time)
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Total Time:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <p class="form-control m-input" style="height: 100%"> {{$data->total_time}} </p>
                                                </div>
                                            </div>
                                        @endif
                                        @if($data->total_pages)
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Total Pages:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <p class="form-control m-input" style="height: 100%"> {{$data->total_pages}} </p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Ipad Image (2560 PX * 1440 PX):</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <img id="uploadPreview" style="width: 100%" src="{{url("/books/" . $data->ipad_image)}}" alt="No image" width="500" height="300" />
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Iphone Image (2415 PX * 664 PX):</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <img id="uploadPreview2" style="width: 100%" src="{{url("/books/" . $data->iphone_image)}}" alt="No image" width="500" height="300" />
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Status:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <b><p class="form-control m-input"> {{$data->status == 1 ? "Activated" : "In Active"}} </p></b>
                                            </div>
                                        </div>
                                        @if($data->type == "video")
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label">* Video:</label>
                                                <div class="col-xl-9 col-lg-9">
                                                    <video id="my-video" class="video-js" controls preload="auto" width="640" height="264" poster="MY_VIDEO_POSTER.jpg" data-setup="{}" >
                                                        <source src="{{($data->file_url) ? url("/books/" . $data->file_url) : url("/books/" . $data->file)}}" type="video/mp4" />
                                                        <p class="vjs-no-js">
                                                            To view this video please enable JavaScript, and consider upgrading to a web browser that!!
                                                            <a href="https://videojs.com/html5-video-support/" target="_blank" >supports HTML5 video</a>
                                                        </p>
                                                    </video>
                                                </div>
                                            </div>
                                        @else
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* PDF:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <a href="{{($data->file_url) ? url("/books/" . $data->file_url) : url("/books/" . $data->file)}}"> Click here to view PDF file!! </a>
                                            </div>
                                        </div>
                                        @endif
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
