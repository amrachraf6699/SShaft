<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافة اهداء</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @guest('donor')
                    <form method="POST" action="{{ route('frontend.sendOtp') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"  placeholder="@lang('translation.phone_placeholder')">
                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control confirm" value="تأكيد الجوال ">
                        </div>
                        <div class="alert alert-info text-center">{{ __('translation.phone_note') }}</div>
                    </form>
                @else
                    <form method="POST" action="{{ route('frontend.store-a-gift') }}">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="donor_id" value="{{ auth('donor')->user()->id }}">

                        <div class="form-group">
                            <input type="number" class="form-control" value="{{ old('total_amount') }}" name="total_amount" placeholder="مبلغ الإهداء">
                            @error('total_amount')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ old('sender_name', auth('donor')->user()->name) }}" name="sender_name" placeholder="إسم المرسل">
                            @error('sender_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" value="{{ old('sender_phone', auth('donor')->user()->phone) }}" name="sender_phone" placeholder="رقم جوالك">
                            @error('sender_phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ old('recipient_phone') }}" name="recipient_name" placeholder="إسم المرسل إليه">
                            @error('recipient_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <input type="tel" class="form-control" value="{{ old('recipient_phone') }}" name="recipient_phone" placeholder="رقم جوال المرسل إلية">
                            @error('recipient_phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" value="{{ old('recipient_email') }}" name="recipient_email" placeholder="بريد المرسل إلية">
                            @error('recipient_email')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        {{-- <div class="form-group">
                            <select required name="gift_category_id">
                                <option disabled selected>اختر فئة الإهداء</option>
                                @if ($categories->count() > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('gift_category_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <ul class="templates-area">
                                <li>
                                    <p>كرت الإهداء:</p>
                                </li>
                            </ul>
                            @error('gift_card_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
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
                                    <div class="radio-box" id="apple-pay">
                                        <input type="radio" name="payment_ways" required value="APPLEPAY">
                                        <span>
                                            <i class="fab fa-apple-pay"></i>
                                            Apple pay
                                        </span>
                                    </div>
                                    @error('payment_ways')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div><!-- /.form-control -->
                            <small>في حالة التحويل البنكي ولاتمام العملية قم بارفاق إيصال السداد وبيانات البنك من صفحة الفواتير</small>
                        </div> --}}
                        <div class="form-group">
                            <input type="submit" class="form-control confirm" value="إرسال الإهداء">
                        </div>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>
