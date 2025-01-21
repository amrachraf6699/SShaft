@extends('dashboard.layouts.master')
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('dashboard_files/assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Internal Morris Css-->
<link href="{{URL::asset('dashboard_files/assets/plugins/morris.js/morris.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ trans('dashboard.welcome_auth', ['name' => auth()->user()->name]) }}</h2>
                <p class="mg-b-0">{{ __('dashboard.text_statistics') }}</p>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
                <!-- row -->
                <div class="row row-sm">
                    <!--<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">-->
                    <!--    <div class="card overflow-hidden sales-card bg-primary-gradient">-->
                    <!--        <div class="pl-3 pt-3 pr-3 pb-2 pt-0">-->
                    <!--            <div class="">-->
                    <!--                <h6 class="mb-3 tx-12 text-white">{{ __('translation.count_general_assembly_members') }}</h6>-->
                    <!--            </div>-->
                    <!--            <div class="pb-0 mt-0">-->
                    <!--                <div class="d-flex">-->
                    <!--                    <div class="">-->
                    <!--                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $count_general_assembly_members }}</h4>-->
                    <!--                    </div>-->
                    <!--                    <span class="float-right my-auto mr-auto">-->
                    <!--                        <i class="las la-user-check text-white la-2x"></i>-->
                    <!--                    </span>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-danger-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{ __('translation.count_donors') }}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $count_donors }}</h4>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="las la-user-secret text-white la-2x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-success-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{ __('translation.count_services') }}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $count_services }}</h4>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="las la-handshake text-white la-2x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">-->
                    <!--    <div class="card overflow-hidden sales-card bg-purple-gradient">-->
                    <!--        <div class="pl-3 pt-3 pr-3 pb-2 pt-0">-->
                    <!--            <div class="">-->
                    <!--                <h6 class="mb-3 tx-12 text-white">{{ __('translation.count_gifts') }}</h6>-->
                    <!--            </div>-->
                    <!--            <div class="pb-0 mt-0">-->
                    <!--                <div class="d-flex">-->
                    <!--                    <div class="">-->
                    <!--                        <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $count_gifts }}</h4>-->
                    <!--                    </div>-->
                    <!--                    <span class="float-right my-auto mr-auto">-->
                    <!--                        <i class="las la-gifts text-white la-2x"></i>-->
                    <!--                    </span>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                <!-- row closed -->

                <!-- row -->
				<div class="row row-sm">
					<div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-info-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{ __('translation.count_donations') }}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $count_donations }}</h4>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="las la-hand-holding-heart text-white la-2x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-warning-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{ __('translation.count_contacts') }}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $count_contacts }}</h4>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="las la-inbox text-white la-2x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

					{{-- <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-success-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{ __('web.companies_orders') }}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white"></h4>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="las la-building text-white la-2x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <div class="card overflow-hidden sales-card bg-purple-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">{{ __('dashboard.customers') }}</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white"></h4>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="las la-users-cog text-white la-2x"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
				</div>
                <!-- row closed -->

                <!-- row -->
				<div class="row row-sm">
                    <div class="col-md-6">
						<div class="card mg-b-md-20">
							<div class="card-body">
								<div class="main-content-label mg-b-5">
									@lang('dashboard.categories_chart')
								</div>
								<p class="mg-b-20 text-muted">@lang('dashboard.categories_chart_p')</p>
								<div class="morris-donut-wrapper-demo" id="morrisDonut1"></div>
							</div>
						</div>
                    </div><!-- col-6 -->
					<div class="col-md-6">
						<div class="card mg-b-md-20">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5">
                                    @lang('translation.orders_donations')
                                </div>
                                <div class="morris-wrapper-demo" id="morrisLine1"></div>
                            </div>
                        </div>
                    </div><!-- col-6 -->
				</div>
                <!-- row closed -->

                <!-- row -->
				<div class="row row-sm">
                    <div class="col-xl-6 col-md-12 col-lg-6">
						<div class="card">
							<div class="card-header pb-0">
								<h3 class="card-title mb-2">{{ __('translation.status_donations') }}</h3>
								<p class="tx-12 mb-0 text-muted">{{ __('translation.paid_donations') . ' - ' . __('translation.unpaid_donations') }}</p>
							</div>
							<div class="card-body sales-info ot-0 pt-0 pb-0">
								<div id="chart" class="ht-150"></div>
								<div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
									<div class="col-md-6 col">
										<p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>{{ __('translation.paid_donations') }}</p>
										<h3 class="mb-1">{{ $paid_donations }}</h3>
										<div class="d-flex">
											<p class="text-muted "></p>
										</div>
									</div>
									<div class="col-md-6 col">
										<p class="mb-0 d-flex"><span class="legend bg-info brround"></span>{{ __('translation.unpaid_donations') }}</p>
											<h3 class="mb-1">{{ $unpaid_donations }}</h3>
										<div class="d-flex">
											<p class="text-muted"></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-xl-6 col-md-12 col-lg-6">
						<div class="card overflow-hidden latest-tasks">
							<div class="">
								<div class="d-flex justify-content-between pl-4 pt-4 pr-4">
									<h4 class="card-title mg-b-10">@lang('translation.notes') <span class="badge badge-info">{{ $notes->count() }}</span></h4>
								</div>
							</div>
							<div class="card-body pt-3">
								<div class="tab-content">
									<div class="tab-pane fade active show" id="tasktab-1" role="tabpanel">
										<div class="" style="height: 157px; overflow: auto;">
                                            @if ($notes->count() > 0)
                                                @foreach ($notes as $index => $note)
                                                    <div class="tasks {{ $loop->last ? 'mb-0' : '' }}">
                                                        <div class="task-line @if ($note->status === 'new') teal @elseif($note->status === 'completed') success @else primary @endif">
                                                            <a href="#" class="span">
                                                                {{ $note->content }}
                                                            </a>
                                                            <div class="time">
                                                                {{ $note->created_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                        <label class="checkbox">
                                                            <div class="btn-icon-list">
                                                                {{-- note update --}}
                                                                {{-- <form action="{{ route('dashboard.notes.update', $note->id) }}" method="POST" style="display: inline-block">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="btn btn-link text-primary d-inline" style="padding: 9px 5px;">{{ __('dashboard.update') }}</button>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <select name="status" class="form-control form-control-sm d-inline">
                                                                                <option value="" {{ $note->status === 'new' ? 'selected ': '' }} disabled>جديدة</option>
                                                                                <option value="progress" {{ $note->status === 'progress' ? 'selected ': '' }}>{{ __('dashboard.progress') }}</option>
                                                                                <option value="completed" {{ $note->status === 'completed' ? 'selected ': '' }}>تم الإنتهاء</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <button type="submit" class="btn btn-link text-primary d-inline">{{ __('dashboard.update') }}</button>
                                                                        </div>
                                                                    </div>
                                                                </form> --}}
                                                                {{-- note delete --}}
                                                                <form action="{{ route('dashboard.notes.destroy', $note->id) }}" method="post" style="display: inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-link text-danger delete" style="margin-right: 3px; padding: 9px 5px;">حذف</button>
                                                                </form>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="tasks mb-0">
                                                    @lang('dashboard.no_data_found')
                                                </div>
                                            @endif
										</div>
										<div class="mt-4">
                                            <form action="{{ route('dashboard.notes.store') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                                                        <div class="input-group">
                                                            <input class="form-control" name="content" placeholder="اكتب ملاحظتك..." type="text">
                                                            @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <span class="input-group-btn">
                                                                        <i class="las la-paper-plane"></i>
                                                                    </span>
                                                                </button>
                                                            </span>
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </form>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div><!-- col-6 -->
				</div>
                <!-- row closed -->

                <!-- row -->
				<div class="row row-sm">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card ">
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="d-flex align-items-center pb-2">
											<p class="mb-0">{{ __('translation.total_paid_donations') }}</p>
										</div>
										<h4 class="font-weight-bold mb-2">{{ number_format($total_paid_donations, 2) . ' ' . __('dashboard.SAR') }}</h4>
										<div class="progress progress-style progress-sm">
											<div class="progress-bar bg-primary-gradient" style="width: {{ $percent_paid_total }}%" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
										</div>
									</div>
									<div class="col-md-6 mt-4 mt-md-0">
										<div class="d-flex align-items-center pb-2">
											<p class="mb-0">{{ __('translation.total_unpaid_donations') }}</p>
										</div>
										<h4 class="font-weight-bold mb-2">{{ number_format($total_unpaid_donations, 2) . ' ' . __('dashboard.SAR') }}</h4>
										<div class="progress progress-style progress-sm">
											<div class="progress-bar bg-danger-gradient" style="width: {{ $percent_unpaid_total }}%" role="progressbar"  aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
				</div>
                <!-- row closed -->

			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('dashboard_files/assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  Morris js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{URL::asset('dashboard_files/assets/plugins/morris.js/morris.min.js')}}"></script>
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('dashboard_files/assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('dashboard_files/assets/js/apexcharts.js')}}"></script>
<script>
    $(document).ready(function() {
        /*categories_chart*/
        new Morris.Donut({
            element: 'morrisDonut1',
            data: [
                @foreach ($categories_chart as $category)
                    {
                        label: "{{ $category->title }}",
                        value: "{{ $category->services_count }}"
                    },
                @endforeach
            ],
            colors: ['#6d6ef3', '#285cf7', '#f7557a'],
            resize: true,
            labelColor:"#8c9fc3"
        });

        /*donations_data*/
        new Morris.Line({
            element: 'morrisLine1',
            data: [
                @foreach ($donations_data as $donation)
                    {
                        y: "{{ $donation->year }}",
                        a: "{{ $donation->total }}",
                    },
                @endforeach
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['@lang('translation.count_donations')'],
            lineColors: ['#6d6ef3', '#285cf7'],
            lineWidth: 1,
            ymax: 'auto 1000',
            gridTextSize: 11,
            hideHover: 'auto',
            resize: true
        });

        /*--- Apex (#chart) ---*/
        var options = {
            chart: {
            height: 205,
            type: 'radialBar',
            offsetX: 0,
            offsetY: 0,
        },
        plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            size: 120,
            imageWidth: 50,
                imageHeight: 50,

            track: {
            strokeWidth: "80%",
            background: '#ecf0fa',
            },
            dropShadow: {
                    enabled: false,
                    top: 0,
                    left: 0,
                    bottom: 0,
                    blur: 3,
                    opacity: 0.5
                },
            dataLabels: {
            name: {
                fontSize: '16px',
                color: undefined,
                offsetY: 30,
            },
            hollow: {
                size: "60%"
                },
            value: {
                offsetY: -10,
                fontSize: '22px',
                color: undefined,
                formatter: function (val) {
                return val + "%";
                }
            }
            }
        }
        },
        colors: ['#0db2de'],
        fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            type: "horizontal",
            shadeIntensity: .5,
            gradientToColors: ['#005bea'],
            inverseColors: !0,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
        },
        stroke: {
            dashArray: 4
        },
        series: [{{ $percent_count }}],
            labels: [""]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
        /*--- Apex (#chart)closed ---*/
    });

</script>
@endsection
