<!-- Quick donation pop up -->
<div class="modal fade pay-now-modal exampleModal3Model" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content quick-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تبرع سريعاً</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('frontend.store.quick-donation-slider') }}">
                    @csrf
                    <input type="hidden" class="service-id" name="service_id">
                    <div class="form-group quick-amount">
                        <input type="number" name="total" class="form-control" readonly placeholder="مبلغ التبرع">
                        <span>ر.س</span>
                        @error('total')<span class="text-danger">{{ $message }}</span>@enderror
                        <span id="" class="total_amount_error_index text-danger"></span>
                    </div>

                    <input type="hidden" name="quantity" id="quantityNum" value="{{ old('quantity', 1) }}" class="form-control " min="1" step="1" required>

                    @guest('donor')
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone_number" placeholder="@lang('translation.phone_placeholder')">
                            @error('phone_number')<span class="text-danger">{{ $message }}</span>@enderror
                            <span id="" class="phoneNumber_error_index text-danger"></span>
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
                                <input type="radio" name="payment_ways" required value="bank_transfer" aria-required="true">
                                <span>
                                    <i class="fas fa-coins"></i>
                                    تحويل بنكي
                                </span>
                            </div>

                            <div class="radio-box">
                                <input type="radio" name="payment_ways" required value="MADA" aria-required="true">
                                <span>
                                    <i class="fas fa-money-check"></i>
                                    بطاقة مدى
                                </span>
                            </div>

                            <div class="radio-box">
                                <input type="radio" name="payment_ways" required value="VISA MASTER" aria-required="true">
                                <span>
                                    <i class="fab fa-cc-mastercard"></i>
                                    بطاقة إئتمانية
                                </span>
                            </div>
                            {{-- style="display:none;" --}}
                            <div class="radio-box" id="apple-pay">
                                <input type="radio" name="payment_ways" required value="APPLEPAY" aria-required="true">
                                <span>
                                    <i class="fab fa-apple-pay"></i>
                                    Apple pay
                                </span>
                            </div>
                        </div>
                        @error('payment_ways')<span class="text-danger">{{ $message }}</span>@enderror
                        <span id="" class="payment_brand_error_index text-danger"></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" id="ckeckout" class="form-control confirm" value="ادفع الآن">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- ./Quick donation pop up -->
