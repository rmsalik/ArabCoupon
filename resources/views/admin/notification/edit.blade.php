@extends('admin.layout')
@section('page-section')

<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Notification</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('notification.create')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text">Update Notification</span>
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
                                    Send New Notification
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{route('notification.create')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                                <span>
                                    <i class="la la-arrow-left"></i>
                                    <span>Clear</span>
                                </span>
                            </a>
                            <div class="btn-group">
                                <button type="submit" form="m_form" class="btn btn-accent  m-btn m-btn--icon m-btn--wide m-btn--md">
                                    <span>
                                        <i class="la la-check"></i>
                                        <span>Send Notification</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form class="m-form m-form--label-align-left- m-form--state-" method="post" action="{{route('notification.update',$getData)}}" id="m_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @method('PUT')

                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Notification Details</h3>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Title:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="title" required="" class="form-control m-input" placeholder="" value="{{$getData->title}}">
                                                <span class="m-form__help">Please enter title</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Message:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <textarea name="message" required="" class="form-control m-input">{{$getData->message}}</textarea>
                                                <span class="m-form__help">Please enter message</span>
                                            </div>
                                        </div>
                                        
                                        <!--<div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Image:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <img id="uploadPreview" width="" height="" />
                                                <input type="file" id="uploadImage" name="picture" class="form-control m-input" onchange="PreviewImage();" />
                                                <span class="m-form__help">Select image</span>
                                            </div>
                                        </div>-->
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


@endsection
