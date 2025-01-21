@php
    $quick_donation_side_bar = quickDonationSideBar();
@endphp
@if ($quick_donation_side_bar->count() > 0)
    <!-- Quick Donation Side Bar -->
    <div class="side-donation">
        <button type="button" class="open-donation">
            تبرع سريع
            <span>
                <span>+</span>
            </span>
        </button>
        <div class="hidden-part">
            <div class="radio-area">
                <ul>
                    @foreach ($quick_donation_side_bar as $service)
                        <li>
                            <input type="radio" name="service" value="{{ $service->id }}" checked required>
                            <span>{{ $service->title }}</span>
                        </li>
                    @endforeach
                </ul>
                <span id="serviceId__err__sidebar" class="text-danger"></span>
            </div>
            <div class="main-part">
                @if ($service->price_value === 'multi')
                    <ul class="payment-amount">
                        <li>
                            <span>{{ $service->multiple_service_value_1 }} ر.س</span>
                        </li>
                        <li>
                            <span>{{ $service->multiple_service_value_2 }} ر.س</span>
                        </li>
                        <li>
                            <span>{{ $service->multiple_service_value_3 }} ر.س</span>
                        </li>
                    </ul>
                @endif

                @guest('donor')
                    <div class="input-payment mb-2">
                        <input type="tel" name="phone_number" placeholder="@lang('translation.phone_placeholder')" required>
                        <!--<span class="country-code">+966</span>-->
                    </div>
                @else
                    <div class="input-payment mb-2">
                        <input type="hidden" name="phone_number" value="{{ auth('donor')->user()->phone }}">
                    </div>
                @endguest
                <span id="phoneNumber__err__sidebar" class="text-danger"></span>

                <div class="input-payment">
                    <input type="number" name="total_amount" placeholder="قيمة المبلغ" required>
                    <span>ر.س</span>
                </div>
                <span id="total_amount__err__sidebar" class="text-danger"></span>
                <small class="danger"></small>
                {{-- <small class="danger">الرجاء إدخال مبلغ التبرع</small> --}}
                <p class="note">سيذهب تبرعك تلقائياً للحالات الأشد احتياجاً</p>
                <div class="form-group">

                    <div class="radio-area">
                        <ul class="paument-methods">
                            <li>
                                <input type="radio" name="payment_ways" required value="MADA">
                                <img src="{{ URL::asset('frontend_files/assets/images/payment/rounded-mada.svg') }}" alt="">
                            </li>
                            {{-- <li>
                                <input type="radio" name="payment_ways" required value="VISA">
                                <img src="{{ URL::asset('frontend_files/assets/images/payment/rounded-visa.svg') }}" alt="">
                            </li> --}}
                            <li>
                                <input type="radio" name="payment_ways" required value="VISA MASTER">
                                <img src="{{ URL::asset('frontend_files/assets/images/payment/credit-card.jpg') }}" alt="">
                            </li>
                            <li>
                                <input type="radio" name="payment_ways" required value="APPLEPAY">
                                <img src="{{ URL::asset('frontend_files/assets/images/payment/rounded-applepay.svg') }}" alt="">
                            </li>
                        </ul>
                        <span id="payment_brand__err__sidebar" class="text-danger"></span>
                    </div>
                </div>

                <button type="submit" id="quickCkeckout" class="donate-now toggle-btn">
                    <span>تبرع الآن</span>
                </button>
            </div>

            <div class="second-part">
                <h3 class="title">
                    الدفع
                    <span class="left-block">
                        <input type="text" class="number-input" value="10" required>
                        <span>ر.س</span>
                    </span>
                    <span class="close-payment"><i class="fas fa-arrow-left"></i></span>
                </h3>

                <div id="showPayFormQuickDonation"></div>
            </div>
        </div>
    </div>
    <!-- ./Quick Donation Side Bar -->
@endif
