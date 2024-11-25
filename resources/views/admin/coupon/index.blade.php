@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> Coupons </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('coupon-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text"> Coupons </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- END: Subheader -->
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Coupons Listing
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{route('coupon-crud.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>Add New</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Choose Country
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    @foreach($country as $row)
                    <li class="m-portlet__nav-item">
                        <a href="?country={{$row->id}}" class="btn {{ !empty(app('request')->input('country') == $row->id) ? 'btn-danger' : 'btn-success' }} s-btn s-btn--pill s-btn--custom s-btn--icon m-btn--air">
                            <span>
                                <span>{{$row->name}}</span>
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <button type="submit" form="m_form" style="display:none" class="btns btn btn-danger  m-btn m-btn--icon m-btn--wide m-btn--md">
                <span>
                    <i class="la la-check"></i>
                    <span>Delete</span>
                </span>
            </button>
            <form class="m-form m-form--label-align-left- m-form--state-" method="post" action="{{route('coupon-crud.deleteCopy')}}" id="m_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Sr.#</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Coupon #</th>
                        
                        <th>Work</th>
                        <th>Not Work</th>
                        <th>Top Coupon Position</th>
<!--                        <th>Image</th>-->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $k=>$val)
                    <tr>
                        
                        <td>
                            <div class="form-check checkbox-lg">
                                <input name="coupon_ids[]" style="width: 20px;height: 20px;" id="ad_Checkbox" class="form-check-input checklist mx-1" type="checkbox" value="{{$val->id}}" />
                            </div>
                        </td>
                       
                        <td>{{$k+1}}</td>
                        <td>
                            <div class="m-card-user m-card-user--sm">
                                <div class="m-card-user__pic">
                                    <div class="m-card-user__no-photo m--bg-fill-warning"><span>{{substr($val->name, 0, 1)}}</span></div>
                                </div>
                                <div class="m-card-user__details">
                                    <span class="m-card-user__name">{{ucfirst($val->name)}}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{$val->country->name}}</td>
                        <td>{{$val->coupon_no}}</td>
                        
                        <td>{{$val->coupon_work_count}}</td>
                        <td>{{$val->coupon_not_work_count}}</td>
                        <td>{{$val->position}}</td>
                        <!--<td><img id="uploadPreview" src="{{$val->image_url}}" style="max-width:150px; max-height:100px" /></td>
                        -->
                        <td nowrap>
                            <a href="{{route('coupon-crud.copy', ['id' => $val->id])}}"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Copy">
                                <i class="la la-copy"></i>
                            </a>
                            <a href="{{route('coupon-crud.edit', $val->id)}}"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="{{route('coupon-action', $val->id)}}" onclick="return confirm('Are you sure you want to delete this coupon?')"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Delete">
                                <i class="la la-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
             </form>
        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->
</div>
<script>
    
</script>
@endsection

