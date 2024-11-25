@extends('admin.layout')
@section('page-section')
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> About Us </h3>
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
                                    About Us
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary  m-btn m-btn--icon m-btn--wide m-btn--md" href="{{route('about-us-edit')}}" role="button">
                            <span>
                                <i class="la"></i>
                                <span> Edit </span>
                            </span>
                        </a>
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
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Description:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <p class="form-control m-input" style="height: 100%"> {{$data->description}} </p>
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
@endsection
