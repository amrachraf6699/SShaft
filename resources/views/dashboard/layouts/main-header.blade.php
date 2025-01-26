<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ route('dashboard.welcome') }}"><img src="{{ $setting->logo_path }}" class="logo-1" alt="logo"></a>
							<a href="{{ route('dashboard.welcome') }}"><img src="{{ $setting->logo_path }}" class="logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
                        <div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
                            <form action="{{ route('dashboard.general-search') }}" method="GET">
                                <input class="form-control" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}" placeholder="{{ __('translation.general_search') }}" type="search">
                                <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
                            </form>
						</div>
					</div>
					<div class="main-header-right">
						<div class="nav nav-item  navbar-nav-right ml-auto">
                            <notifications></notifications>
                            <!-- Right Side Of Navbar -->
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href=""><img alt="" src="{{ URL::asset('dashboard_files/assets/img/profile.png') }}"></a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user"><img alt="" src="{{ URL::asset('dashboard_files/assets/img/profile.png') }}" class=""></div>
											<div class="mr-3 my-auto">
												<h6>{{ auth()->user()->name }}</h6><span>{{ auth()->user()->email }}</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href="{{ route('dashboard.admin.edit') }}"><i class="bx bx-cog"></i> @lang('dashboard.edit_profile')</a>
									<a class="dropdown-item" href="{{ route('frontend.home') }}"><i class="bx bx-arrow-back"></i> @lang('dashboard.go_to_site')</a>
                                    <a class="dropdown-item" href="{{ route('dashboard.switchLang', app()->getLocale() == 'en' ? 'ar' : 'en') }}"><i class="bx bx-world"></i> @lang('dashboard.switch_language')</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i>@lang('dashboard.logout')</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
