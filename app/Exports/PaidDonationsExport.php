<?php

namespace App\Exports;

use App\Branch;
use App\Donation;
use App\DonationService;
use Carbon\Traits\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PaidDonationsExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths
{
    
    protected $keyword;
    protected $branchId;
    protected $serviceId;
    protected $paymentWays;
    protected $sortBy;
    protected $orderBy;
    
    public function __construct($keyword, $branchId, $serviceId, $paymentWays, $sortBy, $orderBy)
    {
        $this->keyword = $keyword;
        $this->branchId = $branchId;
        $this->serviceId = $serviceId;
        $this->paymentWays = $paymentWays;
        $this->sortBy = $sortBy;
        $this->orderBy = $orderBy;
    }
    
    
    /**
    * @return \Illuminate\Support\Collection
    */
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $donations = Donation::query()
            ->paid()
            ->withCount('services')
            ->with(['donor:id,membership_no', 'services']);

        if ($this->keyword != null) {
            $donations = $donations->search($this->keyword);
        }

        if ($this->branchId != null) {
            $donations = $donations->where('branch_id', $this->branchId);
        }

        if ($this->serviceId != null) {
            $donations = $donations->whereHas('services', function ($q) {
                $q->whereServiceId($this->serviceId);
            });
        }

        if ($this->paymentWays != null) {
            $donations = $donations->wherePaymentWays($this->paymentWays);
        }

        $donations = $donations->orderBy($this->sortBy, $this->orderBy)->get();

        return $donations;
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
            Branch::find($donation->branch_id)->name ?? '-',
            $donation->payment_ways == 'bank_transfer' ? $donation->bank_name : '-',
            json_decode($donation->response)->rrn ?? '-',
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
            __('الفرع'),
            __('translation.bank_name'),
            __('رقم التحويل'),
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
