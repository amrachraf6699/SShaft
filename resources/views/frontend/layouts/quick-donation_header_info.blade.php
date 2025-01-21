@guest('donor')
    <div class="header-info__box">
        <i class="fas fa-donate"></i>
        <div class="header-info__box-content">
            <h3>التبرع السريع</h3>
            <p><a data-toggle="modal" data-target="#exampleModal1">تبرع الآن</a></p>
        </div><!-- /.header-info__box-content -->
    </div><!-- /.header-info__box -->
@else
    <div class="header-info__box">
        {{-- <i class="fas fa-donate"></i> --}}
        <div class="header-info__box-content">
            {{-- <h3>التبرع السريع</h3> --}}
            <p><a data-toggle="modal" data-target="#exampleModal1">مرحباً، {{ auth('donor')->user()->membership_no }}</a></p>
        </div><!-- /.header-info__box-content -->
    </div><!-- /.header-info__box -->
@endguest
