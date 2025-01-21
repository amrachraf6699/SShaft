<div class="card card-primary">
    <div class="card-body">
        {!! Form::open(['route' => 'dashboard.employment-applications.index', 'method' => 'get']) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::text('keyword', old('keyword', request()->input('keyword')), ['class' => 'form-control', 'placeholder' => trans('dashboard.search_here')]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::select('sort_by', ['' => trans('dashboard.sort_by'), 'created_at' => trans('dashboard.created_at')], old('sort_by', request()->input('sort_by')), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        {!! Form::select('order_by', ['' => trans('dashboard.order_by'), 'ASC' => trans('dashboard.ascending'), 'DESC' => trans('dashboard.descending')], old('order_by', request()->input('order_by')), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-1 col-6">
                    <div class="form-group">
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
