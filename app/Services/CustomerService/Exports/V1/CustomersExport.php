<?php

namespace App\Services\CustomerService\Exports\V1;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    function __construct(private readonly Collection $customers)
    {
        //
    }

    public function collection(): Collection
    {
        return $this->customers->map(function ($customers) {
            return [
                'user_id'           => $customers->user_id,
                'type'              => $customers->type,
                'balance'           => $customers->balance,
                'phone'             => $customers->phone,
                'address'           => $customers->address,
                'is_blocked'        => $customers->is_blocked,
                'verification_code' => $customers->verification_code,
                'verified_mobile'   => $customers->verified_mobile,
                'verified_at'       => $customers->verified_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'user_id',
            'type',
            'balance',
            'phone',
            'address',
            'is_blocked',
            'verification_code',
            'verified_mobile',
            'verified_at',
        ];
    }
}
