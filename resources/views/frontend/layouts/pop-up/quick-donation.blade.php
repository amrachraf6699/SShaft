<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @guest('donor')
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('web.login') }}</h5>
                @else
                    <h5 class="modal-title" id="exampleModalLabel">مرحباً، {{ auth('donor')->user()->name ?? '' }}</h5>
                @endguest
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @guest('donor')
                    <form method="POST" action="{{ route('frontend.quick-donation.sendOtp') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="@lang('translation.phone_placeholder')">
                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control confirm" value="تأكيد الجوال ">
                        </div>
                        <div class="alert alert-info text-center">{{ __('translation.phone_note') }}</div>
                    </form>
                @else
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('frontend.profile.show-profile-information', auth('donor')->user()->username) }}" style="padding: 5px; margin: 5px 0;" class="thm-btn dynamic-radius btn-block">
                                <i class="fa fa-user-edit" aria-hidden="true"></i> بياناتي
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.cart.index') }}" style="padding: 5px; margin: 5px 0;" class="thm-btn dynamic-radius btn-block">
                                <i class="fas fa-shopping-basket" aria-hidden="true"></i> {{ __('translation.cart') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.donations.index') }}" style="padding: 5px; margin: 5px 0;" class="thm-btn dynamic-radius btn-block">
                                <i class="fas fa-shopping-basket" aria-hidden="true"></i> سجل التبرعات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.my-bills.index') }}" style="padding: 5px; margin: 5px 0;" class="thm-btn dynamic-radius btn-block">
                                <i class="fas fa-shopping-basket" aria-hidden="true"></i> {{ __('translation.my_bills') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" style="padding: 5px; margin: 5px 0;" class="thm-btn dynamic-radius btn-block"
                                                    onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> <span>{{ __('web.logout') }}</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                @endguest
            </div>
        </div>
    </div>
</div>
