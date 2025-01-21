@extends('dashboard.layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{URL::asset('dashboard_files/assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('dashboard_files/assets/img/media/loginPage.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
                                        <div class="mb-5 d-flex"> <a href="{{ route('frontend.home') }}">
                                            <img src="{{URL::asset('dashboard_files/assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a>
                                        </div>
										<div class="card-sigin">
											<div class="main-signup-header">
												<h2>مرحباً بعودتك!</h2>
                                                <h5 class="font-weight-semibold mb-4">أعد تعيين كلمة المرور.</h5>

                                                <form method="POST" action="{{ route('password.update') }}">
                                                    @csrf

                                                    <input type="hidden" name="token" value="{{ $token }}">

                                                    <div class="form-group">
                                                        <label for="email">@lang('dashboard.email')</label>
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="example@example.com">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password">@lang('dashboard.password')</label>
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('dashboard.wr_newpassword') }}">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password-confirm">@lang('dashboard.confirm_password')</label>
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('dashboard.confirm_password') }}">
                                                    </div>

                                                    <button type="submit" class="btn btn-main-primary btn-block">@lang('dashboard.reset_password')</button>
                                                </form>
												<div class="main-signup-footer mg-t-20">
                                                    <p>تتذكر كلمة المرور؟  <a href="{{ route('login') }}">تسجيل الدخول</a></p>
                                                </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
