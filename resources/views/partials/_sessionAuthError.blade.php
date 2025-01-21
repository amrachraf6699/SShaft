@if (session('sessionAuthError'))
    <!-- Failed Message -->
    <div class="alert-msg open">
        <div class="white-box">
            <i class="far fa-exclamation-circle"></i>
            <p>{{ __('translation.please_log_in') }}</p>
            <button>موافق</button>
        </div>
    </div>
    <!-- ./Failed Message -->
@endif
