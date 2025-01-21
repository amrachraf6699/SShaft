@extends('frontend.layouts.app')

@section('content')
    <section class="page-header">
        <div class="page-header__bg" style="background-image: url({{ URL::asset('frontend_files/assets/images/k3.png') }});"></div>
        <!-- /.page-header__bg -->
        <div class="container">
            <h2>التحويل البنكي</h2>
            <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                <li><a href="{{ route('frontend.home') }}">الرئيسية</a></li>
                <li>-</li>
                <li><span>التحويل البنكي</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    <section>
        <div class="container">
            <div class="row m-3 justify-content-center ">
                <h2 class="text-center col-12"> <img src="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}" alt="logo" class="ml-2">الحسابات البنكية</h2>
                <div class="col-12 card">
                    {{-- <label class="control-label h4 pt-2">الحسابات البنكية : </label> --}}
                    <table class="table table-striped jambo_table text-center table-responsive d-lg-table">
                        <thead>
                            <tr class="headings  text-center">
                                <th class="">{{ __('translation.bank_name') }}</th>
                                <th class="">{{ __('translation.account_number') }}</th>
                                <th class="">{{ __('translation.IBAN') }}</th>
                                <th class="">{{ __('translation.bank_link') }}</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            @if ($accounts->count() > 0)
                                @foreach ($accounts as $account)
                                    <tr class="">
                                        <td>{{ $account->bank_name }}</td>
                                        <td>{{ $account->account_number }}</td>
                                        <td>{{ $account->IBAN }}</td>
                                        <td><a href="{{ $account->bank_link }}" rel="no-fllow" target="_blank">ذهاب</a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <br>

                    <section class="form-page join-page container my-5" style="margin-bottom: 20px !important">
                        <form class="form-one" method="POST" action="{{ route('frontend.pay-general-assembly-members.bank-transfer.store', [$member->uuid, $invoice->invoice_no]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <h3 class="text-center">ارفاق صورة التحويل</h3>
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <div class="form-control">
                                            {!! Form::label('bank_name', 'اختار البنك المحول اليه :') !!}
                                            <select class="valid" name="bank_name" id="bank_name">
                                                <option value=""></option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->bank_name }}">{{ $account->bank_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('bank_name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <span>قم بأختيار صورة مناسبة</span>
                                        <input type="file" name="attachments" accept=".jpg, .jpeg, .png" class="form-control">
                                        @error('attachments')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-control form-control-full">
                                        {!! Form::submit('أضف', ['class' => 'thm-btn dynamic-radius']) !!}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
