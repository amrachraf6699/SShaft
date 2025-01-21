@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>تبرعاتي</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>تبرعاتي</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <!-- Dashboard -->
    <section class="main-dashboard">
        <div class="grid-container">
            <div class="container">
                <div class="row">
                    @include('frontend.profile.sidenav')

                    <div class="col-md-9 col-12">
                        @include('frontend.profile.nav')

                        @if ($donations->count() > 0)
                            <div class="edit-profile grid-area">
                                <div class="header">
                                    <h2>سجل التبرعات</h2>
                                </div>

                                <div class="my-doantions">
                                    <div class="row">
                                        @foreach ($donations as $donation)
                                            <div class="col-md-6 col-12">
                                                <div class="sub-donation">
                                                    <span class="number">
                                                        <span>
                                                            <a href="{{ route('donation-invoice.show', $donation->donation_code) }}" target="_blank" class="text-white" title="عرض الفاتورة">
                                                                <i class='fas fa-arrow-left'></i>
                                                            </a>
                                                        </span>
                                                    </span>
                                                    <ul>
                                                        <li>
                                                            <span><i class="fas fa-hand-holding-usd"></i> كود التبرع:</span>
                                                            <p>{{ $donation->donation_code }} [{{ __('translation.' . $donation->donation_type) }}]</p>
                                                        </li>
                                                        <li>
                                                            <span><i class="far fa-calendar-alt"></i> تاريخ التبرع:</span>
                                                            <p>{{ $donation->created_at->format('d/m/Y') }}</p>
                                                        </li>
                                                        <li>
                                                            <span><i class="fas fa-wallet"></i> القيمة الإجمالية للتبرع:</span>
                                                            <p>{{ $donation->total_amount }} ر.س</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- pagination -->
                                        {!! $donations->appends(request()->input())->links() !!}
                                        <!-- ./Pagination -->
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./Dashboard -->
@endsection
