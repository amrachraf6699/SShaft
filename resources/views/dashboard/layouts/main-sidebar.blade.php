<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ route('dashboard.welcome') }}"><img src="{{ $setting->logo_path }}" class="main-logo" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ route('dashboard.welcome') }}"><img src="{{ $setting->logo_path }}" class="logo-icon" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{ URL::asset('dashboard_files/assets/img/profile.png') }}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
							<span class="mb-0 text-muted">{{ auth()->user()->email }}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('dashboard.welcome') }}">
                            <i class="las la-house-damage la-2x ml-2"></i>
                            <span class="side-menu__label">{{ __('dashboard.dashboard') }}</span>
                        </a>
                    </li>

                    @if (auth()->user()->hasPermission('read_settings'))
                        <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.settings.index') }}">
                                <i class="las la-cogs la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('dashboard.settings') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_lift_centers'))
                        <!--<li class="slide">-->
                        <!--    <a class="side-menu__item" href="{{ route('dashboard.lift-centers.index') }}">-->
                        <!--        <i class="las la-upload la-2x ml-2"></i>-->
                        <!--        <span class="side-menu__label">{{ __('dashboard.lift_centers') }}</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                    @endif

                    @if (auth()->user()->hasPermission('read_sliders'))
                        <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.sliders.index') }}">
                                <i class="las la-sliders-h la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('dashboard.sliders') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_donations'))
                    
                        <!--<li class="slide">-->
                        <!--    <a class="side-menu__item" href="{{ route('dashboard.paid-donations.index') }}">-->
                        <!--        <i class="las la-hand-holding-heart la-2x ml-2"></i>-->
                        <!--        <span class="side-menu__label">{{ __('translation.donations') }}</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-hand-holding-heart la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.donations') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.paid-donations.create') }}">{{ __('إنشاء تبرع') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.paid-donations.index') }}">{{ __('translation.donations') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.unpaid-donations.index') }}">{{ __('التبرعات الغير مدفوعة') }}</a></li>                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_users'))
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-users-cog la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.users') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.user-groups.index') }}">{{ __('translation.user_groups') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.users.index') }}">{{ __('translation.users') }}</a></li>
                            </ul>
                        </li>
                    @endif

                    {{-- @if (auth()->user()->hasPermission('read_marketers')) --}}
                        <!-- <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.marketers.index') }}">
                                <i class="las la-microphone la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.marketers') }}</span>
                            </a>
                        </li> -->
                    {{-- @endif --}}

                    {{-- @if (auth()->user()->hasPermission('read_beneficiaries_requests')) --}}
                        <!-- <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.beneficiaries-requests.index') }}">
                                <i class="las la-hand-holding la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.beneficiaries_requests') }}</span>
                            </a>
                        </li> -->
                    {{-- @endif --}}



                    @if (auth()->user()->hasPermission('read_general_assembly_members'))
                        <!-- <li class="slide">-->
                        <!--    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">-->
                        <!--        <i class="las la-user-check la-2x ml-2"></i>-->
                        <!--        <span class="side-menu__label">{{ __('translation.general_assembly_members') }}</span>-->
                        <!--        <i class="angle fe fe-chevron-down"></i>-->
                        <!--    </a>-->
                        <!--    <ul class="slide-menu">-->
                        <!--        <li><a class="slide-item" href="{{ route('dashboard.packages.index') }}">{{ __('translation.packages') }}</a></li>-->
                        <!--        <li><a class="slide-item" href="{{ route('dashboard.general-assembly-members.index') }}">{{ __('translation.general_assembly_members') }}</a></li>-->
                        <!--        <li><a class="slide-item" href="{{ route('dashboard.general-assembly-invoices.index') }}">{{ __('translation.general_assembly_invoices') }}</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                    @endif

                    @if (auth()->user()->hasPermission('read_donors'))
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-user-secret la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.donors') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.donors.index') }}">{{ __('translation.donors') }}</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_contacts'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-hourglass-end la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.message_members') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.message-members.individual-messaging.index') }}">{{ __('translation.individual_messaging') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    {{-- @if (auth()->user()->hasPermission('read_invoices'))
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-file-invoice-dollar la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.invoices') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.general-assembly-invoices.index') }}">{{ __('translation.general_assembly_invoices') }}</a></li>
                            </ul>
                        </li>
                    @endif --}}


                    @if (auth()->user()->hasPermission('read_services'))
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-handshake la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.services') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.service-sections.index') }}">{{ __('translation.sections') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.services.index') }}">{{ __('translation.services') }}</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_gifts'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-gifts la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.gifts') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.gift-categories.index') }}">{{ __('translation.gift_categories') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.gifts.index') }}">{{ __('translation.gifts') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    @if (auth()->user()->hasPermission('read_albir_friends'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-file-archive la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.albir_friends') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.albir-friends.general-assembly-members.index') }}">{{ __('translation.general_assembly_members') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.albir-friends.donor-membership.index') }}">{{ __('translation.donor_membership') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.albir-friends.volunteer-membership.index') }}">{{ __('translation.volunteer_membership') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.albir-friends.beneficiaries-membership.index') }}">{{ __('translation.beneficiaries_membership') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    @if (auth()->user()->hasPermission('read_get_to_know_us'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-info la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.get_to_know_us') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.get-to-know-us.brief.index') }}">{{ __('translation.brief') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.get-to-know-us.board-of-directors.index') }}">{{ __('translation.board_of_directors') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.get-to-know-us.services-albir.index') }}">{{ __('translation.services_albir') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.get-to-know-us.organizational-chart.index') }}">{{ __('translation.organizational_chart') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.get-to-know-us.statistics.index') }}">{{ __('translation.statistics') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.seasonal-projects.index') }}">{{ __('translation.seasonal_projects') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.events.index') }}">{{ __('translation.events') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.governance-material.index') }}">{{ __('translation.governance_material') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    @if (auth()->user()->hasPermission('read_photos'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-images la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('dashboard.images') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.photo-sections.index') }}">{{ __('translation.sections') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.photos.index') }}">{{ __('translation.photos') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    @if (auth()->user()->hasPermission('read_blogs'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-blog la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.blogs') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.blog-sections.index') }}">{{ __('translation.sections') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.blogs.index') }}">{{ __('translation.blogs') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    @if (auth()->user()->hasPermission('read_videos'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">
                                <i class="las la-video la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.videos') }}</span>
                                <i class="angle fe fe-chevron-down"></i>
                            </a>
                            <ul class="slide-menu">
                                <li><a class="slide-item" href="{{ route('dashboard.video-sections.index') }}">{{ __('translation.sections') }}</a></li>
                                <li><a class="slide-item" href="{{ route('dashboard.videos.index') }}">{{ __('translation.videos') }}</a></li>
                            </ul>
                        </li> -->
                    @endif

                    @if (auth()->user()->hasPermission('read_contacts'))
                        {{-- <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.contacts.index') }}">
                                <i class="las la-inbox la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('dashboard.contacts') }}</span>
                            </a>
                        </li> --}}
                    @endif



                    @if (auth()->user()->hasPermission('read_neighborhoods'))
                        {{-- <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.neighborhoods.index') }}">
                                <i class="las la-map-marker la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.neighborhoods') }}</span>
                            </a>
                        </li> --}}
                    @endif

                    @if (auth()->user()->hasPermission('read_branches'))
                        <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.branches.index') }}">
                                <i class="las la-search-location la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('translation.branches') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_partners'))
                        <!-- <li class="slide">
                            <a class="side-menu__item" href="{{ route('dashboard.partners.index') }}">
                                <i class="las la-handshake la-2x ml-2"></i>
                                <span class="side-menu__label">{{ __('dashboard.partners') }}</span>
                            </a>
                        </li> -->
                    @endif





                    {{-- @if (auth()->user()->hasPermission('read_reports')) --}}
                        <!--<li class="slide">-->
                        <!--    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)">-->
                        <!--        <i class="las la-folder-plus la-2x ml-2"></i>-->
                        <!--        <span class="side-menu__label">{{ __('translation.reports') }}</span>-->
                        <!--        <i class="angle fe fe-chevron-down"></i>-->
                        <!--    </a>-->
                        <!--    <ul class="slide-menu">-->
                        <!--        <li><a class="slide-item" href="#">{{ __('translation.reports') }}</a></li>-->
                        <!--        <li><a class="slide-item" href="#">{{ __('translation.general-reports') }}</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                    {{-- @endif --}}

				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
