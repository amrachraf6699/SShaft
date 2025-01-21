<section class="site-footer">
    <div class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div id="map-container">
                        @if ($setting->link_map_address)
                            {!! $setting->link_map_address !!}
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <h3><i class="fa fa-globe"></i>تعرف علينا </h3>
                    <ul>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.brief.view') }}">عن الجمعية</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.services-albir.view') }}">الخدمات</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.organizational-chart.view') }}">{{ __('translation.organizational_chart') }}</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.statistics.view') }}">{{ __('translation.statistics') }}</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.seasonal-projects.view') }}">{{ __('translation.seasonal_projects') }}</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.events.view') }}">{{ __('translation.events') }}</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.about-the-association.governance-material.view') }}">{{ __('translation.governance_material') }}</a></li>
                    </ul>
                    <h3><i class="fa fa-users"></i> العضويات </h3>
                    <ul>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.albir-friends.view') }}">{{ __('translation.general_assembly_members') }}</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.albir-friends.registration-form.view', 'donor_membership') }}">{{ __('translation.donors') }}</a></li>
                        <li><i class="fa fa-link"></i><a href="{{ route('frontend.albir-friends.registration-form.view', 'beneficiaries_membership') }}">{{ __('translation.beneficiaries_membership') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-12">
                    <div class="right-col">
                        <h3><i class="fas fa-project-diagram"></i> روابط أخرى </h3>
                        @php
                            $modules = gitModules()
                        @endphp
                        <ul>
                            @if ($modules->count() > 0)
                                @foreach ($modules as $module)
                                    <li><i class="fa fa-link"></i><span><a href="{{ route('frontend.section.modules.show', $module->slug) }}">{{ $module->title }}</a></span></li>
                                @endforeach
                            @endif
                            <li><i class="fa fa-link"></i><span><a href="{{ route('frontend.surveys.index') }}">{{ __('translation.surveys') }}</a></span></li>
                            <li><i class="fa fa-link"></i><span><a href="{{ route('frontend.employment-application.index') }}">{{ __('translation.employment_application') }}</a></span></li>
                        </ul>
                    </div>
                    <div class="left-col">
                        <h3><i class="fas fa-phone"></i> مركز خدمة العملاء </h3>
                        <ul>
                            <li><i class="fa fa-link"></i><a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></li>
                        </ul>

                        <!-- Download Apps -->
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ URL::asset('frontend_files/assets/images/apps-ios.png') }}" class="img-fluid app-img">
                            </div>
                            <div class="col-6">
                                <img src="{{ URL::asset('frontend_files/assets/images/apps-android.png') }}" class="img-fluid app-img">
                            </div>
                        </div>
                        <!-- ./Download Apps-->
                    </div>
                </div>

                <div class="col-12">
                    <div class="payment-gateways">
                        <h3>وسائل الدفع:</h3>
                        <ul>
                            <li>
                                <img src="{{ URL::asset('frontend_files/assets/images/method01.png') }}" alt="بطاقة مدى">
                            </li>
                            <li>
                                <img src="{{ URL::asset('frontend_files/assets/images/method02.png') }}" alt="أبل باي">
                            </li>
                            <li>
                                <img src="{{ URL::asset('frontend_files/assets/images/method03.png') }}" alt="ماستر كارد">
                            </li>
                            <li>
                                <img src="{{ URL::asset('frontend_files/assets/images/method04.png') }}" alt="فيزا كارد">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="down-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <p>
                        جميع الحقوق محفوظة لجمعية البر بجدة <span>&copy;</span>
                        2012 - 2021
                    </p>
                </div>
                <div class="col-md-6 col-12">
                    <p class="share-power">
                        <a href="https://share.net.sa/" title="تنفيذ شير لتقنية المعلومات">
                            تنفيذ:
                            <img src="{{ URL::asset('frontend_files/assets/images/share-logo.png') }}" title="تنفيذ شير لتقنية المعلومات">
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
