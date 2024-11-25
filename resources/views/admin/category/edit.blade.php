@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator"> Categories </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('category-crud.index')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="javascript:;" class="m-nav__link">
                                <span class="m-nav__link-text">Edit Category</span>
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
                                    Edit Category
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{route('category-crud.index')}}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                                <span>
                                    <i class="la la-arrow-left"></i>
                                    <span>Back</span>
                                </span>
                            </a>
                            <div class="btn-group">
                                <button href="#" type="submit" form="m_form" class="btn btn-accent  m-btn m-btn--icon m-btn--wide m-btn--md">
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
                    <form class="m-form m-form--label-align-left- m-form--state-" method="post" action="{{route('category-crud.update',$data->id)}}" id="m_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title"> Category Details</h3>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Name:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="name" required="" class="form-control m-input" placeholder="Category Name" value="{{$data->name}}">
                                                <span class="m-form__help">Please enter category name</span>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Description:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <textarea name="description" class="form-control m-input"  placeholder="Maximum 500 characters" maxlength="500">{{$data->description}}</textarea>
                                                <span class="m-form__help">Please enter description</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Arabic Name:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="arabic_name" required="" class="form-control m-input" placeholder="Category Name" value="{{$data->arabic_name}}">
                                                <span class="m-form__help">Please enter category name</span>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Arabic Description:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <textarea name="arabic_description" class="form-control m-input"  placeholder="Maximum 500 characters" maxlength="500">{{$data->arabic_description}}</textarea>
                                                <span class="m-form__help">Please enter description</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Country:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="country_id">
                                                    {{$getCategories = App\Models\Country::all()}}
                                                    @foreach($getCategories as $category)
                                                        @if($data->country->name == $category->name)
                                                            <option value="{{$category->id}}" name="country_id" selected="{{$category->name}}">{{$category->name}}</option>
                                                        @else
                                                            <option value="{{$category->id}}" name="country_id" >{{$category->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    

                                   <!-- <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Position:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="position" required="" class="form-control m-input" placeholder="Position" value="{{$data->position}}">
                                                <span class="m-form__help">Please enter position</span>
                                            </div>
                                        </div>-->
                                    <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Image:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <img id="uploadPreview" src="{{$data->image_url}}" style="max-width:500px; max-height:300px" />
                                                <input type="file" id="uploadImage" name="picture" class="form-control m-input" onchange="PreviewImage();" />
                                                <span class="m-form__help">Select Image</span>
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
