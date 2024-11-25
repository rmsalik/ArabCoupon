@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Create new Unit</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('dashboard.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{route('units-crud.index')}}" class="m-nav__link">
                        <span class="m-nav__link-text">Units</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text">Create new Unit</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- END: Subheader -->
<div class="m-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="tab-content">
                    <div class="tab-pane active" id="unit">
                        <form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('units-crud.store')}}">
                        {{ csrf_field() }}
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">1. Unit title and information</h3>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-2 col-form-label" for="ownerId">Property Owner</label>
                                    <div class="col-7">
                                    <select class="form-control m-input" required="" name="ownerId" id="ownerId">
                                        <option value="">Select a owner</option>
                                        @foreach($owners as $type)
                                        <option @if($type->id==Request::input('oId')) selected @endif value="{{$type->id}}">{{$type->name.' ('.$type->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                   </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Title</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="title" type="text" value="{{@$unit->title}}">
                                    </div>
                                </div>
                                {{--<div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Prices</label>
                                    <div class="col-2">
                                        <label for="" class="col-form-label"> Middle of the week </label>
                                        <input class="form-control m-input" required="" name="prices[middleWeek]" placeholder="Middle of the week" type="text" value="{{@$prices->monday}}">
                                    </div>
                                    <div class="col-2">
                                        <label for="" class="col-form-label">Thursday </label>
                                        <input class="form-control m-input" required="" name="prices[thursday]" placeholder="Thursday" type="text" value="{{@$prices->thursday}}">
                                    </div>
                                    <div class="col-2">
                                        <label for="" class="col-form-label"> Friday </label>
                                        <input class="form-control m-input" required="" name="prices[friday]" placeholder="Friday" type="text" value="{{@$prices->friday}}">
                                    </div>
                                    <div class="col-2">
                                        <label for="" class="col-form-label"> Saturday </label>
                                        <input class="form-control m-input" required="" name="prices[saturday]" placeholder="Saturday" type="text" value="{{@$prices->saturday}}">
                                    </div>
                                    <input type="hidden" name="prices[unitId]" value="{{@$unit->id}}">
                                    <input type="hidden" name="prices[id]" value="{{@$prices->id}}">
                                </div>--}}
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Unit Space(meter square)</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="space" type="text" value="{{@$unit->space}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Accommodation</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="accommodation" type="text" value="{{@$unit->accommodation}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Deposit required (SAR)</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="depositVal" type="text" value="{{@$unit->depositVal}}">
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label">Available for</label>
                                    <div class="col-7">
                                        <div class="m-radio-inline">
                                        @foreach(@$unit->available_for as $type)
                                            <label class="m-radio">
                                                <input type="radio" required="" @if(@$type->isLinked) checked @endif name="availableFor" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label">Suitable for</label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->suitable_for as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if(@$type->isLinked) checked @endif name="suitableFor[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label">Overnight</label>
                                    <div class="col-7">
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                                <input required="" type="radio" @if(@$unit->overnightStay) checked @endif name="overnightStay" value="1"> Allowed (recommended and will increase your chances of booking)
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                                <input required="" type="radio" @if(@$unit->overnightStay==0) checked @endif name="overnightStay" value="0"> Not allowed (guests will follow normal checkout times you will choose in the next steps)
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">2. Seating Areas</h3>
                                    </div>
                                </div>

                                @foreach(@$unit->seating_areas as $k=>$val)
                                <div class="form-group m-form__group row">
                                    <label for="" class="col-2 col-form-label">
                                    {{--<input type="checkbox" @if($val->isLinked) checked @endif name="" />--}}
                                    </label>
                                    <div class="col-7">
                                        <label for="" class="col-form-label">{{$val->title}}</label>
                                        <input type="hidden" value="{{$val->id}}" name="seating_areas[{{$k}}][areaId]">
                                        <input class="form-control m-input" name="seating_areas[{{$k}}][guests]" type="number" value="{{@$val->value}}">
                                    </div>
                                </div>
                                @endforeach


                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">3. Bedrooms</h3>
                                    </div>
                                </div>

                                @foreach(@$unit->bedrooms as $k=>$val)
                                <div class="form-group m-form__group row">
                                    <label for="" class="col-2 col-form-label">
                                    {{--<input type="checkbox" @if($val->isLinked) checked @endif name="" />--}}
                                    </label>
                                    <div class="col-7">
                                        <label for="" class="col-form-label">{{$val->title}}</label>
                                        <input type="hidden" value="{{$val->id}}" name="bedrooms[{{$k}}][bedroomId]">
                                        <input class="form-control m-input" name="bedrooms[{{$k}}][rooms]" type="text" value="{{@$val->value}}">
                                    </div>
                                </div>
                                @endforeach
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <label for="example-text-input" class="col-form-label"> Additional beds and mattress (if available) </label>
                                        <input class="form-control m-input" name="additionalBedsMattres" type="text" value="{{@$unit->additionalBedsMattres}}">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">4. Pools</h3>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->pools as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if(@$type->isLinked) checked @endif name="pools[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">5. Wellness</h3>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->wellness as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if(@$type->isLinked) checked @endif name="wellness[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">6. Facilities</h3>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->facilities as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if(@$type->isLinked) checked @endif name="facilities[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">7. Kitchens</h3>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->kitchens as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if(@$type->isLinked) checked @endif name="kitchen[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <label for="example-text-input" class="col-form-label"> Number of kitchens </label>
                                        <input class="form-control m-input" name="kitchenDiningTblFits" type="text" value="{{@$unit->kitchenDiningTblFits}}">
                                    </div>
                                </div>


                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">8. Bathrooms</h3>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <label for="example-text-input" class="col-form-label"> How many bathrooms? </label>
                                        <input class="form-control m-input" name="bathRooms" type="text" value="{{@$unit->bathRooms}}">
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->bathroom_facilities as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if(@$type->isLinked) checked @endif name="bathFacilities[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">9. Description</h3>
                                    </div>
                                </div>
                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                                <input type="radio" @if(@$unit->descriptionType=='suggested') checked @endif name="descriptionType" value="suggested">Suggested description:
                                                <span></span>
                                            </label>
                                        </div>
                                        <textarea name="description" class="form-control">{{@$unit->descriptionType=='suggested' ? @$unit->description : ""}}</textarea>
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                                <input type="radio" @if(@$unit->descriptionType=='own') checked @endif name="descriptionType" value="own"> Write your own description (what is special about your unit to attract guests)
                                                <span></span>
                                            </label>
                                        </div>
                                        <textarea name="description" class="form-control">{{@$unit->descriptionType=='own' ? @$unit->description :""}}</textarea>
                                    </div>
                                </div>--}}
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-7">
                                            <input type="hidden" value="80" name="completed" />
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save changes</button>&nbsp;&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection