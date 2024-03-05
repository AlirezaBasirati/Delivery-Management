<?php

namespace App\Services\OrderService\Exports\V1;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public array $headings = [];
    public function __construct(private readonly Collection $reports)
    {
        if ($row = $this->reports->first()) {
            $this->headings = array_keys($row->toArray());

            if (isset($row->driver_id)) {
                $this->headings[] = 'driver';
                unset($this->headings[array_search('driver_id', $this->headings)]);
            }

            if (isset($row->vehicle_id)) {
                $this->headings[] = 'vehicle';
                unset($this->headings[array_search('vehicle_id', $this->headings)]);
            }

            if (isset($row->last_status_id)) {
                $this->headings[] = 'last_status';
                unset($this->headings[array_search('last_status_id', $this->headings)]);
            }
        }
    }

    public function collection(): Collection
    {
        return $this->reports->map(function ($order) {
            $row = $order->toArray();

            if (isset($order->driver_id)) {
                $driver = optional($order->driver)->user;
                $row['driver'] = $driver ? "$driver->first_name $driver->last_name" : "";
                unset($row['driver_id']);
            }

            if (isset($order->vehicle_id)) {
                $row['vehicle'] = $order->vehicle?->title;
                unset($row['vehicle_id']);
            }

            if (isset($order->last_status_id)) {
                $row['last_status'] = $order->lastStatus->title;
                unset($row['last_status_id']);
            }

            return $row;
        });
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
