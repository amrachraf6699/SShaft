<!DOCTYPE html>
<html>
	<head>
        @php
            $setting = setting()
        @endphp
		<meta charset="utf-8" />
		<title>{{ $setting->name }} {{ !empty($pageTitle) ? '» ' . $pageTitle : '' }}</title>
        <!-- favicons Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('frontend_files/assets/images/favicon.ico') }}">

        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/fontawesome-all.min.css') }}">
        <!-- template styles -->
        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('frontend_files/assets/css/rtl.css') }}">
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
        @include('partials._sessionSuccess')
        @include('partials._sessionError')
		<div class="invoice-box rtl">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="{{ URL::asset('dashboard_files/assets/img/brand/logo-wd.png') }}" style="width: 100%; max-width: 300px" />
								</td>

								<td>
									<strong>{{ __('translation.general_assembly_members') }}</strong><br />
									{{ __('translation.membership_no') }}: {{ $invoice->general_assembly_member->membership_no ?? __('translation.null') }}<br />
									{{ __('translation.created_at') }}: {{ $invoice->created_at->format('d/m/Y') }}<br />
									{{ __('translation.invoice_status') }}: {{ __('translation.' . $invoice->invoice_status) }}<br />
									<img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('general-assembly-member-invoice.show', [$invoice->invoice_no, $invoice->general_assembly_member->uuid]) }}" alt="qr-code" height="auto" style="margin-top: 10px;">
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									{{ $setting->name }}<br />
									{{ $setting->address }}<br />
									{{ $setting->email }}<br />
                                    {{ $setting->phone }}
								</td>

								<td>
									{{ __('dashboard.phone') }}: {{ $invoice->general_assembly_member->phone ?? __('translation.null') }}<br />
                                    {{ __('dashboard.name') }}: {{ $invoice->general_assembly_member->full_name ?? '--- --- --- --' }}<br />
									{{ __('dashboard.email') }}: {{ $invoice->general_assembly_member->email ?? '--- --- --- --' }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>{{ __('translation.payment_ways') }}</td>

					<td>{{ __('translation.invoice_no') }}</td>
				</tr>

				<tr class="details">
					<td>{{ $invoice->payment_ways === 'bank_transfer' ? __('translation.' . $invoice->payment_ways) : $invoice->payment_brand }}</td>

					<td>{{ $invoice->invoice_no }}</td>
				</tr>

                <tr class="heading">
                    <td>{{ __('translation.subscription_date') }}</td>
                    <td>{{ __('translation.expiry_date') }}</td>
                </tr>

                <tr class="item">
                    <td>{{ $invoice->subscription_date ?? __('translation.null') }}</td>
                    <td>{{ $invoice->expiry_date ?? __('translation.null') }}</td>
                </tr>

				<tr class="total">
					<td>
                        {{-- style="color: #f80;" --}}
                        <span>يتم إستقطاع نسبة 15% من الإجمالي نظير التشغيل.</span>
                    </td>

					<td>{{ __('dashboard.total_amount') }}: {{ $invoice->total_amount . ' ' . __('dashboard.SAR') }}</td>
				</tr>
			</table>
		</div>

        @auth('donor')
            <div class="text-center mt-20"><a href="{{ route('frontend.profile.show-profile-information', auth('donor')->user()->username) }}">إضغط للعودة إلي ملفك الشخصي</a> <i class="fas fa-arrow-alt-circle-left"></i></div>
        @endauth

        <script src="{{ URL::asset('frontend_files/assets/js/jquery-3.5.1.min.js') }}"></script>
        <!-- template js -->
        <script src="{{ URL::asset('frontend_files/assets/js/jquery-ui.js') }}"></script>
        <script src="{{ URL::asset('frontend_files/assets/js/jquery-ui.js') }}"></script>
        <script src="{{ URL::asset('frontend_files/assets/js/theme.js') }}"></script>
	</body>
</html>
