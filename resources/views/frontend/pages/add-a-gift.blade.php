@extends('frontend.layouts.app')

@section('content')
    <section class="form-page container my-5">
        <form class="form-one gift-form" method="POST" action="{{ route('frontend.store-a-gift') }}">
            @csrf
            @method('POST')

            <h3>إهداء تبرع</h3>
            <div class="row">
                <input type="hidden" name="donor_id" value="{{ auth('donor')->user()->id }}">
                <div class="col-md-6 col-12">
                    <input type="text" class="form-control" value="{{ old('sender_name', auth('donor')->user()->name) }}" name="sender_name" placeholder="إسم المرسل">
                    @error('sender_name')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="sender_name_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-6 col-12">
                    <input type="tel" class="form-control" value="{{ old('sender_phone', auth('donor')->user()->phone) }}" name="sender_phone" placeholder="رقم جوالك">
                    @error('sender_phone')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="sender_phone_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-6 col-12">
                    <input type="number" class="form-control" value="{{ old('total_amount') }}" name="total_amount" placeholder="مبلغ الإهداء">
                    @error('total_amount')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="total_amount_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-6 col-12">
                    <input type="text" class="form-control" value="{{ old('recipient_name') }}" name="recipient_name" placeholder="إسم المرسل إليه">
                    @error('recipient_name')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="recipient_name_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-6 col-12">
                    <input type="tel" class="form-control" value="{{ old('recipient_phone') }}" name="recipient_phone" placeholder="رقم جوال المرسل إلية">
                    @error('recipient_phone')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="recipient_phone_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-6 col-12">
                    <input type="email" class="form-control" value="{{ old('recipient_email') }}" name="recipient_email" placeholder="بريد المرسل إلية">
                    @error('recipient_email')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="recipient_email_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-12">
                    <select required name="gift_category_id">
                        <option disabled selected>اختر فئة الإهداء</option>
                        @if ($categories->count() > 0)
                            @foreach ($categories as $category)
                                <option value="{{ old('gift_category_id', $category->id )}}">{{ $category->title }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('gift_category_id')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="gift_category_id_error__gift" class="text-danger"></span>
                </div>
                <div class="col-md-12">
                    <ul class="templates-area">
                        <li>
                            <p>كرت الإهداء:</p>
                        </li>
                    </ul>
                    @error('gift_card_id')<span class="text-danger">{{ $message }}</span>@enderror
                    <span id="gift_card_id_error__gift" class="text-danger"></span>
                </div>
                <div class="form-control">
                    <div class="col-12">
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
                            {{-- style="display:none;" --}}
                            <div class="radio-box" id="apple-pay">
                                <input type="radio" name="payment_ways" required value="APPLEPAY">
                                <span>
                                    <i class="fab fa-apple-pay"></i>
                                    Apple pay
                                </span>
                            </div>
                        </div>
                        @error('payment_ways')<span class="text-danger">{{ $message }}</span>@enderror
                        <span id="payment_brand_error__gift" class="text-danger"></span>
                    </div><!-- /.form-control -->
                    <small>في حالة التحويل البنكي ولاتمام العملية قم بارفاق إيصال السداد وبيانات البنك من صفحة الفواتير</small>
                </div>
                <div class="col-md-12">
                    <div class="form-control form-control-full">
                        <input id="ckeckout" type="submit" class="thm-btn dynamic-radius" value="إهداء">
                    </div>
                </div>
            </div>
        </form>
    </section>

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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('select[name="gift_category_id"]').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: "{{ URL::to('gift-category') }}/" + categoryID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('.templates-area').empty();
                            $.each(data, function(key, value) {
                                $('.templates-area').append(
                                    '<li><input type="radio" name="gift_card_id" value="' + key + '" required><img src="{{ asset('storage/uploads/gift_cards/') }}/' + value + '"></li>'
                                );
                            });
                        },
                    });
                } else {
                    $('.templates-area').empty();
                    console.log('not found');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '#ckeckout', function(e) {
            var paymentWays = $(this).parents('.form-page').find('input[type="radio"][name="payment_ways"]:checked').val();
            if (paymentWays != 'bank_transfer') {
                e.preventDefault();

                $(this).parents('.form-page').find('#total_amount_error__gift').text('');
                $(this).parents('.form-page').find('#sender_name_error__gift').text('');
                $(this).parents('.form-page').find('#sender_phone_error__gift').text('');
                $(this).parents('.form-page').find('#recipient_name_error__gift').text('');
                $(this).parents('.form-page').find('#recipient_phone_error__gift').text('');
                $(this).parents('.form-page').find('#recipient_email_error__gift').text('');
                $(this).parents('.form-page').find('#gift_category_id_error__gift').text('');
                $(this).parents('.form-page').find('#gift_card_id_error__gift').text('');
                $(this).parents('.form-page').find('#payment_brand_error__gift').text('');

                var donorId = $(this).parents('.form-page').find('input[name="donor_id"]').val();
                var totalAmount  = $(this).parents('.form-page').find('input[name="total_amount"]').val();
                var senderName = $(this).parents('.form-page').find('input[name="sender_name"]').val();
                var senderPhone = $(this).parents('.form-page').find('input[name="sender_phone"]').val();
                var recipientName = $(this).parents('.form-page').find('input[name="recipient_name"]').val();
                var recipientPhone = $(this).parents('.form-page').find('input[name="recipient_phone"]').val();
                var recipientEmail = $(this).parents('.form-page').find('input[name="recipient_email"]').val();
                var giftCategoryId = $(this).parents('.form-page').find('select[name="gift_category_id"]').val();
                var giftCardId = $(this).parents('.form-page').find('input[type="radio"][name="gift_card_id"]:checked').val();

                $('#t_amount').empty('');
                $.ajax({
                    type: 'get',
                    url: "{{ route('frontend.add-gift.check-out') }}",
                    data: {
                        donor_id: donorId,
                        total_amount: totalAmount,
                        sender_name: senderName,
                        sender_phone: senderPhone,
                        recipient_name: recipientName,
                        recipient_phone: recipientPhone,
                        recipient_email: recipientEmail,
                        gift_category_id: giftCategoryId,
                        gift_card_id: giftCardId,
                        payment_brand: paymentWays,
                    },
                    success: function(data) {
                        if (data.status == true ) {
                            $('#paymentModal').modal('show');
                            $('#t_amount').append(totalAmount);
                            $('#showPayForm').empty().html(data.content);
                        }
                    }, error: function(reject) {
                        var res = $.parseJSON(reject.responseText);
                        $.each(res.errors, function(key, value) {
                            $("#" + key + "_error__gift").text(value[0]);
                        });
                    }
                });
            }
        });
    </script>
@endsection
