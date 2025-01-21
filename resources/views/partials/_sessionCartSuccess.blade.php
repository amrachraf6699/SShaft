@if (session('sessionCartSuccess'))
    <!-- Done Message -->
    <div class="alert-msg open">
        <div class="white-box done">
            <i class="far fa-check-circle"></i>
            <p>{{ __('translation.operation_accomplished_successfully') }}</p>
            <div class="text-center"><a href="{{ route('frontend.cart.index') }}">{{ __('translation.go_to_cart') }}</a></div>
            <button>موافق</button>
        </div>
    </div>
    <!-- ./Done Message -->
@endif
