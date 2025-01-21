@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>تفاصيل الحالة</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>تفاصيل الحالة</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="event-details pt-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="describ-serv">
                        <h2>{{ $beneficiary->title }}</h2>
                        <h3>وصف الحالة</h3>
                        {!! $beneficiary->content !!}
                    </div>
                    {{-- <div class="work-serv">
                        <h3>طريقة عمل الخدمة</h3>
                        {!! $beneficiary->how_does_the_service_work !!}
                    </div> --}}
                </div><!-- /.col-md-12 -->
                <div class="col-md-12 col-lg-6">
                    <img src="{{ $beneficiary->image_path }}" alt="{{ $beneficiary->title }}" class="img-fluid">
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->

        {{-- <div class="order-serv">
            <div class="container">
                <h3>اطلب هذه الخدمة الان</h3>
                <br>
                <form action="{{ route('frontend.donate-now.store', $service->id) }}" method="POST" class="contact-page__form form-one mb-40">
                    @csrf
                    <div class="form-group">
                        <div class="form-control">
                            <label for="" class="serv-label">القيمة</label>
                            <input type="text" name="amount" value="{{ old('amount') }}" class="amount" required>
                            <span id="amount_error" class="text-danger"></span>
                        </div><!-- /.form-control -->
                        <div class="form-control">
                            <label for="" class="serv-label">أدخل الكمية</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" step="1" required>
                            <span id="quantity_error" class="text-danger"></span>
                        </div><!-- /.form-control -->

                        <div class="form-control">
                            <label for="" class="serv-label">القيمة الاجمالية</label>
                            <input type="text" name="total" id="total" value="{{ old('total') }}" class="" readonly required>
                            <span id="total_amount_error" class="text-danger"></span>
                        </div><!-- /.form-control -->

                        <div class="form-control">
                            @guest('donor')
                                <div class="form-group">
                                    <label for="" class="serv-label"> رقم الجوال</label>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="@lang('translation.phone_placeholder')">
                                    <span id="phoneNumber_error" class="text-danger"></span>
                                </div>
                            @else
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="phone_number" value="{{ auth('donor')->user()->phone }}">
                                </div>
                            @endguest
                        </div>

                        <div class="form-control">
                            <label for="" class="serv-label">اختر طريقة الدفع</label>
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

                                <div class="radio-box" id="apple-pay">
                                    <input type="radio" name="payment_ways" required value="APPLEPAY">
                                    <span>
                                        <i class="fab fa-apple-pay"></i>
                                        Apple pay
                                    </span>
                                </div>
                            </div><!-- /.form-control -->
                            <span id="payment_brand_error" class="text-danger"></span>

                            <div class="charity-form">
                                <button id="ckeckout" type="submit" class="thm-btn dynamic-radius">تبرع الآن</button>
                            </div>
                        </div><!-- /.form-group -->
                </form><!-- /.contact-page__form -->

            </beneficiary        </div> --}}
    </section><!-- /.event-details -->

    <!-- Modal -->
    {{-- <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div> --}}

@endsection

{{-- @section('js')
    <script>
        $(document).ready(function() {
              //submitting amount value
            // if user change the quantity
            $("#quantity").change(function () {
                if ($(".amount").val() > 0) {
                    var total = $(".amount").val() * $("#quantity").val();
                    $("#total").val(total);
                }
            });
            // if user write custom open donation
            $(".amount").change(function () {
                if ($(".amount").val() > 0) {
                    var total = $(".amount").val() * $("#quantity").val();
                    $("#total").val(total);
                }
            });
            // if user select from units or fixed or share donation
            $(".donation-value").change(function () {
                var dType = $(this).parent().text();
                $(".donation_type_name").val($.trim(dType)); // add donation type to hidden feild
                $(".amount").val(this.value);
                var total = this.value * $("#quantity").val();
                $("#total").val(total);
            });
        });
    </script>

    <script>
        $(document).on('click', '#ckeckout', function(e) {
            var paymentWays = $(this).parents('.event-details').find('input[type="radio"][name="payment_ways"]:checked').val();
            if (paymentWays != 'bank_transfer') {
                e.preventDefault();

                $(this).parents('.event-details').find('#quantity_error').text('');
                $(this).parents('.event-details').find('#total_amount_error').text('');
                $(this).parents('.event-details').find('#phoneNumber_error').text('');
                $(this).parents('.event-details').find('#payment_brand_error').text('');

                var phoneNumber = $(this).parents('.event-details').find('input[name="phone_number"]').val();
                var toalAmount  = $(this).parents('.event-details').find("#total").val();
                var quantity    = $(this).parents('.event-details').find("#quantity").val();

                $('#t_amount').empty('');
                $.ajax({
                    type: 'get',
                    url: "{{ route('frontend.service.check-out') }}",
                    data: {
                        total_amount: toalAmount,
                        phoneNumber: phoneNumber,
                        serviceId: {{ $service->id }},
                        serviceSlug: '{{ $service->slug }}',
                        serviceSectionSlug: '{{ $service->service_section->slug }}',
                        quantity: quantity,
                        payment_brand: paymentWays,
                    },
                    success: function(data) {
                        if (data.status == true ) {
                            $('#paymentModal').modal('show');
                            $('#t_amount').append(toalAmount);
                            $('#showPayForm').empty().html(data.content);
                        }
                    }, error: function(reject) {
                        var res = $.parseJSON(reject.responseText);
                        $.each(res.errors, function(key, value) {
                            $("#" + key + "_error").text(value[0]);
                        });
                    }
                });
            }
        });
    </script>
@endsection --}}
