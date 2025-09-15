<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromQuery, WithHeadings, WithStyles, WithEvents,
    WithColumnFormatting, ShouldAutoSize, WithMapping
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class ErfExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithEvents, WithColumnFormatting, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
{
    $query = DB::table('industry_master_data')
        ->join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
        ->select(
            'industry_master_data.policy_number',
            'industry_master_data.name_of_insured_owner',
            'industry_master_data.erf_deposit_utr_no',
            'industry_master_data.contribution_to_erf_rs',
            'industry_master_data.date_of_erf_payment',
            'api_keys.name_of_general_insurance_company as insurance_company'
        )->distinct()
        ->when(!empty($this->filters['user_id']), fn($q) =>
            $q->where('industry_master_data.user_id', $this->filters['user_id']))
        ->when(!empty($this->filters['year']), fn($q) =>
            $q->whereYear('industry_master_data.date_of_erf_payment', $this->filters['year']))
        ->when(!empty($this->filters['start_date']) && !empty($this->filters['end_date']), fn($q) =>
            $q->whereBetween('industry_master_data.date_of_erf_payment', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ])
        )
        ->when(!empty($this->filters['erf_deposit_utr_no']), fn($q) =>
            $q->where('industry_master_data.erf_deposit_utr_no', $this->filters['erf_deposit_utr_no']));

    // ✅ Fix for DOMPDF requirement
    return $query->orderBy('industry_master_data.date_of_erf_payment', 'desc');
}


    public function headings(): array
    {
        return [
            'Policy Number',
            'Owner Name',
            'UTR Number',
            'Contribution (₹)',
            'Date of Payment',
            'Insurance Company'
        ];
    }

    public function map($row): array
    {
        return [
            $row->policy_number,
            $row->name_of_insured_owner,
            $row->erf_deposit_utr_no,
            (float)$row->contribution_to_erf_rs,
            $row->date_of_erf_payment,
            $row->insurance_company,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Contribution column
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Add border to all cells
                $sheet->getStyle('A1:F' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Add total at bottom
                $totalCell = 'D' . ($highestRow + 1);
                $sheet->setCellValue('C' . ($highestRow + 1), 'Total');
                $sheet->setCellValue($totalCell, '=SUM(D2:D' . $highestRow . ')');
                $sheet->getStyle($totalCell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $sheet->getStyle('C' . ($highestRow + 1))->getFont()->setBold(true);
                $sheet->getStyle($totalCell)->getFont()->setBold(true);
            }
        ];
    }
}




