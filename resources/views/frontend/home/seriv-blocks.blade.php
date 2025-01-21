@if ($quick_services->count() > 0)
    <section class="seriv-blocks pt-120 pb-90" style="background-image: url({{ URL::asset('frontend_files/assets/images/backgrounds/service-hand-bg-1-1.png') }});">
        <div class="container">
            <div class="block-title">
                <p>أهلا بكم في جمعية البر بجدة</p>
                <h3>للوصول إلى قنوات التبرع الرقمية لدينا يرجى اختيار إحدى الأقسام الظاهرة أو المزيد</h3>
            </div><!-- /.block-title -->
            <div class="row main-services">
                @foreach ($quick_services as $service)
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="service-block ">
                            <img src="{{ $service->image_path }}" width="80" height="70" alt="{{ $service->title }}">
                            <p>{{ $service->title }}</p>
                            <form class="service-form" action="{{ route('frontend.service.cart.store', $service->id) }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $service->basic_service_value }}" name="amount">
                                <input type="hidden" min="1" value="1" name="quantity">
                                <button type="submit" class="add-cart"><i class="fas fa-cart-plus"></i> أضف إلى السلة</button>
                            </form>
                            <a href="#" data-toggle="modal" data-target="#exampleModal3{{ $service->id }}" class="pay-now"><i class="fas fa-wallet"></i> أدفع الآن</a>
                            <span class="price-service">
                                {{ $service->basic_service_value }}
                                <span>ريال سعودي</span>
                            </span>
                        </div>
                    </div>

                    <div class="modal fade pay-now-modal exampleModal3Model" id="exampleModal3{{ $service->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content quick-modal">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2"> ادفع الآن - <span class="text-muted">{{ $service->title }}</span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="donateNowForm" action="{{ route('frontend.donate-now.store', $service->id) }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="service_id" value="{{ $service->id }}">

                                        <div class="form-group quick-amount">
                                            <input type="number" name="amount" value="{{ old('amount') }}" class="form-control amountNum" readonly disabled required placeholder="مبلغ التبرع">
                                            <span>ر.س</span>
                                            {{-- <span id="amount_erro" class="text-danger"></span> --}}
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="serv-label">الكمية</label>
                                            <input type="number" name="quantity" id="quantityNum" value="{{ old('quantity', 1) }}" class="form-control " min="1" step="1" required>
                                            <span id="quantity_error_index" class="text-danger"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="serv-label">القيمة الاجمالية</label>
                                            <input type="numper" name="total" id="totalNum" value="{{ old('total') }}" class="form-control" readonly required>
                                            <span id="" class="total_amount_error_index text-danger"></span>
                                        </div>

                                        @guest('donor')
                                            <div class="form-group">
                                                <label for="" class="serv-label"> رقم الجوال</label>
                                                <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="@lang('translation.phone_placeholder')">
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
                @endforeach
            </div><!-- /.causes-col__3 -->
        </div><!-- /.container -->
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
@endif
