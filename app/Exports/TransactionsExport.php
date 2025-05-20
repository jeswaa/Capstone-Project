<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $reportData = [];

        // Monthly Overview
        if (isset($this->data['totalBookings'])) {
            $reportData[] = [
                'Section' => 'Monthly Overview',
                'Metric' => 'Total Bookings',
                'Value' => $this->data['totalBookings']
            ];
        }
        
        if (isset($this->data['confirmedBookings'])) {
            $reportData[] = [
                'Section' => 'Monthly Overview',
                'Metric' => 'Confirmed Bookings',
                'Value' => $this->data['confirmedBookings']
            ];
        }
        
        if (isset($this->data['adultGuests'])) {
            $reportData[] = [
                'Section' => 'Monthly Overview',
                'Metric' => 'Adult Guests',
                'Value' => $this->data['adultGuests']
            ];
        }
        
        if (isset($this->data['childGuests'])) {
            $reportData[] = [
                'Section' => 'Monthly Overview',
                'Metric' => 'Child Guests',
                'Value' => $this->data['childGuests']
            ];
        }

        // Booking Statistics
        if (isset($this->data['mostBookedRoomType'])) {
            $reportData[] = [
                'Section' => 'Booking Statistics',
                'Metric' => 'Most Booked Room Type',
                'Value' => $this->data['mostBookedRoomType']
            ];
        }
        
        if (isset($this->data['cancelledBookings'])) {
            $reportData[] = [
                'Section' => 'Booking Statistics',
                'Metric' => 'Cancelled Bookings',
                'Value' => $this->data['cancelledBookings']
            ];
        }
        
        if (isset($this->data['cancellationPercentage'])) {
            $reportData[] = [
                'Section' => 'Booking Statistics',
                'Metric' => 'Cancellation Rate',
                'Value' => $this->data['cancellationPercentage'] . '%'
            ];
        }

        // Payment Status Breakdown
        if (isset($this->data['paymentStatusData'])) {
            foreach ($this->data['paymentStatusData'] as $status => $count) {
                $reportData[] = [
                    'Section' => 'Payment Status',
                    'Metric' => ucfirst($status),
                    'Value' => $count
                ];
            }
        }

        return new Collection($reportData);
    }

    public function headings(): array
    {
        return [
            'Section',
            'Metric',
            'Value'
        ];
    }

    public function map($row): array
    {
        return [
            $row['Section'],
            $row['Metric'],
            $row['Value']
        ];
    }
}