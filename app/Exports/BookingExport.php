<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private ?int $month,
        private ?int $year
    ) {}

    public function query()
    {
        $query = Booking::with(['vehicle', 'driver', 'createdBy', 'approvals.approver']);

        if ($this->month && $this->year) {
            $query->whereMonth('created_at', $this->month)
                  ->whereYear('created_at', $this->year);
        } elseif ($this->year) {
            $query->whereYear('created_at', $this->year);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Kode Booking',
            'Nama Pemohon',
            'Kendaraan',
            'No. Polisi',
            'Driver',
            'Tujuan',
            'Keberangkatan',
            'Estimasi Kembali',
            'Penumpang',
            'Status',
            'Approver L1',
            'Approver L2',
            'Dibuat Oleh',
            'Tanggal Dibuat',
        ];
    }

    public function map($booking): array
    {
        $approvalL1 = $booking->approvals->where('level', 1)->first();
        $approvalL2 = $booking->approvals->where('level', 2)->first();

        return [
            $booking->booking_code,
            $booking->requester_name,
            $booking->vehicle?->name,
            $booking->vehicle?->plate_number,
            $booking->driver?->name,
            $booking->destination,
            $booking->start_datetime?->format('d/m/Y H:i'),
            $booking->end_datetime?->format('d/m/Y H:i'),
            $booking->passenger_count,
            $booking->status,
            $approvalL1?->approver?->name . ' (' . $approvalL1?->status . ')',
            $approvalL2?->approver?->name . ' (' . $approvalL2?->status . ')',
            $booking->createdBy?->name,
            $booking->created_at?->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}