@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> Vehicles </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('category-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text">Add New Vehicle</span>
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
                                    Add New Vehicle
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
                    <form class="m-form m-form--label-align-left- m-form--state-" method="post" action="{{route('item-crud.store')}}" id="m_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!--begin: Form Body -->
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="m-form__heading">
                                            <h3 class="m-form__heading-title">Vehicle Details</h3>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Title:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="title" required="" placeholder="Enter title" class="form-control m-input" value="{{old('title')}}">
                                                <span class="m-form__help">Please enter title</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Category:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="category_id">
                                                    {{$getCategories = App\Models\Category::all()}}
                                                    {{$i = 0}}
                                                    @foreach($getCategories as $category)
                                                        @if(!$i)
                                                            <option value="{{$category->id}}" name="category_id" selected="{{$category->name}}">{{$category->name}}</option>
                                                        @else
                                                            <option value="{{$category->id}}" name="category_id" >{{$category->name}}</option>
                                                        @endif
                                                        {{$i++}}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* State:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="destination_id">
                                                    {{$getCategories = App\Models\Destination::all()}}
                                                    {{$i = 0}}
                                                    @foreach($getCategories as $category)
                                                        @if(!$i)
                                                            <option value="{{$category->id}}" name="destination_id" selected="{{$category->name}}">{{$category->name}}</option>
                                                        @else
                                                            <option value="{{$category->id}}" name="destination_id" >{{$category->name}}</option>
                                                        @endif
                                                        {{$i++}}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Brand Name:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="brand_name">
                                                    {{$getCategories = App\Models\Brand::all()}}
                                                    {{$i = 0}}
                                                    @foreach($getCategories as $category)
                                                        @if(!$i)
                                                            <option value="{{$category->id}}" name="brand_name" selected="{{$category->name}}">{{$category->name}}</option>
                                                        @else
                                                            <option value="{{$category->id}}" name="brand_name" >{{$category->name}}</option>
                                                        @endif
                                                        {{$i++}}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Description:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <textarea name="description" class="form-control m-input" placeholder="Maximum 500 characters" maxlength="500">{{old('description')}}</textarea>
                                                <span class="m-form__help">Please enter description</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Price:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="price" required="" placeholder="Enter Price" class="form-control m-input" value="{{old('price')}}">
                                                <span class="m-form__help">Please enter price</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Insurance Fees:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="insurance_fees" required="" placeholder="Enter Insurance Fees" class="form-control m-input" value="{{old('insurance_fees')}}">
                                                <span class="m-form__help">Please enter insurance fees</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Fuel Fees:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="fuel_fees" required="" placeholder="Enter Fuel Fees" class="form-control m-input" value="{{old('fuel_fees')}}">
                                                <span class="m-form__help">Please enter fuel fees</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Pickup Fees:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="pickup_fees" required="" placeholder="Enter Pickup Fees" class="form-control m-input" value="{{old('pickup_fees')}}">
                                                <span class="m-form__help">Please enter pickup fees</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Dropoff Fees:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="dropoff_fees" required="" placeholder="Enter Dropoff Fees" class="form-control m-input" value="{{old('dropoff_fees')}}">
                                                <span class="m-form__help">Please enter dropoff fees</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Pickup & Dropoff Fees:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="pickupanddropoff_fees" required="" placeholder="Enter Pickup & Dropoff Fees" class="form-control m-input" value="{{old('pickupanddropoff_fees')}}">
                                                <span class="m-form__help">Please enter pickup & dropoff fees</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* City:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="city" required="" placeholder="Enter City" class="form-control m-input" value="{{old('city')}}">
                                                <span class="m-form__help">Please enter city</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Location:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="location" required="" placeholder="Enter Location" class="form-control m-input" value="{{old('location')}}">
                                                <span class="m-form__help">Please enter location</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Vehicle Number:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="car_number" required="" placeholder="Enter Vehicle Number" class="form-control m-input" value="{{old('car_number')}}">
                                                <span class="m-form__help">Please enter vehicle number</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Vehicle Model:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="car_model" required="" placeholder="Enter Vehicle Model" class="form-control m-input" value="{{old('car_model')}}">
                                                <span class="m-form__help">Please enter vehicle model</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Vehicle Color:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="car_color" required="" placeholder="Enter Vehicle Color" class="form-control m-input" value="{{old('car_color')}}">
                                                <span class="m-form__help">Please enter vehicle color</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Seating Capacity</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="seating_capacity" required="" placeholder="Enter Seating Capacity" class="form-control m-input" value="{{old('seating_capacity')}}">
                                                <span class="m-form__help">Please enter seating capacity</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Engine:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="engine" required="" placeholder="Enter Engine" class="form-control m-input" value="{{old('engine')}}">
                                                <span class="m-form__help">Please enter engine</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Interior:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="text" name="interior" required="" placeholder="Enter Interior" class="form-control m-input" value="{{old('interior')}}">
                                                <span class="m-form__help">Please enter interior</span>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Body Type:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="body_type">
                                                    <option value="Hatchback" name="body_type" selected="Hatchback">Hatchback</option>
                                                    <option value="Sedan" name="body_type" >Sedan</option>
                                                    <option value="MUV/SUV" name="body_type" >MUV/SUV</option>
                                                    <option value="Coupe" name="body_type" >Coupe</option>
                                                    <option value="Convertible" name="body_type" >Convertible</option>
                                                    <option value="Wagon" name="body_type" >Wagon</option>
                                                    <option value="Van" name="body_type" >Van</option>
                                                    <option value="Jeep" name="body_type" >Jeep</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Tranmission:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="transmission">
                                                    <option value="Automatic" name="transmission" selected="Automatic">Automatic</option>
                                                    <option value="Manual" name="transmission" >Manual</option>
                                                    <option value="Semi Automatic" name="transmission" >Semi Automatic</option>
                                                    <option value="Dual Clutch" name="transmission" >Dual Clutch</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Fuel Type:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="fuel_type">
                                                    <option value="Gasoline" name="fuel_type" selected="Gasoline">Gasoline</option>
                                                    <option value="Diesel" name="fuel_type" >Diesel</option>
                                                    <option value="Electric" name="fuel_type" >Electric</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Seats:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="seats">
                                                    <option value="2 Seats" name="seats" selected="2 Seats">2 Seats</option>
                                                    <option value="4 Seats" name="seats" >4 Seats</option>
                                                    <option value="7 Seats" name="seats" >7 Seats</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Doors:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <select class="bootstrap-select" name="doors">
                                                    <option value="2 Doors" name="doors" selected="2 Doors">2 Doors</option>
                                                    <option value="4 Doors" name="doors" >4 Doors</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">* Images:</label>
                                            <div class="col-xl-9 col-lg-9">
                                                <input type="file" id="Image" name="photos[]" required multiple class="form-control m-input" />
                                                <span class="m-form__help">Select Images</span>
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
