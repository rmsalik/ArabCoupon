@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader " xmlns="http://www.w3.org/1999/html">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Cheater Detail</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('listings-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text">Cheater Detail</span>
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
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class=" m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#cheater" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Cheater Detail
                                </a>
                            </li>
                            <li class=" m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#images" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Images
                                </a>
                            </li>
                            <li class=" m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#rating" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Rating & Reviews
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="cheater">
                        <form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('listings-crud.update',$data->id)}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">1. Cheater's basic information (<a target="_blank" href="{{route('cheater.show',$data->id)}}">Profile link</a>)</h3>
                                    </div>
                                </div>
                                <h4></h4>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">First name</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="basic[first_name]" type="text" value="{{$data->first_name}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Last name</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="basic[last_name]" type="text" value="{{$data->last_name}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Phone</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" required="" name="basic[phone]" type="text" value="{{$data->phone}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label class="col-2 col-form-label" for="city">Born Year</label>
                                    <div class="col-7">
                                    <select class="form-control m-input" required="" name="basic[dob]">
                                        @for($i=1940;$i<=2020;$i++)
                                        <option @if($data->dob==$i) selected @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                   </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Second phone</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[second_phone]" type="text" value="{{$data->second_phone}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Third phone</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[third_phone]" type="text" value="{{$data->third_phone}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Line</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[line]" type="text" value="{{$data->line}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Telegram</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[telegram]" type="text" value="{{$data->telegram}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Viber</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[viber]" type="text" value="{{$data->viber}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">WhatsApp</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[whatsApp]" type="text" value="{{$data->whatsApp}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">WeChat</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[weChat]" type="text" value="{{$data->weChat}}">
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">2. Social Links</h3>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Facebook</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[facebook]" type="text" value="{{$data->facebook}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Twitter</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[twitter]" type="text" value="{{$data->twitter}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Instagram</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[instagram]" type="text" value="{{$data->instagram}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Snapchat</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[snapchat]" type="text" value="{{$data->snapchat}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">LinkedIn</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[linkedIn]" type="text" value="{{$data->linkedIn}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Qq</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[qq]" type="text" value="{{$data->qq}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Tumblr</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[tumblr]" type="text" value="{{$data->tumblr}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Qzone</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[qzone]" type="text" value="{{$data->qzone}}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Tiktok</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" name="basic[tiktok]" type="text" value="{{$data->tiktok}}">
                                    </div>
                                </div>


                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">3. Locations</h3>
                                    </div>
                                </div>
                                @foreach($data->locations as $k=>$loc)
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">Location {{$k+1}}</label>
                                    <div class="col-7">
                                        <input class="form-control m-input" disabled readonly name="" type="text" value="{{$loc->address}}">
                                    </div>
                                </div>
                                @endforeach
                                {{--<div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">3. Situations</h3>
                                    </div>
                                </div>

                                <div class="m-form__group form-group row">
                                    <label class="col-2 col-form-label"></label>
                                    <div class="col-7">
                                        <div class="m-checkbox-inline">
                                        @foreach(@$unit->pools as $type)
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if($type->isLinked) checked @endif name="pools[]" value="{{$type->id}}"> {{$type->title}}
                                                <span></span>
                                            </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-7">
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Update</button>
                                            @if($data->status != 1)
                                            <a href="{{route('listings-action',['approve-cheater',$data->id])}}"><button onclick="return confirm('Are you sure?')" type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom">Approve</button></a>&nbsp;&nbsp;
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="images">
                        <div class="m-portlet__body">
                            <h4>All Images</h4>
                            <div class="row">
                                @foreach($data->non_deleted_images as $image)
                                <div class="mb-3 col-lg-3">
                                    <img style="width: 100%" src="{{isImageExit($image->image)}}" />
                                    <a onclick="return confirm('Are you sure?')" href="{{route('listings-action',['delete-image',$image->id])}}">
                                        <button style="margin-top: 10px;" type="button" class="btn btn-danger m-btn m-btn--air m-btn--custom" value="Delete image">Delete image</button>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="rating">
                         <div class="m-portlet__body">
                            <div class="row">
                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::Total Profit-->
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Total Rating
                                                </h4><br>
                                                <span class="m-widget24__desc">
                                                    Cheater overall rating
                                                </span>
                                                <span class="m-widget24__stats m--font-brand">
                                                    {{isset($data->avg_rating) ? $data->avg_rating->rating : 0}}
                                                </span>
                                                <div class="m--space-10"></div>
                                            </div>
                                        </div>
                                        <!--end::Total Profit-->
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <!--begin::Total Profit-->
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Total Reviews
                                                </h4><br>
                                                <span class="m-widget24__desc">
                                                    Cheater reviews count
                                                </span>
                                                <span class="m-widget24__stats m--font-info">
                                                    {{isset($data->total_reviews) ? $data->total_reviews->total : 0}}
                                                </span>
                                                <div class="m--space-10"></div>
                                            </div>
                                        </div>
                                        <!--end::Total Profit-->
                                    </div>
                            </div>

                            <hr/>
                            <br/>
                            <h5>Reviews & rating</h5>
                            <br/><br/>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
                                    @foreach($data->reviews as $k=>$val)
                                    <!--begin::m-widget5-->
                                    <div class="m-widget5">
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__section">
                                                    <h4 class="m-widget5__title">
                                                        {{$val->name}}
                                                    </h4>
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Gender:
                                                        </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                            {{$val->gender}}
                                                        </span>
                                                    </div>
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Dated:
                                                        </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                            {{$val->from.' - '.$val->to}}
                                                        </span>
                                                    </div>
                                                    @if($val->from_period != "0000-00-00")
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Dated again:
                                                        </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                            {{$val->from_period.' - '.$val->to_period}}
                                                        </span>
                                                    </div>
                                                    @endif
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Review Title:
                                                        </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                            {{$val->title}}
                                                        </span>
                                                    </div>
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Rating:
                                                        </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                            {{$val->rating.' stars'}}
                                                        </span>
                                                    </div>
                                                    <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Review:
                                                        </span>
                                                        <span class="m-widget5__info-date">
                                                            {{$val->review}}
                                                        </span>
                                                    </div>
                                                     <div class="m-widget5__info">
                                                        <span class="m-widget5__author">
                                                            Status:
                                                        </span>
                                                        <span class="m-widget5__info-date">
                                                            @if($val->status==1) <span class="m-badge  m-badge--success m-badge--wide">Approved</span> @else <span class="m-badge  m-badge--danger m-badge--wide">Pending</span> @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget5__content"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            {{--<table class="table table-striped- table-bordered table-hover table-checkable rendering_tbl" id="">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Title</th>
                                        <th>Rating</th>
                                        <th>Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->reviews as $k=>$val)
                                    <tr>
                                        --}}{{--<td>{{$k+1}}</td>--}}{{--
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->gender}}</td>
                                        <td>{{$val->title}}</td>
                                        <td>{{$val->rating.' stars'}}</td>
                                        <td>{{$val->review}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>--}}
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
