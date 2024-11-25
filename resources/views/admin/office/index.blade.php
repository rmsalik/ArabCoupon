@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator"> Offices </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('office-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text"> Offices </span>
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
                        Offices Listing
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{route('office-crud.create')}}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>Add New</span>
                            </span>
                        </a>
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
                        <th>Name</th>
                        <th>Address</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Fees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $k=>$val)
                    <tr>
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
                        <td>{{$val->address}}</td>
                        
                        <td>{{$val->lat}}</td>
                        <td>{{$val->lng}}</td>
                        <td>{{$val->fees}}</td>
                        <td nowrap>
                            <a href="{{route('office-crud.edit', $val->id)}}"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                            <a href="{{route('office-action', $val->id)}}" onclick="return confirm('Are you sure you want to delete this office?')"
                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               title="Delete">
                                <i class="la la-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->
</div>

@endsection

