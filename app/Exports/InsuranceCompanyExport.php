<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InsuranceCompanyExport implements FromView
{
    protected $data;

    public function __construct($insuranceData)
    {
        $this->data = $insuranceData;
    }

    public function view(): View
    {
        return view('admin.exports.insurance-company-export', [
            'insuranceData' => $this->data
        ]);
    }
}
