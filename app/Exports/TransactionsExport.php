<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = DB::table('reservation_details')
            ->join('users', 'reservation_details.user_id', '=', 'users.id')
            ->select(
                'users.name',
                'reservation_details.reservation_check_in_date',
                'reservation_details.reservation_check_out_date',
                'reservation_details.amount',
                'reservation_details.payment_status',
                'reservation_details.created_at'
            );

        // Apply filters if they exist
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereBetween('reservation_check_in_date', [
                $this->request->start_date,
                $this->request->end_date
            ]);
        }

        if ($this->request->filled('payment_status')) {
            $query->where('payment_status', $this->request->payment_status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Guest Name',
            'Check In Date',
            'Check Out Date',
            'Amount',
            'Payment Status',
            'Reservation Date'
        ];
    }
}