@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});">
        </div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>سلة التبرعات</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>سلة التبرعات</span></li>
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

                        @if ($items->count() > 0)
                            <div class="edit-profile grid-area">
                                <div class="header">
                                    <h2>سلة التبرعات</h2>
                                </div>

                                <form action="{{ route('frontend.donations.store') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="table-resposnive">
                                        {{-- <input type="hidden" name="ids"> --}}
                                        <table class="table shopping-cart">
                                            <thead>
                                                <tr>
                                                    {{-- <th><input type="checkbox"></th> --}}
                                                    <th>المشروع</th>
                                                    <th>القيمة</th>
                                                    <th>الكمية</th>
                                                    <th>الإجمالي</th>
                                                    <th>حذف</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr>
                                                        {{-- <td><input type="checkbox" value="{{ $item->service->id }}" name="donate_id"></td> --}}
                                                        <td>{{ $item->service->title }}</td>
                                                        <td class='sub-price'>{{ $item->amount }} ر.س</td>
                                                        <td class="count">
                                                            <button type="button" class="plus">+</button>
                                                            <input type="text" name="service[{{ $item->service->id }}][quantity]" value="{{ $item->quantity }}" readonly>
                                                            <button type="button" class="minus">-</button>
                                                        </td>
                                                        <td class="sub-total">{{ $item->subtotal }} ر.س</td>
                                                        <td class="delete">
                                                            <a href="{{ route('frontend.cart.destroy', $item->service->id) }}"><i class="far fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>الإجمالي</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="all-total">{{ $items->sum('subtotal') }} ر.س</td>
                                                    <td class="delete">
                                                        <a href="{{ route('frontend.cart.empty-the-cart') }}">إفراغ السلة</a>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Payment methods -->
                                    <div class="payment-method">
                                        <div class="radio-area">
                                            <h4>اختر طريقة الدفع:</h4>
                                            <ul>
                                                <li>
                                                    <input type="radio" name="payment_ways" required value="bank_transfer">
                                                    <span>
                                                        <i class="fas fa-coins"></i>
                                                        تحويل بنكي
                                                    </span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="payment_ways" required value="MADA">
                                                    <span>
                                                        <i class="fas fa-money-check"></i>
                                                        بطاقة مدى
                                                    </span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="payment_ways" required value="VISA MASTER">
                                                    <span>
                                                        <i class="fab fa-cc-mastercard"></i>
                                                        بطاقة إئتمانية
                                                    </span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="payment_ways" required value="APPLEPAY">
                                                    <span>
                                                        <i class="fab fa-apple-pay"></i>
                                                        Apple pay
                                                    </span>
                                                </li>
                                            </ul>
                                            @error('payment_ways')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <small>في حالة التحويل البنكي ولاتمام العملية قم بارفاق إيصال السداد وبيانات البنك من صفحة الفواتير</small>
                                        <div class="form-one">
                                            <div class="form-group">
                                                <div class="form-control form-control-full">
                                                    <button type="submit" class="thm-btn dynamic-radius">تبرع الآن</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- ./Payment methods -->
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./Dashboard -->
@endsection
