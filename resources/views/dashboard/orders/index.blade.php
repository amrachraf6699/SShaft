@extends('dashboard.layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('dashboard_files/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.paid_donations') }}</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<!--div-->
					<div class="col-md-12">
                        @include('dashboard.paid-donations.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dashboard.paid-donations.export') }}" class="btn btn-purple btn-with-icon mr-2">
                                        <i class="las la-file-export ml-1"></i> {{ __('translation.export') }}
                                    </a>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                    <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                </a>
                            </div>

                            <div class="table-responsive">
                                @if($donations->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">{{ __('translation.membership_no') }}</th>
                                                <th class="py-2">{{ __('dashboard.total_amount') }}</th>
                                                <th class="py-2">{{ __('translation.payment_ways') }}</th>
                                                <th class="py-2">{{ __('translation.payment_brand') }}</th>
                                                <th class="py-2">{{ __('translation.services') }}</th>
                                                <th class="py-2">{{ __('translation.donation_code') }}</th>
                                                <th class="py-2">{{ __('translation.donation_type') }}</th>
                                                <th class="py-2">{{ __('dashboard.status') }}</th>
                                                <th class="py-2">{{ __('dashboard.created_at') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($donations as $donation)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$donation->id}}" class="box1"></td>
                                                    <td>{{ $donation->donor->membership_no ?? __('translation.null') }}</td>
                                                    <td>{{ $donation->total_amount }}</td>
                                                    <td>{{ __('translation.' . $donation->payment_ways) }}</td>
                                                    <td>{{ $donation->payment_brand }}</td>
                                                    <td>
                                                        @if ($donation->donation_type === 'gift')
                                                            <span class="badge badge-teal">{{ __('translation.gift') }}</span>
                                                        @elseif ($donation->donation_type === 'beneficiary')
                                                            <span class="badge badge-teal">{{ __('translation.beneficiary') }}: {{ $donation->beneficiary->title }}</span>
                                                        @else
                                                            @foreach ($donation->services as $service)
                                                                <span class="badge badge-teal">{{ $service->title }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $donation->donation_code }}</td>
                                                    <td>{{ __('translation.' . $donation->donation_type) }}</td>
                                                    <td>
                                                        @if ($donation->status == 'paid')
                                                            <i class="text-success las la-check-circle la-2x"></i>
                                                        @else
                                                            <i class="text-warning las la-times-circle la-2x"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $donation->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            <a href="{{ route('donation-invoice.show', $donation->donation_code) }}" target="_blank" class="btn btn-info btn-icon"><i class="typcn typcn-eye-outline"></i></a>
                                                            {{-- donation invoice --}}
                                                            @if ($donation->payment_ways == 'bank_transfer')
                                                                <a href="{{ route('dashboard.paid-donations.edit', $donation->id) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-pencil"></i></a>
                                                                <a href="{{ $donation->transfer_receipt }}" target="_blank" class="btn btn-purple btn-icon"><i class="las la-link"></i></a>
                                                            @endif
                                                            {{-- donation delete --}}
                                                            <form action="{{ route('dashboard.paid-donations.destroy', $donation->id) }}" method="post" style="display: inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-icon delete" style="margin-right: 5px"><i class="typcn typcn-delete"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="12">
                                                    <div class="float-right">
                                                        {!! $donations->appends(request()->input())->links() !!}
                                                    </div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <h4 class="text-center pb-4">{{ __('dashboard.no_data_found') }}</h4>
                                @endif
                            </div><!-- bd -->
						</div><!-- bd -->
					</div>
					<!--/div-->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
        <!-- main-content closed -->

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ __('dashboard.multiple_delete') }}
                        </h5>
                    </div>

                    <form action="{{ route('dashboard.paid-donations.destroy_all') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            {{ __('dashboard.warning_multiple_delete') }}
                            <input type="hidden" id="delete_all_id" name="ids" value=" ">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('dashboard.close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('dashboard.confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('js')
<!-- Internal Select2 js-->
<script src="{{ URL::asset('dashboard_files/assets/plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $("#btnDeleteAll").click(function() {
            var selected = new Array();
            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });
            if (selected.length <= 0) {
                $('#btnDeleteAll').removeAttr('data-target');
            } else {
                $('#deleteModal').modal('show');
                $('input[id="delete_all_id"]').val(selected);
            }
        });

        $('.select2').select2({
            placeholder: '@lang('translation.service_filter')',
        });
    });
</script>
@endsection
