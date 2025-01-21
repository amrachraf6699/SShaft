<?php

namespace App\Traits;

use TaqnyatSms;

trait SendSmsToTheGeneralAssemblyMember
{
    public function register($to, array $member)
    {
        $setting = setting();
        // Sending a SMS using Taqnyat API and PHP is easy as the following:
        $bearer = $setting->sms_token;
        $sender = $setting->sms_sender;
        $taqnyt = new TaqnyatSms($bearer);

        if ($member['status'] == 'pending') {
            $message = __('assembly-members.Register status is pending',
                        ['name' => $member['name'], 'status' => __('translation.' . $member['status'])]);
        } elseif ($member['status'] == 'awaiting_payment') {
            $route = route('frontend.pay-general-assembly-members.choose-payment-method.view', [$member['uuid'], $member['invoice_no']]);
            $message = __('assembly-members.Register status is awaiting payment',
                        ['name' => $member['name'], 'amount' => $member['total_amount'], 'route' => $route]);
        } elseif ($member['status'] == 'active') {
            $certificate_route = route('frontend.certificate-of-general-assembly-member.show', $member['uuid']);
            $invoice_route = route('general-assembly-member-invoice.show', [$member['invoice_no'], $member['uuid']]);
            $message = __('assembly-members.Register status is active',
                        ['name' => $member['name'], 'membership_no' => $member['membership_no'], 'certificate_route' => $certificate_route, 'invoice_route' => $invoice_route]);
        } elseif ($member['status'] == 'inactive') {
            $message = __('assembly-members.Register status is inactive', ['name' => $member['name']]);
        } elseif ($member['status'] == 'rejected') {
            $message = __('assembly-members.Register status is rejected', ['name' => $member['name']]);
        }

        $body       = $message;
        $recipients = $to;

        $taqnyt->sendMsg($body, $recipients, $sender);
    }

    public function confirm($to, array $invoice)
    {
        $setting = setting();
        // Sending a SMS using Taqnyat API and PHP is easy as the following:
        $bearer = $setting->sms_token;
        $sender = $setting->sms_sender;
        $taqnyt = new TaqnyatSms($bearer);

        if ($invoice['invoice_status'] == 'paid') {
            $certificate_route  = route('frontend.certificate-of-general-assembly-member.show', $invoice['member_uuid']);
            $invoice_route      = route('general-assembly-member-invoice.show', [$invoice['invoice_no'], $invoice['member_uuid']]);
            $message = __('assembly-members.Invoice status paid',
                        ['name' => $invoice['member_name'], 'membership_no' => $invoice['member_membership_no'], 'certificate_route' => $certificate_route, 'invoice_route' => $invoice_route]);
        } elseif ($invoice['invoice_status'] == 'unpaid') {
            $route   = route('general-assembly-member-invoice.show', [$invoice['invoice_no'], $invoice['member_uuid']]);
            $message = __('assembly-members.Invoice status unpaid', ['name' => $invoice['member_name'], 'route' => $route]);
        } elseif ($invoice['invoice_status'] == 'awaiting_verification') {
            $message = __('assembly-members.Invoice status awaiting verification', ['name' => $invoice['member_name']]);
        }

        $body       = $message;
        $recipients = $to;

        // $taqnyt->sendMsg($body, $recipients, $sender);
    }
}
