<?php

namespace App\Exports;

use App\Donation;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UnpaidDonationsExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Donation::orderBy('id', 'DESC')->unpaid()
                        ->select('id', 'donation_code', 'total_amount', 'payment_ways', 'payment_brand', 'bank_name', 'donor_id', 'donation_type', 'status', 'created_at')
                        ->get();
    }

    /**
    * @var Donation $donation
    */
    public function map($donation): array
    {
        return [
            $donation->donor->membership_no ?? '-',
            $donation->donor->name ?? '-',
            $donation->donor->phone ?? '-',
            donations_title_services($donation->id),
            $donation->donation_code,
            $donation->total_amount,
            __('translation.' . $donation->donation_type),
            __('translation.' . $donation->status),
            __('translation.' . $donation->payment_ways),
            $donation->payment_ways == 'credit_card' ? $donation->payment_brand : '-',
            $donation->payment_ways == 'bank_transfer' ? $donation->bank_name : '-',
            $donation->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            __('translation.membership_no'),
            __('dashboard.name'),
            __('dashboard.phone'),
            __('translation.services'),
            __('translation.donation_code'),
            __('dashboard.total_amount'),
            __('translation.donation_type'),
            __('dashboard.status'),
            __('translation.payment_ways'),
            __('translation.payment_brand'),
            __('translation.bank_name'),
            __('dashboard.created_at'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 12,
            'D' => 20,
            'E' => 12,
            'F' => 8,
            'G' => 10,
            'H' => 12,
            'I' => 10,
            'J' => 20,
            'K' => 12,
            'L' => 12,
        ];
    }
}
