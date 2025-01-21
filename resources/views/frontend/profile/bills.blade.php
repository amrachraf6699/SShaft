@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ __('translation.my_bills') }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.my_bills') }}</span></li>
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

                        @if ($bills->count() > 0)
                            <div class="edit-profile grid-area">
                                <div class="header">
                                    <h2>{{ __('translation.my_bills') }}</h2>
                                </div>

                                <section class="container my-6 bills-page">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">

                                            <thead>
                                            <tr>
                                                <th>{{ __('translation.donation_code') }}</th>
                                                <th>{{ __('translation.created_at') }}</th>
                                                <th>{{ __('translation.payment_ways') }}</th>
                                                <th>{{ __('translation.donation_type') }}</th>
                                                <th>عدد الخدمات</th>
                                                <th>قيمة الفاتورة</th>
                                                <th>{{ __('dashboard.status') }}</th>
                                                <th>تفاصيل</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bills as $bill)
                                                    <tr>
                                                        <td>{{ $bill->donation_code }}</td>
                                                        <td>{{ $bill->created_at->format('d/m/Y') }}</td>
                                                        <td>{{ $bill->payment_ways === 'bank_transfer' ? __('translation.' . $bill->payment_ways) : $bill->payment_brand }}</td>
                                                        <td>{{ __('translation.' . $bill->donation_type) }}</td>
                                                        <td>{{ $bill->services_count }}</td>
                                                        <td>{{ $bill->total_amount }} ر.س</td>
                                                        <td>
                                                            @if ($bill->status == 'paid')
                                                                {{ __('translation.paid') }}
                                                            @else
                                                                {{ __('translation.unpaid') }}
                                                                <br>
                                                                <a class="bill-details" href="{{ route('frontend.donations.credit-card.view', [$bill->donation_code, 'MADA']) }}" title="بطاقة مدى"><i class='fas fa-money-check'></i></a>
                                                                <a class="bill-details" href="{{ route('frontend.donations.credit-card.view', [$bill->donation_code, 'VISA MASTER']) }}" title="بطاقة إئتمانية"><i class='fab fa-cc-mastercard'></i></a>
                                                                <a class="bill-details" href="{{ route('frontend.donations.bank-transfer.view', $bill->donation_code) }}" title="تحويل بنكي"><i class='fas fa-coins'></i></a>
                                                            @endif
                                                        </td>
                                                        <td><a class="bill-details" href="{{ route('donation-invoice.show', $bill->donation_code) }}" target="_blank"><i class='fas fa-info-circle'></i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- pagination -->
                                    {!! $bills->appends(request()->input())->links() !!}
                                    <!-- ./Pagination -->
                                </section>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./Dashboard -->
@endsection
