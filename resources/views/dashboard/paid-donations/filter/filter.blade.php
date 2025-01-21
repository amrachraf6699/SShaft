<div class="card card-primary">
    <div class="card-body">
        {!! Form::open(['route' => 'dashboard.paid-donations.index', 'method' => 'get']) !!}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <span>بحث</span>
                        {!! Form::text('keyword', old('keyword', request()->input('keyword')), ['class' => 'form-control', 'placeholder' => trans('dashboard.search_here')]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <span>الفرع</span>
                        {!! Form::select('branch_id', ['' => '--'] + $branches->toArray(), old('branch_id', request()->input('branch_id')), ['class' => 'select2 form-control', 'placeholder' => trans('الفرع')]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <span>الخدمة</span>
                        {!! Form::select('service_id', ['' => '--'] + $services->toArray(), old('service_id', request()->input('service_id')), ['class' => 'select2 form-control']) !!}
                    </div>
                </div>
                <div class="col-md-1 col-6">
                    <div class="form-group">
                        <span>الدفع</span>
                        {!! Form::select('payment_ways', ['' => trans('translation.payment_ways'), 'credit_card' => trans('translation.credit_card'), 'bank_transfer' => trans('translation.bank_transfer'), ], old('payment_ways', request()->input('payment_ways')), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <span>فرز حسب</span>
                        {!! Form::select('sort_by', ['' => trans('dashboard.sort_by'), 'donor_id' => trans('translation.donor'), 'donation_type' => trans('translation.donation_type'), 'payment_ways' => trans('translation.payment_ways'), 'payment_brand' => trans('translation.payment_brand'), 'created_at' => trans('dashboard.created_at')], old('sort_by', request()->input('sort_by')), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <span>الترتيب</span>
                        {!! Form::select('order_by', ['' => trans('dashboard.order_by'), 'ASC' => trans('dashboard.ascending'), 'DESC' => trans('dashboard.descending')], old('order_by', request()->input('order_by')), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-1 col-6">
                    <div class="form-group">
                        <span>إظهار عدد</span>
                        {!! Form::select('limit_by', ['10' => '10', '20' => '20', '50' => '50', '100' => '100'], old('limit_by', request()->input('limit_by')), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::button(trans('dashboard.search'), ['class' => 'btn btn-purple', 'type' => 'submit']) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
