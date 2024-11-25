@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> Bookings </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('booking-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text"> Bookings </span>
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
                    Booking Listing
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <!--<a href="{{route('item-crud.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>Add New</span>
                            </span>
                        </a>-->
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                    <tr>
                        <th>Sr.#</th>
                        <th>User Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <!--<th>Actions</th>-->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $k=>$val)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>
                            <div class="m-card-user m-card-user--sm">
                                <div class="m-card-user__pic">
                                    <div class="m-card-user__no-photo m--bg-fill-warning"><span>{{substr($val->user->full_name, 0, 1)}}</span></div>
                                </div>
                                <div class="m-card-user__details">
                                    <a href="{{route('booking-crud.edit', $val->id)}}">
                                        <span class="m-card-user__name">{{ucfirst($val->user->full_name)}}</span>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>{{$val->start_date}}</td>
                        <td>{{$val->end_date}}</td>
                        <td>{{$val->start_time}}</td>
                        <td>{{$val->end_time}}</td>
                        <td>
                            @if($val->status == 1)
                                <span class="m-badge  m-badge--success m-badge--wide"> Confirmed </span>
                            @else
                                <span class="m-badge  m-badge--danger m-badge--wide"> Cancelled </span>
                            @endif
                        </td>
                        <!--<td nowrap>
                            <a href="{{route('item-crud.edit', $val->id)}}"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="{{route('item-action', $val->id)}}" onclick="return confirm('Are you sure you want to delete this vehicles?')"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Delete">
                                <i class="la la-trash"></i>
                            </a>
                        </td>-->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->
</div>

@endsection

