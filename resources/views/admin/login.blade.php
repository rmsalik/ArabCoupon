<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>ADMIN PORTAL - LOGIN</title>
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

		<!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('admin/default/assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="{{asset('images/favicons.ico')}}" />

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/login-style.css')}}">
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default" >

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page" >
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url({{asset('admin/default/assets/app/media/img//bg/bg-9.jpg')}})">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="container justify-content-center">
							<!--<h3 class="d-flex justify-content-center text-light"> PremierAutoCarRental</h3>-->
							<div class="d-flex justify-content-center h-100" >
								<div class="card" >

									<div class="card-body justify-content-center" style="background-image: url({{ asset('admin/default/assets/app/media/img/bg/bg_excel_admin.jpg') }});">
										<div class="m-login__signin">
											<form class="m-login__form m-form" action="{{url('admin/login')}}" method="post">
											{!! csrf_field() !!}
												<div class="form-group m-form__group">
													<h4 style="padding-left:20px;">Email</h4>
													<input class="form-control m-input" value="{{old('email')}}" type="text" placeholder="Username/Email" name="username" autocomplete="off">
												</div>
												<div class="form-group m-form__group">
												<h4 style="padding-left:20px; padding-top: 20px;">Password</h4>
													<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
												</div>
												<div class="m-login__form-action">
													<button id="m_login_signin_submit" type="submit" class="btn m-btn--pill m-login__btn text-light">Sign In</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin::Global Theme Bundle -->
		<script src="{{asset('admin/default/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('admin/default/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		{{--<script src="{{asset('admin/default/assets/snippets/custom/pages/user/login.js')}}" type="text/javascript"></script>--}}

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>
