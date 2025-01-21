@extends('dashboard.layouts.master')
@section('css')

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ __('translation.general_assembly_invoices') }}</h4>
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
                        @include('dashboard.general-assembly-invoices.filter.filter')
						<div class="card card-primary">
							<div class="card-header py-3 d-flex">
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:void(0);" class="btn btn-danger btn-with-icon mr-2" id="btnDeleteAll" data-toggle="modal" data-target="#deleteModal">
                                        <i class="las la-trash ml-1"></i> {{ __('dashboard.multiple_delete') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if($invoices->count() > 0)
                                    <table id="datatable" class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th class="py-2"><input name="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                                                <th class="py-2">{{ __('translation.invoice_no') }}</th>
                                                <th class="py-2">{{ __('translation.invoice_status') }}</th>
                                                <th class="py-2">{{ __('translation.member') }}</th>
                                                <th class="py-2">{{ __('translation.invoice_issue_date') }}</th>
                                                <th class="py-2">{{ __('translation.payment_ways') }}</th>
                                                <th class="py-2">{{ __('dashboard.amount') }}</th>
                                                <th class="py-2">{{ __('dashboard.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td><input type="checkbox" value="{{$invoice->id}}" class="box1"></td>
                                                    <td>{{ $invoice->invoice_no }}</td>
                                                    <td>
                                                        <span class="badge badge-pill badge-{{ $invoice->invoice_status == 'paid' ? 'success' : 'warning' }}">{{ __('translation.' . $invoice->invoice_status) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($invoice->general_assembly_member)
                                                            {{ $invoice->general_assembly_member->full_name }}
                                                            <br> [{{ $invoice->general_assembly_member->membership_no }}] [{{ $invoice->general_assembly_member->package->title }}]
                                                        @endif
                                                    </td>
                                                    <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                                    <td>
                                                        @if ($invoice->payment_ways == 'bank_transfer')
                                                            <a href="javascript:void(0);" class="btn btn-info btn-sm">{{ __('translation.' . $invoice->payment_ways) }}</a>
                                                            <a href="{{ $invoice->transfer_receipt }}" target="_blank"><i class="text-purple las la-link la-2x"></i></a>
                                                        @else
                                                            <a href="javascript:void(0);" class="btn btn-info btn-sm">{{ $invoice->payment_brand ?? __('translation.' . $invoice->payment_ways) }}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $invoice->total_amount . ' ' . __('translation.SAR') }}</td>
                                                    <td>
                                                        <div class="btn-icon-list">
                                                            @if ($invoice->general_assembly_member)
                                                                <a href="{{ route('general-assembly-member-invoice.show', [$invoice->invoice_no, $invoice->general_assembly_member->uuid]) }}" target="_blank" class="btn btn-info btn-icon"><i class="typcn typcn-eye-outline"></i></a>
                                                            @endif
                                                            {{-- invoice edit --}}
                                                            @if ($invoice->payment_ways == 'bank_transfer')
                                                                <a href="{{ route('dashboard.general-assembly-invoices.edit', $invoice->id) }}" class="btn btn-primary btn-icon"><i class="typcn typcn-pencil"></i></a>
                                                            @endif
                                                            {{-- invoice delete --}}
                                                            <form action="{{ route('dashboard.general-assembly-invoices.destroy', $invoice->id) }}" method="post" style="display: inline-block">
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
                                                        {!! $invoices->appends(request()->input())->links() !!}
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

                    <form action="{{ route('dashboard.general-assembly-invoices.destroy_all') }}" method="POST">
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
    });
</script>
@endsection
