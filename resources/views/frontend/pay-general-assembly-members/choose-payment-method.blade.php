@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section class="choose-payment-method">
        <div class="container">
            <div class="row m-3 justify-content-center ">
                <h2 class="text-center col-12">
                    <img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2">
                    من فضلك حدد طريقة الدفع المناسبة لك.
                </h2>

                <form action="{{ route('frontend.pay-general-assembly-members.choose-payment-method.store', [$member->uuid, $invoice->invoice_no]) }}" method="POST">
                    @csrf
                    @method('POST')

                    <!-- Payment methods -->
                    <div class="payment-method">
                        <div class="radio-area">
                            {{-- <h4>اختر طريقة الدفع:</h4> --}}
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
                        {{-- <small>في حالة التحويل البنكي ولاتمام العملية قم بارفاق إيصال السداد وبيانات البنك من صفحة الفواتير</small> --}}
                        <div class="form-one">
                            <div class="form-group">
                                <div class="form-control form-control-full">
                                    <button id="ckeckout" type="submit" class="thm-btn dynamic-radius">إدفع الآن</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ./Payment methods -->
                </form>
            </div>
        </div>
    </section>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModalChoose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
@endsection

@section('js')
    <script>
        $(function() {
            $(document).on('click', '#ckeckout', function(e) {
                var paymentWays = $(this).parents('.choose-payment-method').find('input[type="radio"][name="payment_ways"]:checked').val();

                if (paymentWays != 'bank_transfer') {
                    e.preventDefault();

                    $(this).parents('.choose-payment-method').find('.quantity_error_choose_pay_method').text('');
                    $(this).parents('.choose-payment-method').find('.total_amount_error_choose_pay_method').text('');
                    $(this).parents('.choose-payment-method').find('.phoneNumber_error_choose_pay_method').text('');
                    $(this).parents('.choose-payment-method').find('.payment_brand_error_choose_pay_method').text('');

                    $('#t_amount').empty('');

                    $.ajax({
                        type: 'get',
                        url: "{{ route('frontend.members.choose-payment-method.check-out') }}",
                        data: {
                            total_amount: {{ $invoice->total_amount }},
                            invoice_no: "{{ $invoice->invoice_no }}",
                            member_uuid: "{{ $member->uuid }}",
                            payment_brand: paymentWays,
                        }, success: function(data) {
                            if (data.status == true ) {
                                console.log(data.content);
                                $('#paymentModalChoose').modal('show');
                                $('#t_amount').append({{ $invoice->total_amount }});
                                $('#showPayForm').empty().html(data.content);
                            }
                        }, error: function(reject) {
                        var res = $.parseJSON(reject.responseText);
                        $.each(res.errors, function(key, value) {
                            $("." + key + "_error_choose_pay_method").text(value[0]);
                        });
                    }
                    });
                }
            });
        });
    </script>
@endsection
