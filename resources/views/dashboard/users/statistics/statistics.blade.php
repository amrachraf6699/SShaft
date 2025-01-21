@if ($groups->count() > 0)
    <div class="row justify-content-md-center">
        @foreach ($groups as $group)
            <div class="col-xl-3 col-lg-6 col-sm-6 col-md-6">
                <div class="card text-center">
                    <div class="card-body ">
                        {{-- <div class="feature widget-2 text-center mt-0 mb-3">
                            <i class="ti-pie-chart project bg-pink-transparent mx-auto text-pink "></i>
                        </div> --}}
                        <h6 class="mb-1 text-muted">{{ $group->title }}</h6>
                        <h3 class="font-weight-semibold">{{ $group->users_count }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
