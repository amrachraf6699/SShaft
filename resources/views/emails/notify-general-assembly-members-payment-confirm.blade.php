<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!--[if mso]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <style>
            table {border-collapse: collapse;}
            .spacer,.divider {mso-line-height-rule: exactly;}
            td,th,div,p,a {font-size: 13px; line-height: 23px;}
            td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family:"Segoe UI",Helvetica,Arial,sans-serif;}
        </style>
        <![endif]-->

        <style type="text/css">
            table, tbody, td, th{
            direction: rtl
            }
            @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,700');
            @media only screen {
            .column, th, td, div, p {font-family: -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto",Helvetica,Arial,sans-serif;}
            .serif {font-family: "Montserrat",-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto",Helvetica,Arial,sans-serif;}
            .sans-serif {font-family: "Open Sans",-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto",Helvetica,Arial,sans-serif;}
            }

            a {text-decoration: none;}
            img {border: 0; line-height: 100%; max-width: 100%; vertical-align: middle;}

            .wrapper {min-width: 700px;}
            .row {margin: 0 auto; width: 700px;}
            .row .row, th .row {width: 100%;}
            .column {font-size: 13px; line-height: 23px;}

            @media only screen and (max-width: 699px) {

            .wrapper {min-width: 100% !important;}
            .row {width: 90% !important;}
            .row .row {width: 100% !important;}

            .column {
                box-sizing: border-box;
                display: inline-block !important;
                line-height: inherit !important;
                width: 100% !important;
                word-break: break-word;
                -webkit-text-size-adjust: 100%;
            }
            .mobile-1  {max-width: 8.33333%;}
            .mobile-2  {max-width: 16.66667%;}
            .mobile-3  {max-width: 25%;}
            .mobile-4  {max-width: 33.33333%;}
            .mobile-5  {max-width: 41.66667%;}
            .mobile-6  {max-width: 50%;}
            .mobile-7  {max-width: 58.33333%;}
            .mobile-8  {max-width: 66.66667%;}
            .mobile-9  {max-width: 75%;}
            .mobile-10 {max-width: 83.33333%;}
            .mobile-11 {max-width: 91.66667%;}
            .mobile-12 {
                padding-right: 30px !important;
                padding-left: 30px !important;
            }

            .mobile-offset-1  {margin-left: 8.33333% !important;}
            .mobile-offset-2  {margin-left: 16.66667% !important;}
            .mobile-offset-3  {margin-left: 25% !important;}
            .mobile-offset-4  {margin-left: 33.33333% !important;}
            .mobile-offset-5  {margin-left: 41.66667% !important;}
            .mobile-offset-6  {margin-left: 50% !important;}
            .mobile-offset-7  {margin-left: 58.33333% !important;}
            .mobile-offset-8  {margin-left: 66.66667% !important;}
            .mobile-offset-9  {margin-left: 75% !important;}
            .mobile-offset-10 {margin-left: 83.33333% !important;}
            .mobile-offset-11 {margin-left: 91.66667% !important;}

            .has-columns {
                padding-right: 20px !important;
                padding-left: 20px !important;
            }

            .has-columns .column {
                padding-right: 10px !important;
                padding-left: 10px !important;
            }

            .mobile-collapsed .column {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .mobile-center {
                display: table !important;
                float: none;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .mobile-left {
                float: none;
                margin: 0 !important;
            }
            .mobile-text-center {text-align: center !important;}
            .mobile-text-left   {text-align: right !important;}
            .mobile-text-right  {text-align: right !important;}

            .mobile-valign-top  {vertical-align: top !important;}

            .mobile-full-width {
                display: table;
                width: 100% !important;
            }

            .spacer                     {height: 30px; line-height: 100% !important; font-size: 100% !important;}
            .divider th                 {height: 60px;}
            .mobile-padding-top         {padding-top: 30px !important;}
            .mobile-padding-top-mini    {padding-top: 10px !important;}
            .mobile-padding-bottom      {padding-bottom: 30px !important;}
            .mobile-padding-bottom-mini {padding-bottom: 10px !important;}
            .mobile-margin-top          {margin-top: 30px !important;}
            .mobile-margin-top-mini     {margin-top: 10px !important;}
            .mobile-margin-bottom       {margin-bottom: 30px !important;}
            .mobile-margin-bottom-mini  {margin-bottom: 10px !important;}
            }
        </style>
    </head>
    <body style="box-sizing:border-box;margin:0;padding:0;width:100%;-webkit-font-smoothing:antialiased;">
        @php
            $setting = setting()
        @endphp
        <table class="wrapper" align="center" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0" width="100%" role="presentation">
            <tr>
                <td style="padding: 30px 0;">
                    <!-- Header -->
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column" width="700">
                                {!! !empty($setting->header_temp) ? $setting->header_temp : '' !!}
                            </th>
                        </tr>
                    </table>
                    <!-- /Header -->

                    <!-- Intro Basic -->
                    <table class="row" align="center" bgcolor="#F8F8F8" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column has-columns" width="640" style="padding-left: 30px; padding-right: 30px;">
                                <table class="row" align="center" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <th class="column" width="640" style="text-align: right;">
                                            <div class="serif" style="color: #1F2225; font-size: 28px; font-weight: 700; line-height: 50px; margin-bottom: 30px; margin-top:20px">مرحباً {{ $invoice['member_name'] }}</div>
                                            <div class="sans-serif" style="font-size: 18px; font-weight: 400; line-height: 28px; margin-bottom: 40px;direction: rtl;">
                                                @if ($invoice['invoice_status'] == 'paid')
                                                    <p>
                                                        عزيزي العميل تمت عملية الدفع بنجاح، نتشرف بك كواحد من أعضاء {{ $setting->name }} العمومية بجمعية، نشكر لكم ثقتكم بنا . <br>
                                                        تفحص الرمز أدناه للإطلاع علي الفاتورة، وإليكم معلومات العضوية الخاصة بكم:
                                                    </p>
                                                    <p>
                                                        كود العضوية: {{ $invoice['member_membership_no'] }} <br>
                                                        رابط شهادة عضو جمعية عمومية: <a href="{{ route('frontend.certificate-of-general-assembly-member.show', $invoice['member_uuid']) }}">
                                                                                    {{ route('frontend.certificate-of-general-assembly-member.show', $invoice['member_uuid']) }}
                                                                                </a> <br>
                                                    </p>
                                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('general-assembly-member-invoice.show', [$invoice['invoice_no'], $invoice['member_uuid']]) }}" alt="Full Width Image" width="20%" style="display:block; margin: 0 auto; margin-bottom:20px">
                                                    <p>
                                                        رابط الفاتورة: <br>
                                                        <a href="{{ route('general-assembly-member-invoice.show', [$invoice['invoice_no'], $invoice['member_uuid']]) }}">
                                                            {{ route('general-assembly-member-invoice.show', [$invoice['invoice_no'], $invoice['member_uuid']]) }}
                                                        </a>
                                                    </p>
                                                @elseif ($invoice['invoice_status'] == 'unpaid')
                                                    <p>
                                                        عزيزي العميل عفواً لم تتم عملية الدفع بنجاح. <br>
                                                        تفحص الرمز أدناه للإطلاع علي الفاتورة، وإليكم معلومات العضوية الخاصة بكم:
                                                    </p>

                                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ route('frontend.pay-general-assembly-members.choose-payment-method.view', [$invoice['member_uuid'], $invoice['invoice_no']]) }}" alt="Full Width Image" width="20%" style="display:block; margin: 0 auto; margin-bottom:20px">
                                                    <p>
                                                        رابط إتمام عملية الدفع: <br>
                                                        <a href="{{ route('frontend.pay-general-assembly-members.choose-payment-method.view', [$invoice['member_uuid'], $invoice['invoice_no']]) }}">
                                                            {{ route('frontend.pay-general-assembly-members.choose-payment-method.view', [$invoice['member_uuid'], $invoice['invoice_no']]) }}
                                                        </a>
                                                    </p>
                                                @elseif ($invoice['invoice_status'] == 'awaiting_verification')
                                                    <p>
                                                        عزيزي العميل لقد تمت العملية بنجاح وهي الآن في إنتظار التأكيد من الإدارة، وسيتم التواصل معكم فور التأكد من صحة وسلامة بيانات عملية الدفع. <br>
                                                        نشكر لكم ثقتكم {{ $setting->name }}.
                                                    </p>
                                                @endif
                                            </div>
                                        </th>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                    <!-- /Intro Basic -->

                    <!-- Footer  -->
                    <table class="row" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <th class="column" width="700">
                                {!! !empty($setting->footer_temp) ? $setting->footer_temp : '' !!}
                            </th>
                        </tr>
                    </table>
                    <!-- /Footer  -->
                </td>
            </tr>
        </table>
    </body>
</html>

