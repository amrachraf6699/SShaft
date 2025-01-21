@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k7.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>{{ $section->title }}</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>{{ __('translation.beneficiaries_membership') }}</span></li>
                <li>-</li>
                <li><span>{{ $section->title }}</span></li>
                {{-- <li><a href="{{ route('frontend.services-sections', $section->slug) }}">{{ $section->title }}</a></li> --}}
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->


    @if ($beneficiaries->count() > 0)
        <section class="news-page causes-page pb-120 pt-120">
            <div class="container">
                <div class="row">
                    @foreach ($beneficiaries as $beneficiary)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="cause-card">
                                <span class="cause-type">{{ $beneficiary->service_section->title }}</span>
                                <div class="cause-card__inner">
                                    <div class="cause-card__image">
                                        <img src="{{ $beneficiary->image_path }}" alt="{{ $beneficiary->title }}">
                                    </div><!-- /.cause-card__image -->
                                    <div class="cause-card__content">
                                        <div class="cause-card__top">
                                            <div class="cause-card__progress">
                                                <span style="width: {{ $beneficiary->percent }}%;" class="wow cardProgress" data-wow-duration="1500ms">
                                                    <b><i>{{ $beneficiary->percent }}</i>%</b>
                                                </span>
                                            </div><!-- /.cause-card__progress -->
                                            <div class="cause-card__goals">
                                                <p><strong>تم جمع:</strong> {{ $beneficiary->collected_value ? $beneficiary->collected_value : 0 . ' ' . __('dashboard.SAR') }}</p>
                                                <p><strong>المبلغ المطلوب:</strong> {{ $beneficiary->target_value . ' ' . __('dashboard.SAR') }}</p>
                                            </div><!-- /.cause-card__goals -->
                                        </div><!-- /.cause-card__top -->
                                        <h3>
                                            <a href="{{ route('frontend.beneficiaries-requests.details', [$beneficiary->service_section->slug, $beneficiary->slug]) }}">{{ $beneficiary->title }}</a>
                                        </h3>
                                        <form class="service-form" action="{{ route('frontend.service.cart.store', $beneficiary->id) }}" method="POST">
                                            @csrf
                                            <div class="number-amount">
                                                <ul>
                                                    <li>المبلغ</li>
                                                    <li>الكمية</li>
                                                </ul>
                                            </div>
                                            <ul class="radio-btn">
                                                @if ($beneficiary->price_value === 'multi')
                                                        <li>
                                                            <input type="radio" value="{{ $beneficiary->multiple_service_value_1 }}" name="amount">
                                                            <span>{{ $beneficiary->multiple_service_value_1 }}</span>
                                                        </li>
                                                        <li>
                                                            <input type="radio" value="{{ $beneficiary->multiple_service_value_2 }}" name="amount">
                                                            <span>{{ $beneficiary->multiple_service_value_2 }}</span>
                                                        </li>
                                                        <li>
                                                            <input type="radio" value="{{ $beneficiary->multiple_service_value_3 }}" name="amount">
                                                            <span>{{ $beneficiary->multiple_service_value_3 }}</span>
                                                        </li>
                                                        {{-- <li class="another-cost">
                                                            <input type="number" placeholder="10 ر.س">
                                                            <input type="radio" value="100" name="amount">
                                                            <span>مبلغ أخر</span>
                                                        </li> --}}
                                                        <li class="count">
                                                            <input type="number" min="1" value="1" name="quantity">
                                                            <ul>
                                                                <li class="add-btn"><i class="fas fa-angle-up"></i></li>
                                                                <li class="minus-btn"><i class="fas fa-angle-down"></i></li>
                                                            </ul>
                                                        </li>
                                                @elseif ($beneficiary->price_value === 'fixed')
                                                    <li class="custom-cost another-cost">
                                                        <input type="number" min="1" value="{{ $beneficiary->basic_service_value }}" name="amount" disabled readonly>
                                                    </li>
                                                    <li class="count">
                                                        <input type="number" min="1" value="1" name="quantity">
                                                        <ul>
                                                            <li class="add-btn"><i class="fas fa-angle-up"></i></li>
                                                            <li class="minus-btn"><i class="fas fa-angle-down"></i></li>
                                                        </ul>
                                                    </li>
                                                @elseif ($beneficiary->price_value === 'variable')
                                                    <li class="custom-cost another-cost">
                                                        <input type="number" min="1" value="{{ old('amount') }}" name="amount">
                                                    </li>
                                                    <li class="count">
                                                        <input type="number" min="1" value="1" name="quantity">
                                                        <ul>
                                                            <li class="add-btn"><i class="fas fa-angle-up"></i></li>
                                                            <li class="minus-btn"><i class="fas fa-angle-down"></i></li>
                                                        </ul>
                                                    </li>
                                                @elseif ($beneficiary->price_value === 'percent')
                                                    <input type="hidden" class="percent" name="percent" value="{{ $beneficiary->basic_service_value }}">
                                                    <li class="custom-cost">
                                                        <input type="number" min="1" class="totalAmount" value="{{ old('totalAmount') }}" name="totalAmount">
                                                    </li>
                                                    <li class="custom-cost another-cost">
                                                        <input type="number" min="1" value="{{ old('amount') }}" name="amount" class="amount" readonly disabled>
                                                    </li>
                                                    <li class="count">
                                                        <input type="number" min="1" value="1" name="quantity">
                                                        <ul>
                                                            <li class="add-btn"><i class="fas fa-angle-up"></i></li>
                                                            <li class="minus-btn"><i class="fas fa-angle-down"></i></li>
                                                        </ul>
                                                    </li>
                                                @endif
                                            </ul>
                                            @error('amount')<span class="text-danger">{{ $message }}</span>@enderror
                                            <div class="cause-card__bottom">
                                                {{-- <a href="{{ route('frontend.beneficiaries-requests.details', [$beneficiary->service_section->slug, $beneficiary->slug]) }}" class="thm-btn dynamic-radius">تبرع الان</a> --}}

                                                <a href="#" data-toggle="modal" data-target="#exampleModal3{{ $beneficiary->id }}" class="thm-btn dynamic-radius">تبرع الان</a>
                                                {{-- <button type="submit" class="cause-card__share add-to-cart" title="إضافة إلى السلة" style="border-color: transparent"><i class="fas fa-shopping-cart"></i></button> --}}
                                                <span class="total"></span>
                                                <!-- /.cause-card__share -->
                                            </div><!-- /.cause-card__bottom -->
                                        </form>
                                    </div><!-- /.cause-card__content -->
                                </div><!-- /.cause-card__inner -->
                            </div><!-- /.cause-card -->
                        </div>

                        <div class="modal fade pay-now-modal exampleModal3Model" id="exampleModal3{{ $beneficiary->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content quick-modal">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2"> ادفع الآن - <span class="text-muted">{{ $beneficiary->title }}</span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="donateNowForm" action="{{ route('frontend.donate-now.store', $beneficiary->id) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="beneficiary_id" value="{{ $beneficiary->id }}">
                                            <input type="hidden" name="beneficiary_slug" value="{{ $beneficiary->slug }}">
                                            <input type="hidden" name="section_slug" value="{{ $beneficiary->service_section->slug }}">

                                            <div class="form-group quick-amount">
                                                @if ($beneficiary->price_value === 'fixed' || $beneficiary->price_value === 'percent' || $beneficiary->price_value === 'multi')
                                                    <input type="number" name="amount" value="{{ old('amount') }}" class="form-control amountNum" disabled readonly required placeholder="مبلغ التبرع">
                                                @else
                                                    <input type="number" name="amount" value="{{ old('amount') }}" class="form-control amountNum" required placeholder="مبلغ التبرع">
                                                @endif
                                                <span>ر.س</span>
                                                <span id="amount_err" class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="serv-label">الكمية</label>
                                                <input type="number" name="quantity" id="quantityNum" value="{{ old('quantity', 1) }}" class="form-control " min="1" step="1" required>
                                                <span id="quantity_err" class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="serv-label">القيمة الاجمالية</label>
                                                <input type="numper" name="total" id="totalNum" value="{{ old('total') }}" class="form-control" readonly required>
                                                <span id="total_amount_err" class="text-danger"></span>
                                            </div>

                                            @guest('donor')
                                                <div class="form-group">
                                                    <label for="" class="serv-label"> رقم الجوال</label>
                                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="@lang('translation.phone_placeholder')">
                                                    <span id="phoneNumber_err" class="text-danger"></span>
                                                </div>
                                            @else
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="phone_number" value="{{ auth('donor')->user()->phone }}">
                                                </div>
                                            @endguest

                                            <div class="form-group">
                                                <label>اختر طريقة الدفع:</label>
                                                <div class="radio-btns">
                                                    <div class="radio-box">
                                                        <input type="radio" name="payment_ways" required value="bank_transfer">
                                                        <span>
                                                            <i class="fas fa-coins"></i>
                                                            تحويل بنكي
                                                        </span>
                                                    </div>
                                                    <div class="radio-box">
                                                        <input type="radio" name="payment_ways" required value="MADA">
                                                        <span>
                                                            <i class="fas fa-money-check"></i>
                                                            بطاقة مدى
                                                        </span>
                                                    </div>
                                                    <div class="radio-box">
                                                        <input type="radio" name="payment_ways" required value="VISA MASTER">
                                                        <span>
                                                            <i class="fab fa-cc-mastercard"></i>
                                                            بطاقة إئتمانية
                                                        </span>
                                                    </div>
                                                    {{-- style="display:none;" --}}
                                                    <div class="radio-box" id="apple-pay">
                                                        <input type="radio" name="payment_ways" required value="APPLEPAY">
                                                        <span>
                                                            <i class="fab fa-apple-pay"></i>
                                                            Apple pay
                                                        </span>
                                                    </div>
                                                    @error('payment_ways')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div><!-- /.form-control -->
                                                {{-- <small>في حالة التحويل البنكي ولاتمام العملية قم بارفاق إيصال السداد وبيانات البنك من صفحة الفواتير</small> --}}
                                                <span id="payment_brand_err" class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" id="ckeckout" class="form-control confirm" value="ادفع الآن">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {!! $beneficiaries->appends(request()->input())->links() !!}
            </div><!-- /.container -->
        </section><!-- /.news-page -->

        <!-- Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <h2 class="text-center col-12"> <img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2">دفع مبلغ <strong id="t_amount"></strong> ريال سعودي</h2>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div id="showPayForm"></div>
                    </div>

                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('dashboard.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script>
        $(function() {
            $(document).on('click', '#ckeckout', function(e) {
                var paymentWays = $(this).parents('.pay-now-modal').find('input[type="radio"][name="payment_ways"]:checked').val();

                var beneficiaryId   = $(this).parents('.pay-now-modal').find('input[type="hidden"][name="beneficiary_id"]').val();
                var beneficiarySlug = $(this).parents('.pay-now-modal').find('input[type="hidden"][name="beneficiary_slug"]').val();
                var sectionSlug     = $(this).parents('.pay-now-modal').find('input[type="hidden"][name="section_slug"]').val();

                if (paymentWays != 'bank_transfer') {
                    e.preventDefault();

                    $('#quantity_err').text('');
                    $('#total_amount_err').text('');
                    $('#phoneNumber_err').text('');
                    $('#payment_brand_err').text('');

                    var phoneNumber = $(this).parents('.pay-now-modal').find('input[name="phone_number"]').val();
                    var toalAmount  = $(this).parents('.pay-now-modal').find('input[name="total"]').val();
                    var quantity    = $(this).parents('.pay-now-modal').find('input[name="quantity"]').val();
                    $('#t_amount').empty('');

                    $.ajax({
                        type: 'get',
                        url: "{{ route('frontend.beneficiaries.check-out') }}",
                        data: {
                            total_amount: toalAmount,
                            phoneNumber: phoneNumber,
                            beneficiaryId: beneficiaryId,
                            beneficiarySlug: beneficiarySlug,
                            beneficiarySectionSlug: sectionSlug,
                            quantity: quantity,
                            payment_brand: paymentWays,
                        }, success: function(data) {
                            if (data.status == true ) {
                                $('.exampleModal3Model').modal('hide');
                                $('#paymentModal').modal('show');
                                $('#t_amount').append(toalAmount);
                                $('#showPayForm').empty().html(data.content);
                            }
                        }, error: function(reject) {
                        var res = $.parseJSON(reject.responseText);
                        $.each(res.errors, function(key, value) {
                            $("#" + key + "_err").text(value[0]);
                        });
                    }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
              //submitting amount value
            // if user change the quantity
            $(".totalAmount").change(function () {
                if ($(".percent").val() > 0) {
                    var total = $(".totalAmount").val() * $(".percent").val() / 100;
                    $(".amount").val(total);
                }
            });
        });
    </script>
@endsection
