<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>ArabCoupons</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="{{asset('admin/default/assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{asset('admin/default/assets/vendors/base/vendors.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('admin/default/assets/demo/demo12/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{asset('admin/default/assets/demo/demo12/base/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="{{asset('admin/default/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{asset('admin/default/assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />-->
        <link href="{{asset('admin/default/assets/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="{{asset('images/favicons.ico')}}" />
		<!--begin::Global Theme Bundle -->
        <script src="{{asset('admin/default/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
        <script src="{{asset('admin/default/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
        {{--<script src="{{asset('admin/default/assets/demo/demo12/base/scripts.bundle.js')}}" type="text/javascript"></script>--}}

        <!--end::Global Theme Bundle -->
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									{{--<a href="index.html" class="m-brand__logo-wrapper">
										<img alt="" src="{{asset('admin/default/assets/demo/demo12/media/img/logo/logo.png')}}" />
									</a>--}}
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">

									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Responsive Header Menu Toggler -->
									<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>

									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

							<!-- BEGIN: Horizontal Menu -->
							<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							
							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="{{asset('images/avatar.png')}}" class="m--img-rounded m--marginless m--img-centered" alt="Admin" />
												</span>
												<span class="m-nav__link-icon m-topbar__usericon  m--hide">
													<span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
												</span>
												<span class="m-topbar__username m--hide">{{session('adminSet.name')}}</span>
											</a>
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center">
														<div class="m-card-user m-card-user--skin-light">
															<div class="m-card-user__pic">
																<img src="{{asset('assets/images/user.jpg')}}" class="m--img-rounded m--marginless" alt="" />
															</div>
															<div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500">{{session('adminSet.name')}}</span>
																<a href="" class="m-card-user__email m--font-weight-300 m-link">{{session('adminSet.username')}}</a>
															</div>
														</div>
													</div>
													<div class="m-dropdown__body">
														<div class="m-dropdown__content">
															<ul class="m-nav m-nav--skin-light">
																<li class="m-nav__separator m-nav__separator--fit">
																</li>
																<li class="m-nav__item">
																	<a href="{{url('admin/logout')}}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>

							<!-- END: Topbar -->
						</div>
					</div>
				</div>
			</header>

			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

					<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
						<ul class="m-menu__nav ">
						    
							<li class="m-menu__item {{ (request()->is('admin/category-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('category-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-text"> Categories </span></a></li>
							<li class="m-menu__item {{ (request()->is('admin/brand-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('brand-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-car"></i><span class="m-menu__link-text"> Brands </span></a></li>
							
							<li class="m-menu__item {{ (request()->is('admin/coupon-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('coupon-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text"> Coupons </span></a></li>
							<li class="m-menu__item {{ (request()->is('admin/coupons-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('coupon-crud.api')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text"> Client Coupons </span></a></li>
							
							<li class="m-menu__item {{ (request()->is('admin/notification-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('notification-crud.create')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">Notifications</span></a></li>
						    
							<!--
							<li class="m-menu__item {{ (request()->is('admin/top-coupon-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('top-coupon-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text"> Top Coupons </span></a></li>
							
							<li class="m-menu__item {{ (request()->is('admin/users-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('users-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text"> Users </span></a></li>
							<li class="m-menu__item {{ (request()->is('admin/destination-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('destination-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-placeholder"></i><span class="m-menu__link-text"> Destinations </span></a></li>
							<li class="m-menu__item {{ (request()->is('admin/item-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('item-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text"> Vehicles </span></a></li>
							<li class="m-menu__item {{ (request()->is('admin/booking-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('booking-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text"> Bookings </span></a></li>
							
							<li class="m-menu__item {{ (request()->is('admin/office-crud*')) ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{route('office-crud.index')}}" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-truck"></i><span class="m-menu__link-text"> Offices </span></a></li>
                            -->
						
						</ul>
					</div>

					<!-- END: Aside Menu -->
				</div>

				<!-- END: Left Aside -->
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
				@include('xtra.flash-message')
