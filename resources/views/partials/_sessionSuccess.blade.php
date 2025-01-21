@if (session('sessionSuccess'))
    <!-- Done Message -->
    <div class="alert-msg open">
        <div class="white-box done">
            <i class="far fa-check-circle"></i>
            <p>{{ session('sessionSuccess') }}</p>
            <button>موافق</button>
        </div>
    </div>
    <!-- ./Done Message -->
@endif
