@extends('admin.layout')
@section('page-section')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">Users Listing</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{route('users-crud.index')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="javascript:;" class="m-nav__link">
                        <span class="m-nav__link-text">Users Listing</span>
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
                        Users Listing
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_2">
                <thead>
                    <tr>
                        <th>Sr.#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $k=>$val)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>
                            <div class="m-card-user m-card-user--sm">
                                {{--<div class="m-card-user__pic">
                                    <div class="m-card-user__no-photo m--bg-fill-warning"><span>{{substr($val->full_name, 0, 1)}}</span></div>
                                </div>--}}
                                <div class="m-card-user__details">
                                    <span class="m-card-user__name">{{ucfirst($val->full_name)}}</span>
                                    {{--<a href="" class="m-card-user__email m-link">Legros-Cummings</a>--}}
                                </div>
                            </div>
                        </td>
                        <td>{{$val->email}}</td>
                        <td>
                            @if($val->status == 1)
                                <span class="m-badge  m-badge--success m-badge--wide"> Active </span>
                            @else
                                <span class="m-badge  m-badge--danger m-badge--wide"> Blocked </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{--{{ $data->links() }}--}}
        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->
</div>
@endsection
