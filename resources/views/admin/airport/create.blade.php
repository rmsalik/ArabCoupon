@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> Airports </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('airport-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text">Add New Airport</span>
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
                                    Add New Airport
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{route('airport-crud.index')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                                <span>
                                    <i class="la la-arrow-left"></i>
                                    <span>Back</span>
                                </span>
                            </a>
                            <div class="btn-group">
                                <button type="submit" form="m_form" class="btn btn-accent  m-btn m-btn--icon m-btn--wide m-btn--md">
                                    <span>
                                        <i class="la la-check"></i>
                                        <span>Save</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form class="m-form m-form--label-align-left- m-form--state-" method="post" action="{{route('airport-crud.store')}}" id="m_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Airport Details</h3>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Name:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="name" required="" placeholder="Airport Name" class="form-control m-input" value="{{old('name')}}">
                                                <span class="m-form__help">Please enter airport name</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Address:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <textarea name="address" class="form-control m-input" placeholder="Maximum 100 characters" maxlength="500">{{old('address')}}</textarea>
                                                <span class="m-form__help">Please enter address</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Latitude:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="lat" required="" placeholder="Latitude" class="form-control m-input" value="{{old('lat')}}">
                                                <span class="m-form__help">Please enter latitude</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Longitude:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="lng" required="" placeholder="Longitude" class="form-control m-input" value="{{old('lng')}}">
                                                <span class="m-form__help">Please enter longitude</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Fees:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="fees" required="" placeholder="Fees" class="form-control m-input" value="{{old('fees')}}">
                                                <span class="m-form__help">Please enter fees</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Tax:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="tax" required="" placeholder="Tax" class="form-control m-input" value="{{old('tax')}}">
                                                <span class="m-form__help">Please enter tax</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Distance:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="distance" required="" placeholder="Distance" class="form-control m-input" value="{{old('distance')}}">
                                                <span class="m-form__help">Please enter distance</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Is Office Exist:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="is_office_exit" required="" placeholder="Is Office Exist" class="form-control m-input" value="{{old('is_office_exit')}}">
                                                <span class="m-form__help">Please enter is office exist</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* State Initial:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="state_initial" required="" placeholder="State Initial" class="form-control m-input" value="{{old('state_initial')}}">
                                                <span class="m-form__help">Please enter state initial</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* State:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="state" required="" placeholder="State" class="form-control m-input" value="{{old('state')}}">
                                                <span class="m-form__help">Please enter state</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* City:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="city" required="" placeholder="City" class="form-control m-input" value="{{old('city')}}">
                                                <span class="m-form__help">Please enter city</span>
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
