<div class="col-md-3 col-12">
    <div class="profile grid-area">
        <div class="img">
            <!-- <i class="fas fa-ellipsis-v"></i> -->
            {{-- <img src="{{ URL::asset('frontend_files/assets/images/p1.png') }}"> --}}

            <h3>{{'عضوية رقم: ' . auth('donor')->user()->membership_no }}</h3>
            {{-- @if ($member)
                <h3>{{'عضوية رقم: ' . $member->membership_no }}</h3>
            @else
                <h3>{{'عضوية رقم: ' . auth('donor')->user()->membership_no }}</h3>
            @endif --}}
        </div>
        <div class="profile-data">
            <div class="data-details">
                <h5>عدد التبرعات</h5>
                {{-- <h4><span>{{ $totalDonations->sum('services_count') }}</span>  تبرع</h4> --}}
                <h4><span>{{ $totalDonations->count() }}</span>  تبرع</h4>
            </div>
            <div class="data-details">
                <h5>مجمل التبرعات</h5>
                <h4><span>{{ $totalDonations->sum('total_amount') }}</span>  ر.س</h4>
            </div>
        </div>
    </div>
</div>
