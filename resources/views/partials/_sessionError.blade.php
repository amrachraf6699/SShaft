@if (session('sessionError'))
    <!-- Failed Message -->
    <div class="alert-msg open">
        <div class="white-box">
            <i class="far fa-times-circle"></i>
            <p>{{ session('sessionError') }}</p>
            <button>موافق</button>
        </div>
    </div>
    <!-- ./Failed Message -->
@endif
